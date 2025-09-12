@php
    // Safely derive values for display
    $pkgName      = $po->package->name ?? 'Package';
    $currency     = $po->currency ?? 'INR';
    $mrp          = (float) ($po->amount ?? 0);
    $final        = (float) ($po->amount_payable ?? $mrp);
    $discType     = $po->discount_type ?? 'none';
    $discVal      = (float) ($po->discount_value ?? 0);
    $hasDiscount  = $discType !== 'none' && $final < $mrp;
    $discAmt      = max($mrp - $final, 0);
    $discPerc     = $mrp > 0 ? round(($discAmt / $mrp) * 100) : 0;
    $paidAt       = optional($po->updated_at)->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A');
    $adminUrl     = url('/admin/payment-orders/'.$po->id);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Payment Received - {{ $pkgName }}</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  /* Basic, inline-friendly styles for email clients */
  body{margin:0;padding:0;background:#f6f8fb;font-family:Arial,Helvetica,sans-serif;color:#111827}
  .container{max-width:600px;margin:0 auto;background:#ffffff}
  .px{padding-left:24px;padding-right:24px}
  .py{padding-top:24px;padding-bottom:24px}
  .my{margin-top:16px;margin-bottom:16px}
  .muted{color:#6b7280;font-size:13px}
  .h1{font-size:20px;font-weight:700;margin:0 0 4px}
  .h2{font-size:16px;font-weight:700;margin:16px 0 8px}
  .btn{display:inline-block;background:#2563eb;color:#fff !important;text-decoration:none;padding:10px 16px;border-radius:6px}
  .table{width:100%;border-collapse:collapse}
  .table td{padding:8px 0;vertical-align:top}
  .right{text-align:right}
  .strike{text-decoration:line-through;color:#6b7280}
  .hr{height:1px;background:#e5e7eb;border:none;margin:16px 0}
  .pill{display:inline-block;background:#ecfdf5;color:#065f46;font-size:12px;padding:2px 8px;border-radius:999px}
  .code{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace}
</style>
</head>
<body>
  <div class="container">

    <!-- Header -->
    <div class="px py" style="border-bottom:1px solid #e5e7eb;">
      <div class="h1">✅ Payment Received</div>
      <div class="muted">{{ config('app.name') }}</div>
    </div>

    <!-- Intro -->
    <div class="px py">
      <p class="my" style="margin:0 0 8px;">A new payment has been captured.</p>
      <p class="muted" style="margin:0;">Below are the details.</p>
    </div>

    <!-- Payment Summary -->
    <div class="px">
      <div class="h2">Payment Summary</div>
      <table class="table">
        <tr>
          <td>Package</td>
          <td class="right"><strong>{{ $pkgName }}</strong></td>
        </tr>
        <tr>
          <td>Amount</td>
          <td class="right">
            @if($hasDiscount)
              <span class="strike">₹ {{ number_format($mrp, 2) }}</span>
              &nbsp; ₹ {{ number_format($final, 2) }} {{ $currency }}
              <br><span class="pill">Saved ₹ {{ number_format($discAmt,2) }} ({{ $discPerc }}%)</span>
              <div class="muted">Discount: {{ ucfirst($discType) }} {{ $discType === 'percent' ? $discVal.'%' : '₹ '.number_format($discVal,2) }}</div>
            @else
              ₹ {{ number_format($final, 2) }} {{ $currency }}
            @endif
          </td>
        </tr>
        <tr>
          <td>Status</td>
          <td class="right"><strong>{{ strtoupper($po->status) }}</strong></td>
        </tr>
        <tr>
          <td>Paid At</td>
          <td class="right">{{ $paidAt }}</td>
        </tr>
      </table>

      <div class="hr"></div>

      <!-- Customer -->
      <div class="h2">Customer</div>
      <table class="table">
        <tr>
          <td>Name</td>
          <td class="right">{{ $po->name ?: '—' }}</td>
        </tr>
        <tr>
          <td>Phone</td>
          <td class="right code">{{ $po->phone }}</td>
        </tr>
        <tr>
          <td>Business</td>
          <td class="right">{{ $po->business_name ?: '—' }}</td>
        </tr>
      </table>

      <div class="hr"></div>

      <!-- Razorpay -->
      <div class="h2">Razorpay</div>
      <table class="table">
        <tr>
          <td>Payment ID</td>
          <td class="right code">{{ $razorpayPaymentId }}</td>
        </tr>
        <tr>
          <td>Order ID</td>
          <td class="right code">{{ $razorpayOrderId }}</td>
        </tr>
        <tr>
          <td>Internal PO #</td>
          <td class="right code">{{ $po->id }}</td>
        </tr>
      </table>

      <div class="py" style="text-align:center;">
        <a class="btn" href="{{ $adminUrl }}">View in Admin</a>
      </div>

      <p class="muted" style="text-align:center;margin:8px 0 0;">
        If the button doesn’t work, open this URL:<br>
        <span class="code">{{ $adminUrl }}</span>
      </p>

      <div class="py"></div>
    </div>

    <!-- Footer -->
    <div class="px py" style="border-top:1px solid #e5e7eb;background:#f9fafb;">
      <div class="muted">This is an automated message from {{ config('app.name') }}.</div>
    </div>

  </div>
</body>
</html>
