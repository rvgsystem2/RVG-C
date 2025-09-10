<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

  public function index(Request $r)
    {
        $status = $r->query('status');             // created | paid | failed
        $q      = trim((string)$r->query('q'));    // search
        $from   = $r->query('from');               // YYYY-MM-DD
        $to     = $r->query('to');                 // YYYY-MM-DD
        $sort   = in_array($r->query('sort'), ['created_at','amount','status']) ? $r->query('sort') : 'created_at';
        $dir    = $r->query('dir') === 'asc' ? 'asc' : 'desc';

        $orders = PaymentOrder::with('package')
            ->when($status, fn($q2) => $q2->where('status', $status))
            ->when($q, function($q2) use ($q) {
                $q2->where(function($w) use ($q) {
                    $w->where('name', 'like', "%$q%")
                      ->orWhere('phone', 'like', "%$q%")
                      ->orWhere('business_name', 'like', "%$q%")
                      ->orWhere('razorpay_order_id', 'like', "%$q%")
                      ->orWhere('razorpay_payment_id', 'like', "%$q%");
                });
            })
            ->when($from, fn($q2) => $q2->whereDate('created_at', '>=', $from))
            ->when($to,   fn($q2) => $q2->whereDate('created_at', '<=', $to))
            ->orderBy($sort, $dir)
            ->paginate(20)
            ->withQueryString();

        // quick stats
        $stats = [
            'total' => PaymentOrder::count(),
            'paid'  => PaymentOrder::where('status','paid')->count(),
            'failed'=> PaymentOrder::where('status','failed')->count(),
            'created'=>PaymentOrder::where('status','created')->count(),
            'revenue'=> PaymentOrder::where('status','paid')->sum('amount'),
        ];

        return view('backend.purchases.index', compact('orders','stats','status','q','from','to','sort','dir'));
    }

    public function showed(PaymentOrder $po)
    {
        $po->load('package');
        return view('backend.purchases.show', compact('po'));
    }

    
    public function show(Package $package)
    {
        return view('front.packagebuy', compact('package'));
    }

   public function createOrder(Request $r)
    {
        $data = $r->validate([
            'package_id'    => 'required|exists:packages,id',
            'name'          => 'nullable|string|max:120',
            'phone'         => 'required|digits_between:10,14',   // allow 10-14 digit phone
            'business_name' => 'nullable|string|max:160',
            // DO NOT accept amount from client; we compute it on the server
        ]);

        try {
            $package = Package::findOrFail($data['package_id']);

            // Prefer config/services.php; fallback to env if not set
            $key    = config('services.razorpay.key', env('RAZORPAY_KEY'));
            $secret = config('services.razorpay.secret', env('RAZORPAY_SECRET'));

            if (empty($key) || empty($secret)) {
                \Log::error('Razorpay keys missing', ['key' => (bool)$key, 'secret' => (bool)$secret]);
                return response()->json(['message' => 'Payment gateway not configured.'], 500);
            }

            // ===== Final amount (GST already included in your prices) =====
            $mrp  = (float) $package->price;                                   // inclusive MRP
            $sale = $package->sale_price !== null ? (float) $package->sale_price : null; // inclusive sale price
            $final = ($sale !== null && $sale > 0 && $sale < $mrp) ? $sale : $mrp;
            if ($final < 1) {
                return response()->json(['message' => 'Invalid amount.'], 422);
            }

            $amountPaise = (int) round($final * 100);

            $api   = new Api($key, $secret);
            $order = $api->order->create([
                'receipt'  => 'rcpt_' . Str::random(10),
                'amount'   => $amountPaise,  // paise, GST included
                'currency' => 'INR',
            ]);

            // Persist our expectation for verify()
            $po = PaymentOrder::create([
                'package_id'        => $package->id,
                'name'              => $data['name'] ?? null,
                'phone'             => $data['phone'],
                'business_name'     => $data['business_name'] ?? null,
                'amount'            => $final,        // store GST-inclusive total
                'currency'          => 'INR',
                'razorpay_order_id' => $order['id'],
                'status'            => 'created',
                // Optional: if you have columns, you may also store breakdown:
                // 'subtotal' => $mrp, 'tax_rate' => 18, 'tax_amount' => $mrp - ($mrp / 1.18), etc.
            ]);

            return response()->json([
                'order_id'      => $order['id'],
                'currency'      => 'INR',
                'key'           => $key,
                'merchant_name' => config('app.name', 'Real Victory Groups'),
                'description'   => $package->name . ' — Package Purchase',
                'prefill'       => [
                    'name'    => $po->name,
                    'contact' => $po->phone,
                ],
            ]);

        } catch (\Throwable $e) {
            \Log::error('Razorpay order create failed', ['err' => $e->getMessage()]);
            return response()->json(['message' => 'Unable to start payment.'], 500);
        }
    }


    public function verify(Request $r)
    {
        $payload = $r->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        $key    = env('RAZORPAY_KEY');
        $secret = env('RAZORPAY_SECRET');

        $po = PaymentOrder::where('razorpay_order_id', $payload['razorpay_order_id'])->firstOrFail();

        try {
            $api = new Api($key, $secret);

            // SDK-based signature verification (reliable)
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $payload['razorpay_order_id'],
                'razorpay_payment_id' => $payload['razorpay_payment_id'],
                'razorpay_signature'  => $payload['razorpay_signature'],
            ]);

            // (Optional) Cross-check payment amount/currency
            $payment = $api->payment->fetch($payload['razorpay_payment_id']);
            $expectedAmountPaise = (int) round($po->amount * 100);
            if ((int)$payment['amount'] !== $expectedAmountPaise || $payment['currency'] !== $po->currency) {
                \Log::warning('Razorpay amount/currency mismatch', [
                    'expected_amount_paise' => $expectedAmountPaise,
                    'payment_amount'        => $payment['amount'],
                    'expected_currency'     => $po->currency,
                    'payment_currency'      => $payment['currency'],
                ]);
                // You can choose to fail here if strict matching required.
            }
   $po->load('package');
            $po->update([
                'razorpay_payment_id' => $payload['razorpay_payment_id'],
                'razorpay_signature'  => $payload['razorpay_signature'],
                'status'              => 'paid',
            ]);

             // ⭐ Thank-you page के लिए session में details
            $r->session()->put('thankyou', [
                'package_name' => $po->package->name ?? 'Package',
                'payment_id'   => $payload['razorpay_payment_id'],
                'order_id'     => $payload['razorpay_order_id'],
                'amount'       => $po->amount,
                'currency'     => $po->currency,
                'paid_at'      => now()->format('d M Y, h:i A'),
            ]);

            return response()->json(['ok' => true, 'redirect' => url('/thank-you')]);

        } catch (SignatureVerificationError $e) {
            \Log::error('Razorpay signature verify failed', [
                'msg' => $e->getMessage(),
                'order_id' => $payload['razorpay_order_id'],
            ]);
            $po->update(['status' => 'failed']);
            return response()->json(['ok' => false, 'message' => 'Invalid payment signature'], 422);

        } catch (\Throwable $e) {
            \Log::error('Razorpay verify exception', ['err' => $e->getMessage()]);
            return response()->json(['ok' => false, 'message' => 'Verification error'], 500);
        }
    }
}
