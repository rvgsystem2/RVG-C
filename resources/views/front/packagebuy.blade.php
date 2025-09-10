@extends('component.main', [
    'seos' => (object) [
        'meta_title' => ($package->name ?? 'Package') . ' | Checkout',
        'meta_description' => 'Complete your purchase for ' . $package->name,
    ],
])

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        .checkout-card {
            border-radius: 18px
        }

        .btn-buy {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            border: none
        }

        .btn-buy:hover {
            filter: brightness(.95)
        }
    </style>

    <!-- Header -->
    <div class="container-fluid custom-color my-lg-5 py-md-4 py-sm-3 py-2">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ url('/packages') }}" class="text-white text-decoration-none">
                    ← Back to Packages
                </a>
                <h1 class="display-6 text-white mb-0">Checkout</h1>
                <span></span>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row g-4">
            <!-- Left: Form -->
            <div class="col-lg-7">
                <div class="card shadow-sm checkout-card border-0">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Billing Details</h5>
                        <form id="buyForm" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">
                            <input type="hidden" name="amount" value="{{ (float) $package->price }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control" pattern="[0-9]{10}" required>
                                    <div class="invalid-feedback">Enter a valid 10-digit number.</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Business Name</label>
                                    <input type="text" name="business_name" class="form-control" required>
                                    <div class="invalid-feedback">Please enter your business name.</div>
                                </div>
                            </div>

                            <div class="alert alert-info small mt-3 mb-0">
                                You’ll be redirected to Razorpay’s secure checkout to complete the payment.
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ url('/packages') }}" class="btn btn-secondary">Cancel & Back</a>
                                <button type="submit" class="btn btn-buy text-white">Proceed to Pay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Right: Order Summary -->
            <div class="col-lg-5">
               @php
  $mrp  = (float) $package->price;                         // GST inclusive MRP
  $sale = $package->sale_price !== null ? (float)$package->sale_price : null;  // GST inclusive sale price (if any)

  $hasDiscount  = $sale !== null && $sale > 0 && $sale < $mrp;
  $final        = $hasDiscount ? $sale : $mrp;             // Final payable (GST included)
  $discountAmt  = $hasDiscount ? round($mrp - $sale, 2) : 0.0;
  $discountPerc = $hasDiscount ? round(($discountAmt / $mrp) * 100) : 0;
@endphp

<div class="card shadow-sm border-0 checkout-card">
  <div class="card-body p-4">
    <h5 class="mb-3">Order Summary</h5>

    <div class="d-flex align-items-center mb-3">
      @if ($package->image)
        <img src="{{ asset('storage/' . $package->image) }}"
             alt="{{ $package->image_alt ?? $package->name }}"
             class="rounded me-3" style="width:auto;height:auto;object-fit:cover">
      @endif
      <div>
        <div class="fw-semibold">{{ $package->name }}</div>
        <div class="text-muted small">One-time purchase</div>
      </div>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
      <span>Price (incl. GST 18%)</span>
      @if($hasDiscount)
        <span>
          <span class="text-muted text-decoration-line-through me-2">₹ {{ number_format($mrp, 2) }}</span>
          <span>₹ {{ number_format($final, 2) }}</span>
        </span>
      @else
        <span>₹ {{ number_format($final, 2) }}</span>
      @endif
    </div>

    @if($hasDiscount)
      <div class="d-flex justify-content-between mt-1">
        <span class="text-muted small">You save ({{ $discountPerc }}%)</span>
        <span class="text-success small">− ₹ {{ number_format($discountAmt, 2) }}</span>
      </div>
    @endif

    <div class="d-flex justify-content-between mt-2">
      <span>Taxes</span>
      <span class="text-muted">GST (18%) Included</span>
    </div>

    <hr>
    <div class="d-flex justify-content-between fw-bold">
      <span>Total Payable (incl. GST)</span>
      <span>₹ {{ number_format($final, 2) }}</span>
    </div>
  </div>
</div>

            </div>
        </div>
    </div>

    <script>
        (function() {
            const form = document.getElementById('buyForm');
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;

                try {
                    const fd = new FormData(form);

                    const resp = await fetch(`{{ route('checkout.order') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: fd
                    });
                    const data = await resp.json();
                    if (!resp.ok) {
                        alert(data.message || 'Unable to start payment.');
                        btn.disabled = false;
                        return;
                    }

                    const rzp = new Razorpay({
                        key: data.key,
                        amount: data.amount,
                        currency: data.currency,
                        name: data.merchant_name,
                        description: data.description,
                        order_id: data.order_id,
                        prefill: data.prefill,
                        theme: {
                            color: '#2563eb'
                        },
                        handler: async function(response) {
                            const verify = await fetch(`{{ route('checkout.verify') }}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrf,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(response)
                            });
                            const v = await verify.json();
                            if (verify.ok) {
                                window.location.href = v.redirect ?? '{{ url('/thank-you') }}';
                            } else {
                                alert(v.message || 'Payment verification failed.');
                                btn.disabled = false;
                            }
                        }
                    });

                    rzp.on('payment.failed', function(res) {
                        alert(res.error?.description || 'Payment failed.');
                        btn.disabled = false;
                    });

                    rzp.open();
                } catch (err) {
                    alert('Something went wrong. Please try again.');
                    btn.disabled = false;
                }
            });
        })();
    </script>
@endsection
