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
    public function show(Package $package)
    {
        return view('front.packagebuy', compact('package'));
    }

    public function createOrder(Request $r)
    {
        $data = $r->validate([
            'package_id'    => 'required|exists:packages,id',
            'name'          => 'nullable|string|max:120',
            'phone'         => 'required|digits_between:8,14',
            'business_name' => 'nullable|string|max:160',
            'amount'        => 'required|numeric|min:1',
        ]);

        try {
            $package = Package::findOrFail($data['package_id']);

            // ALWAYS read from config (which reads from .env)
            $key    = env('RAZORPAY_KEY');
            $secret = env('RAZORPAY_SECRET');

            if (empty($key) || empty($secret)) {
                \Log::error('Razorpay keys missing', ['key' => (bool)$key, 'secret' => (bool)$secret]);
                return response()->json(['message' => 'Payment gateway not configured.'], 500);
            }

            $amountPaise = (int) round($data['amount'] * 100);

            $api   = new Api($key, $secret);
            $order = $api->order->create([
                'receipt'  => 'rcpt_'.Str::random(10),
                'amount'   => $amountPaise,
                'currency' => 'INR',
            ]);

            $po = PaymentOrder::create([
                'package_id'        => $package->id,
                'name'              => $data['name'] ?? null,
                'phone'             => $data['phone'],
                'business_name'     => $data['business_name'] ?? null,
                'amount'            => $data['amount'],
                'currency'          => 'INR',
                'razorpay_order_id' => $order['id'],
                'status'            => 'created',
            ]);

            return response()->json([
                'order_id'      => $order['id'],
                'amount'        => $amountPaise, // paise
                'currency'      => 'INR',
                'key'           => $key,
                'merchant_name' => config('app.name', 'Real Victory Groups'),
                'description'   => $package->name.' — Package Purchase',
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

            $po->update([
                'razorpay_payment_id' => $payload['razorpay_payment_id'],
                'razorpay_signature'  => $payload['razorpay_signature'],
                'status'              => 'paid',
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
