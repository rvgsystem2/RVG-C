<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentLinkController extends Controller
{

    public function index(Request $r)
    {
        $q = trim((string)$r->query('q'));
        $status = $r->query('status');

        $orders = PaymentOrder::with('package')
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('business_name', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhereHas('package', fn($p) => $p->where('name', 'like', "%{$q}%"));
                });
            })
            ->when($status, fn($qq) => $qq->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('backend.purchases.indexdiscountuser', compact('orders'));
    }

    /** CREATE form */
    public function create()
    {
        $packages = Package::orderBy('name')->get(['id', 'name', 'price', 'sale_price']);
        return view('backend.purchases.create_link', compact('packages'));
    }

    /** STORE → generate link_token + amount_payable */
    public function store(Request $r)
    {
        $data = $r->validate([
            'package_id'     => 'required|exists:packages,id',
            'name'           => 'nullable|string|max:120',
            'phone'          => ['required', 'regex:/^91[0-9]{10}$/'], // 91 + 10 digits
            'business_name'  => 'nullable|string|max:160',
            'discount_type'  => 'required|in:none,flat,percent',
            'discount_value' => 'required|numeric|min:0',
            'discount_reason' => 'nullable|string|max:255',
            'expires_at'     => 'nullable|date',
        ]);

        $pkg  = Package::findOrFail($data['package_id']);
        $base = $pkg->sale_price ?? $pkg->price;

        $disc = 0;
        if ($data['discount_type'] === 'flat') {
            $disc = min($data['discount_value'], $base);
        } elseif ($data['discount_type'] === 'percent') {
            $disc = min(($base * $data['discount_value']) / 100, $base);
        }

        $order = PaymentOrder::create([
            'link_token'     => Str::random(40),        // ✅ unique public link
            'package_id'     => $pkg->id,
            'created_by'     => auth()->id(),
            'name'           => $data['name'] ?? null,
            'phone'          => $data['phone'],
            'business_name'  => $data['business_name'] ?? null,
            'amount'         => $base,
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'amount_payable' => max($base - $disc, 0),
            'discount_reason' => $data['discount_reason'] ?? null,
            'currency'       => 'INR',
            'status'         => 'created',
            'expires_at'     => $data['expires_at'] ?? null,
        ]);

        // flash the public URL so you can copy it immediately
        return redirect()
            ->route('paylink.index')
            ->with('ok', 'Payment link created successfully.')
            ->with('url', url('/pay/' . $order->link_token)); // ✅
    }

    public function edit(PaymentOrder $paymentLink)
    {
        $packages = Package::orderBy('name')->get(['id', 'name', 'price', 'sale_price']);
        return view('backend.purchases.edit_link', compact('paymentLink', 'packages'));
    }

    public function update(Request $r, PaymentOrder $paymentLink)
    {
        $data = $r->validate([
            'package_id'     => 'required|exists:packages,id',
            'name'           => 'nullable|string|max:120',
            'phone'          => ['required', 'regex:/^91[0-9]{10}$/'],
            'business_name'  => 'nullable|string|max:160',
            'discount_type'  => 'required|in:none,flat,percent',
            'discount_value' => 'required|numeric|min:0',
            'discount_reason' => 'nullable|string|max:255',
            'expires_at'     => 'nullable|date',
        ]);

        $pkg  = Package::findOrFail($data['package_id']);
        $base = $pkg->sale_price ?? $pkg->price;

        $disc = 0;
        if ($data['discount_type'] === 'flat') {
            $disc = min($data['discount_value'], $base);
        } elseif ($data['discount_type'] === 'percent') {
            $disc = min(($base * $data['discount_value']) / 100, $base);
        }

        $paymentLink->update([
            'package_id'     => $pkg->id,
            'name'           => $data['name'] ?? null,
            'phone'          => $data['phone'],
            'business_name'  => $data['business_name'] ?? null,
            'amount'         => $base,
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'amount_payable' => max($base - $disc, 0),
            'discount_reason' => $data['discount_reason'] ?? null,
            'expires_at'     => $data['expires_at'] ?? null,
        ]);

        return redirect()->route('paylink.index')->with('ok', 'Payment link updated.');
    }

    public function destroy(PaymentOrder $paymentLink)
    {
        $paymentLink->delete();
        return redirect()->route('paylink.index')->with('ok', 'Payment link deleted.');
    }


   public function phoneForm(string $token)
    {
        $order = PaymentOrder::with('package')->where('link_token', $token)->firstOrFail();

        if ($order->status === 'paid') {
            return view('public.pay_status', ['status' => 'paid', 'order' => $order]);
        }
        if ($order->expires_at && now()->greaterThan($order->expires_at)) {
            return view('public.pay_status', ['status' => 'expired', 'order' => $order]);
        }

        $amountPaise = (int) round(100 * ($order->amount_payable ?? $order->amount ?? 0));
        return view('public.pay_enter_phone', [
            'order'  => $order,
            'amount' => $amountPaise, // in paise
        ]);
    }

    /** AJAX: check phone and gate the Pay button */
    public function checkPhone(Request $r, string $token)
    {
        $r->validate(['phone' => ['required', 'regex:/^91[0-9]{10}$/']]);

        $order = PaymentOrder::where('link_token', $token)->first();
        if (!$order) {
            return response()->json(['ok' => false, 'msg' => 'Invalid link'], 404);
        }
        if ($order->status === 'paid') {
            return response()->json(['ok' => false, 'msg' => 'This link is already paid'], 422);
        }
        if ($order->expires_at && now()->greaterThan($order->expires_at)) {
            return response()->json(['ok' => false, 'msg' => 'This link has expired'], 422);
        }
        if ($order->phone !== $r->phone) {
            return response()->json(['ok' => false, 'msg' => 'Number not match'], 422);
        }
        return response()->json(['ok' => true]);
    }

    /** Create Razorpay order AFTER number verified — JSON only */
    public function initiate(Request $r, string $token)
    {
        $data = $r->validate([
            'phone' => ['required','regex:/^91[0-9]{10}$/'],
        ]);

        Log::info('initiate', ['token'=>$token]);

        $order = PaymentOrder::with('package')->where('link_token', $token)->first();
        if (!$order) {
            return response()->json(['ok'=>false,'msg'=>'Invalid link'], 404);
        }
        if ($order->status === 'paid') {
            return response()->json(['ok'=>false,'msg'=>'Already paid'], 422);
        }
        if ($order->expires_at && now()->greaterThan($order->expires_at)) {
            return response()->json(['ok'=>false,'msg'=>'Link expired'], 422);
        }
        if ($order->phone !== $data['phone']) {
            return response()->json(['ok'=>false,'msg'=>'Number not match'], 422);
        }

        $amountPaise = (int) round(100 * ($order->amount_payable ?? $order->amount ?? 0));
        if ($amountPaise <= 0) {
            return response()->json(['ok'=>false,'msg'=>'Amount must be greater than ₹0'], 422);
        }

        [$key, $secret] = $this->getRzpCreds();
        if (!$key || !$secret) {
            return response()->json(['ok'=>false,'msg'=>'Razorpay key/secret not configured'], 500);
        }

        $api = new Api($key, $secret);
        $rzpOrder = $api->order->create([
            'receipt'         => 'rvglink_'.$order->id,
            'amount'          => $amountPaise,
            'currency'        => 'INR',
            'payment_capture' => 1,
            'notes'           => [
                'payment_order_id' => (string)$order->id,
                'link_token'       => $order->link_token,
                'phone'            => $order->phone,
            ],
        ]);

        $order->update([
            'razorpay_order_id' => $rzpOrder['id'] ?? null,
            'status'            => 'created',
        ]);

        return response()->json([
            'ok'            => true,
            'order_id'      => $rzpOrder['id'],
            'amount_paise'  => $amountPaise,
            'customer_name' => $order->name ?? '',
            'customer_phone'=> $order->phone,
            'package'       => $order->package->name ?? 'Package',
            'key'           => $key, // Checkout public key
            'token'         => $order->link_token,
        ]);
    }

    /** 4) AJAX: Verify payment signature → mark paid → redirect to thankyou */
    public function verifyAjax(Request $r)
    {
        $data = $r->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
            'phone'               => ['nullable','regex:/^91[0-9]{10}$/'],
        ]);

        // --- Log raw input
        Log::info('verifyAjax.input', [
            'razorpay_order_id'   => $data['razorpay_order_id'],
            'razorpay_payment_id' => $data['razorpay_payment_id'],
            'razorpay_signature'  => $data['razorpay_signature'],
        ]);

        // --- Load creds
        [$key, $secret] = $this->getRzpCreds();
        Log::info('verifyAjax.creds', [
            'key_preview'   => $key ? substr($key, 0, 6) . '…' : null,
            'secret_is_set' => !empty($secret),
            'app_env'       => config('app.env'),
        ]);

        if (empty($secret)) {
            return response()->json(['ok'=>false,'message'=>'Server misconfigured: secret missing'], 500);
        }

        // --- Manual HMAC (authoritative)
        $payload  = $data['razorpay_order_id'].'|'.$data['razorpay_payment_id'];
        $expected = hash_hmac('sha256', $payload, $secret);
        $match    = hash_equals($expected, $data['razorpay_signature']);

        Log::info('verifyAjax.hmac', [
            'payload'  => $payload,
            'expected' => $expected,
            'match'    => $match,
        ]);

        if (!$match) {
            return response()->json([
                'ok'      => false,
                'message' => 'Invalid payment signature (HMAC mismatch)',
            ], 422);
        }

        // OPTIONAL: also let SDK verify (kept for completeness)
        try {
            $api = new Api($key, $secret);
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $data['razorpay_order_id'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature'  => $data['razorpay_signature'],
            ]);
        } catch (SignatureVerificationError $e) {
            Log::warning('RZP SDK signature failed (but manual matched)', ['msg'=>$e->getMessage()]);
            // since manual matched, we continue
        } catch (\Throwable $e) {
            Log::warning('RZP SDK verify exception', ['msg'=>$e->getMessage()]);
        }

        // --- Locate PaymentOrder
        $po = PaymentOrder::with('package')
            ->where('razorpay_order_id', $data['razorpay_order_id'])
            ->first();

        // Fallbacks: fetch order, then payment (helps old rows)
        if (!$po) {
            try {
                $api ??= new Api($key, $secret);
                $rzpOrder = $api->order->fetch($data['razorpay_order_id']);
                $poId = $rzpOrder['notes']['payment_order_id'] ?? null;

                if (!$poId && !empty($rzpOrder['receipt']) && \Illuminate\Support\Str::startsWith($rzpOrder['receipt'], 'rvglink_')) {
                    $poId = (int) \Illuminate\Support\Str::after($rzpOrder['receipt'], 'rvglink_');
                }

                if ($poId) {
                    $po = PaymentOrder::with('package')->find($poId);
                }
            } catch (\Throwable $e) {
                Log::warning('verifyAjax: rzp order fetch fail', ['msg'=>$e->getMessage()]);
            }
        }

        if (!$po) {
            try {
                $api ??= new Api($key, $secret);
                $payment = $api->payment->fetch($data['razorpay_payment_id']);
                $oid2 = $payment['order_id'] ?? null;
                if ($oid2) {
                    $po = PaymentOrder::with('package')
                        ->where('razorpay_order_id', $oid2)->first();
                }
            } catch (\Throwable $e) {
                Log::warning('verifyAjax: payment fetch fail', ['msg'=>$e->getMessage()]);
            }
        }

        if (!$po) {
            Log::error('verifyAjax: PaymentOrder not found after verify', $data);
            return response()->json([
                'ok'      => false,
                'message' => 'We could not locate your order. Please contact support with Payment ID '.$data['razorpay_payment_id']
            ], 404);
        }

        // Optional: update phone if provided
        if (!empty($data['phone']) && $po->phone !== $data['phone']) {
            $po->phone = $data['phone'];
        }

        // Mark paid (idempotent)
        if ($po->status !== 'paid') {
            $po->razorpay_payment_id = $data['razorpay_payment_id'];
            $po->razorpay_signature  = $data['razorpay_signature'];
            $po->status              = 'paid';
            $po->paid_at             = now();
            $po->save();
        } else {
            $po->save();
        }

        // Thank-you payload in session
        $r->session()->put('thankyou', [
            'package_name' => optional($po->package)->name ?? 'Package',
            'order_id'     => $po->razorpay_order_id,
            'payment_id'   => $po->razorpay_payment_id,
            'amount'       => $po->amount_payable ?? $po->amount,
            'currency'     => $po->currency,
            'paid_at'      => optional($po->paid_at)->format('d M Y, h:i A'),
            'phone'        => $po->phone,
        ]);

        return response()->json(['ok'=>true, 'redirect'=>route('paylink.thankyou')]);
    }


public function thankyoupage(Request $r)
{
    $data = $r->session()->pull('thankyou');
    // if (!$data) abort(404);
  
    return view('public.pay_status' );
}



    /** --- Helpers --- */
    private function getRzpCreds(): array
    {
        $key    = config('services.razorpay.key')    ?: env('RAZORPAY_KEY');
        $secret = config('services.razorpay.secret') ?: env('RAZORPAY_SECRET');
        return [$key, $secret];
    }




}
