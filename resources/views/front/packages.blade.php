@extends('component.main', ['seos' => $seos])

@section('content')
  {{-- (optional) Razorpay if needed elsewhere --}}
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <style>
    .pricing-card { border-radius: 18px; transition:.25s; overflow:hidden; }
    .pricing-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.10); }
    .pkg-chip { background:#f4f6f8; color:#334155; font-size:.75rem; padding:.25rem .6rem; border-radius:999px }
    .ribbon { position:absolute; top:12px; left:-8px; background:linear-gradient(135deg,#fb923c,#f97316); color:#fff; font-weight:700; font-size:.75rem; padding:.3rem .8rem; transform:rotate(-8deg); border-radius:8px }
    .btn-buy { background: linear-gradient(135deg, #0ea5e9, #2563eb); border: none }
    .btn-buy:hover { filter: brightness(.95) }
  </style>

  {{-- Header --}}
  <div class="container-fluid custom-color my-lg-5 py-md-4 py-sm-3 py-2">
    <div class="container text-center py-5">
      <h1 class="display-2 text-white mb-4">Our Packages</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Packages</li>
        </ol>
      </nav>
    </div>
  </div>

  {{-- Grid --}}
  <div class="container my-5">
    <div class="text-center mb-5">
      <h2 class="fw-bold display-6 text-dark">Choose the plan that fits your growth</h2>
      <p class="text-muted mb-0">Simple pricing. No hidden fees. Start today.</p>
    </div>

    <div class="row g-4">
      @forelse($packages as $pkg)
        @php
          $thumb = $pkg->thumbnail ?? $pkg->image;
          $hasSale = !is_null($pkg->sale_price);
          $eff = $hasSale ? $pkg->sale_price : $pkg->price;
        @endphp
        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm h-100 pricing-card position-relative">
            @if($pkg->label)
              <div class="ribbon">{{ $pkg->label }}</div>
            @endif

            <div class="ratio ratio-16x9 bg-light">
              @if($thumb)
                <img src="{{ asset('storage/'.$thumb) }}" alt="{{ $pkg->image_alt ?? $pkg->name }}" class="w-100 h-100 object-fit-cover">
              @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">No Image</div>
              @endif
            </div>

            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="card-title fw-semibold mb-0">{{ $pkg->name }}</h5>
                <span class="pkg-chip text-uppercase">{{ $pkg->status }}</span>
              </div>

              <div class="mb-2">
                <span class="h3 mb-0 fw-bold">₹{{ number_format((float)$eff, 2) }}</span>
                @if($hasSale)
                  <span class="text-muted text-decoration-line-through ms-2">₹{{ number_format((float)$pkg->price, 2) }}</span>
                  <span class="badge text-bg-success ms-2">Save ₹{{ number_format((float)($pkg->price - $pkg->sale_price), 2) }}</span>
                @endif
              </div>

              @if($pkg->short_description)
                <div class="text-muted small mb-3">{{ $pkg->short_description }}</div>
              @endif

              @if($pkg->duration_days)
                <div class="text-muted small mb-3">Validity: {{ $pkg->duration_days }} days</div>
              @endif

              <div class="mt-auto d-grid gap-2">
                <a href="{{ route('packages.details', $pkg->id) }}" class="btn btn-primary rounded-pill py-2">
                  View Details
                </a>
                <a href="{{ route('packages.buy', $pkg->id) }}" class="btn btn-buy text-white rounded-pill py-2">
                  Buy Now
                </a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center">
          <p class="text-muted">No packages available right now.</p>
        </div>
      @endforelse
    </div>
  </div>
@endsection
