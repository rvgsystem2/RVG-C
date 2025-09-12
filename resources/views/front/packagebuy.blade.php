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
  .checkout-card{border-radius:18px}
  .btn-buy{background:linear-gradient(135deg,#0ea5e9,#2563eb);border:none}
  .btn-buy:hover{filter:brightness(.95)}
</style>

<div class="container-fluid custom-color my-lg-5 py-md-4 py-sm-3 py-2">
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center">
      <a href="{{ url('/packages') }}" class="text-white text-decoration-none">← Back to Packages</a>
      <h1 class="display-6 text-white mb-0">Checkout</h1>
      <span></span>
    </div>
  </div>
</div>

@php
  $mrp  = (float) $package->price; // GST inclusive
  $sale = $package->sale_price !== null ? (float) $package->sale_price : null;
  $hasDiscount = $sale !== null && $sale > 0 && $sale < $mrp;
  $final = $hasDiscount ? $sale : $mrp;
  $discountAmt = $hasDiscount ? round($mrp - $sale, 2) : 0.0;
  $discountPerc = $hasDiscount ? round(($discountAmt / $mrp) * 100) : 0;
@endphp

<div class="container my-5">
  <div class="row g-4">
    <!-- Left: Form -->
    <div class="col-lg-7">
      <div class="card shadow-sm checkout-card border-0">
        <div class="card-body p-4">
          <h5 class="mb-3">Billing Details</h5>

          <div id="formAlert" class="alert alert-danger d-none mb-3"></div>

          <form id="buyForm" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Your Name</label>
                <input id="nameInput" type="text" name="name" class="form-control" required>
                <div class="invalid-feedback">Please enter your name.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input id="phoneInput" type="tel" name="phone" class="form-control"
                       inputmode="numeric" autocomplete="tel" pattern="[0-9]{10}"
                       maxlength="10" list="phoneSuggestions" required>
                <datalist id="phoneSuggestions"></datalist>
                <div class="form-text">10 digits only (e.g., 9876543210). India code auto-added.</div>
                <div class="invalid-feedback">Enter a valid 10-digit number.</div>
              </div>

              <div class="col-12">
                <label class="form-label">Business Name</label>
                <input id="bizInput" type="text" name="business_name" class="form-control" required>
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
      <div class="card shadow-sm border-0 checkout-card">
        <div class="card-body p-4">
          <h5 class="mb-3">Order Summary</h5>

          <div class="d-flex align-items-center mb-3">
            @if ($package->image)
              <img src="{{ asset('storage/' . $package->image) }}"
                   alt="{{ $package->image_alt ?? $package->name }}"
                   class="rounded me-3" style="width:72px;height:72px;object-fit:cover">
            @endif
            <div>
              <div class="fw-semibold">{{ $package->name }}</div>
              <div class="text-muted small">One-time purchase</div>
            </div>
          </div>

          <hr>

          <div class="d-flex justify-content-between">
            <span>Price (incl. GST 18%)</span>
            <span id="priceWrap">
              @if ($hasDiscount)
                <span class="text-muted text-decoration-line-through me-2">₹ <span id="mrpSpan">{{ number_format($mrp, 2) }}</span></span>
                <span>₹ <span id="finalSpan">{{ number_format($final, 2) }}</span></span>
              @else
                <span>₹ <span id="finalSpan">{{ number_format($final, 2) }}</span></span>
                <input type="hidden" id="mrpSpan" value="{{ number_format($mrp, 2) }}">
              @endif
            </span>
          </div>

          <div id="saveRow" class="d-flex justify-content-between mt-1 {{ $hasDiscount ? '' : 'd-none' }}">
            <span class="text-muted small">You save (<span id="savePerc">{{ $discountPerc ?? 0 }}</span>%)</span>
            <span class="text-success small">− ₹ <span id="saveVal">{{ number_format($discountAmt ?? 0, 2) }}</span></span>
          </div>

          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <span>Total Payable (incl. GST)</span>
            <span>₹ <span id="totalSpan">{{ number_format($final, 2) }}</span></span>
          </div>

          <div class="d-flex justify-content-between mt-2">
            <span>Taxes</span>
            <span class="text-muted">GST (18%) Included</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  const csrf   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const pkgId  = "{{ $package->id }}";

  // Inputs
  const form       = document.getElementById('buyForm');
  const alertBox   = document.getElementById('formAlert');
  const nameInput  = document.getElementById('nameInput');
  const phoneInput = document.getElementById('phoneInput');
  const bizInput   = document.getElementById('bizInput');

  // Summary targets
  const priceWrap = document.getElementById('priceWrap');
  const saveRow   = document.getElementById('saveRow');

  function showError(msg){
    alertBox.classList.remove('d-none','alert-info');
    alertBox.classList.add('alert-danger');
    alertBox.textContent = msg || 'Something went wrong.';
  }
  function showInfo(msg){
    alertBox.classList.remove('d-none','alert-danger');
    alertBox.classList.add('alert-info');
    alertBox.textContent = msg;
  }
  function clearAlert(){
    alertBox.classList.add('d-none');
    alertBox.textContent = '';
  }

  function raw10(v){ return (v||'').replace(/\D+/g,'').slice(0,10); }
  function normalize91(v10){ return v10.length===10 ? '91'+v10 : v10; }

  // suggestions from localStorage
  function loadSuggestions(){
    try{
      const arr = JSON.parse(localStorage.getItem('rv_last_phones')||'[]');
      const dl = document.getElementById('phoneSuggestions');
      dl.innerHTML='';
      arr.slice(0,5).forEach(v=>{
        const o=document.createElement('option'); o.value=v; dl.appendChild(o);
      });
    }catch{}
  }
  function pushSuggestion(v10){
    try{
      const key='rv_last_phones';
      const arr = JSON.parse(localStorage.getItem(key)||'[]');
      if(!arr.includes(v10)) arr.unshift(v10);
      localStorage.setItem(key, JSON.stringify(arr.slice(0,5)));
      loadSuggestions();
    }catch{}
  }
  loadSuggestions();

  function debounce(fn,ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a),ms); }; }

  // Prefill
  async function doPrefill(){
    clearAlert();
    const ten = raw10(phoneInput.value);
    if (ten.length !== 10) return;

    const phone91 = normalize91(ten);
    const fd = new FormData();
    fd.append('package_id', pkgId);
    fd.append('phone', phone91);

    try{
      const resp = await fetch(`{{ route('checkout.prefill') }}`, {
        method:'POST',
        headers:{ 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept':'application/json' },
        body: fd
      });
      const data = await resp.json();

      if (!resp.ok) {
        showError(data?.message || 'Unable to prefill.');
        return;
      }

      if (data?.ok) {
        if (data.name && !nameInput.value) nameInput.value = data.name;
        if (data.business_name && !bizInput.value) bizInput.value = data.business_name;

        const mrp   = parseFloat(data.amount ?? '0');
        const final = parseFloat(data.amount_payable ?? data.amount ?? '0');
        const saveAmt  = parseFloat(data.discount_amt ?? '0');
        const savePerc = parseInt(data.discount_perc ?? '0', 10);

        if (!isNaN(mrp) && !isNaN(final) && mrp > final) {
          priceWrap.innerHTML =
            `<span class="text-muted text-decoration-line-through me-2">₹ <span id="mrpSpan">${mrp.toFixed(2)}</span></span>`+
            `<span>₹ <span id="finalSpan">${final.toFixed(2)}</span></span>`;
          saveRow.classList.remove('d-none');
          document.getElementById('saveVal').textContent  = saveAmt.toFixed(2);
          document.getElementById('savePerc').textContent = savePerc.toString();
          document.getElementById('totalSpan').textContent= final.toFixed(2);
        } else {
          priceWrap.innerHTML = `<span>₹ <span id="finalSpan">${final.toFixed(2)}</span></span>
                                 <input type="hidden" id="mrpSpan" value="${mrp.toFixed(2)}">`;
          saveRow.classList.add('d-none');
          document.getElementById('totalSpan').textContent = final.toFixed(2);
        }

        pushSuggestion(ten);
      } else {
        showInfo('No saved discount for this number. Standard price will apply.');
        // keep current UI (package price/sale)
      }
    }catch(e){
      showError('Prefill request failed. Try again.');
      console.error(e);
    }
  }

  const prefillDebounced = debounce(doPrefill, 400);

  phoneInput.addEventListener('input', ()=>{
    clearAlert();
    phoneInput.value = raw10(phoneInput.value);
    prefillDebounced();
  });
  phoneInput.addEventListener('blur', doPrefill);

  // Submit → Create order -> Razorpay -> Verify
  form.addEventListener('submit', async function(e){
    e.preventDefault();
    clearAlert();

    // HTML5 validity
    if (!form.checkValidity()){
      form.classList.add('was-validated');
      showError('Please fix the highlighted fields.');
      return;
    }

    const btn = form.querySelector('button[type="submit"]');
    const old = btn.innerHTML;
    btn.disabled = true; btn.innerHTML = 'Processing…';

    try {
      const fd = new FormData(form);
      const resp = await fetch(`{{ route('checkout.order') }}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' },
        body: fd
      });
      const data = await resp.json();

      if (!resp.ok){
        showError(data?.message || 'Unable to start payment.');
        btn.disabled = false; btn.innerHTML = old;
        return;
      }

      const rzp = new Razorpay({
        key: data.key,
        currency: data.currency || 'INR',
        name: data.merchant_name,
        description: data.description,
        order_id: data.order_id,
        prefill: data.prefill,
        theme: { color: '#2563eb' },
        handler: async function(response){
          try{
            const verify = await fetch(`{{ route('checkout.verify') }}`, {
              method: 'POST',
              headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With':'XMLHttpRequest',
                'Accept':'application/json'
              },
              body: JSON.stringify(response)
            });
            const v = await verify.json();
            if (verify.ok && v?.ok) {
              window.location.href = v.redirect ?? '{{ url('/thank-you') }}';
            } else {
              showError(v?.message || 'Payment verification failed.');
              btn.disabled = false; btn.innerHTML = old;
            }
          } catch(err){
            showError('Verification error.');
            btn.disabled = false; btn.innerHTML = old;
          }
        }
      });

      rzp.on('payment.failed', function(res){
        showError(res.error?.description || 'Payment failed.');
        btn.disabled = false; btn.innerHTML = old;
      });

      rzp.open();
    } catch (err){
      showError('Something went wrong. Please try again.');
      btn.disabled = false; btn.innerHTML = old;
    }
  });
})();
</script>
@endsection
