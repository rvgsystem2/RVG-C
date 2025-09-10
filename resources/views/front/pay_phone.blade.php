{{-- resources/views/front/pay_phone.blade.php --}}
@extends('component.main', ['seos' => (object)[
  'meta_title' => 'Verify Phone | Pay',
  'meta_description' => 'Verify your number to continue payment',
]])

@section('content')
<div class="container my-5" style="max-width:560px">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4">
      <h5 class="mb-2">Verify your mobile number</h5>
      <p class="text-muted small mb-3">
        @php $payable = $po->amount_payable ?? $po->computePayable(); @endphp
        Amount due: <strong>₹ {{ number_format($payable,2) }}</strong>
        @if($po->discount_type !== 'none')
          <span class="badge bg-success ms-2">Discount applied</span>
        @endif
      </p>

      <form method="post" action="{{ route('paylink.initiate',$po->link_token) }}" class="row g-3">
        @csrf
        <div class="col-12">
          <label class="form-label">Mobile Number</label>
          <input name="phone" class="form-control" placeholder="91XXXXXXXXXX" required>
        </div>
        <div class="col-12">
          <label class="form-label">Your Name (optional)</label>
          <input name="name" class="form-control">
        </div>
        <div class="col-12 d-flex gap-2">
          <a href="{{ url('/packages') }}" class="btn btn-outline-secondary">Back</a>
          <button class="btn btn-primary">Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
