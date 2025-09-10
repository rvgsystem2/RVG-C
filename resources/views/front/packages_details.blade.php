@extends('component.main', ['seos' => $seos])

@section('content')
  <style>
    .hero{border-radius: var(--radius-lg); overflow:hidden; border:var(--ring); background:#f8fafc}
    .hero .ratio{--bs-aspect-ratio: 56.25%;}
    .hero img{object-fit:cover}
    .overlay-top{position:absolute; inset:0; pointer-events:none;
      background: linear-gradient(180deg, rgba(0,0,0,0.0) 60%, rgba(0,0,0,.28))}
    .ribbon{position:absolute; top:12px; left:12px}
    /* Price card */
    .card-clean{border:var(--ring); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); background:#fff}
    .price-xl{font-weight:800; font-size: clamp(28px, 4.2vw, 38px); letter-spacing:-.4px}
    .save-badge{background:#e8fff3; color:#0a7a3b; border-radius:999px; padding:.25rem .6rem; font-weight:600; font-size:.75rem}
    .btn-ghost{background:#f6f8fb; border:var(--ring)}
    .media-wrap { overflow:hidden; border-radius: 16px; border:1px solid #e5e7eb; }
    .media-track { display:flex; gap:12px; padding:12px 12px; }
    .media-card { width: 260px; flex: 0 0 auto; border-radius: 12px; overflow: hidden; border:1px solid #e5e7eb; background:#fff; box-shadow: 0 6px 16px rgba(0,0,0,.05) }
    .media-card img, .media-card video { height:160px; width:100%; object-fit:cover }
    /* infinite auto-scroll */
    .auto-scroll { animation: scrollX 30s linear infinite }
    .paused { animation-play-state: paused !important }
    @keyframes scrollX { 0% { transform: translateX(0)} 100% { transform: translateX(-50%)} }
  </style>
  <div class="container-fluid custom-color my-lg-5 py-md-4 py-sm-3 py-2">
    <div class="container text-center py-5">
      <h1 class="display-2 text-white mb-4">Packages</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="{{ url('/packages') }}">Packages</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $package->name }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container my-5">
    {{-- Hero + summary --}}
    <div class="row g-4 align-items-start">
      <div class="col-lg-7">
        <div class="hero position-relative">
          @php $hero = $package->thumbnail ?? $package->image; @endphp
          <div class="ratio">
            @if($hero)
              <img src="{{ asset('storage/'.$hero) }}" alt="{{ $package->image_alt ?? $package->name }}" class="w-100 h-100">
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center muted">No Image</div>
            @endif
          </div>
          <div class="overlay-top"></div>

          <div class="ribbon d-flex gap-2">
            @if($package->label) <span class="chip">{{ $package->label }}</span> @endif
            <span class="chip text-capitalize">{{ $package->status }}</span>
            @if($package->duration_days)
              <span class="chip">Validity: {{ $package->duration_days }} days</span>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        @php
          $hasSale = !is_null($package->sale_price);
          $orig = (float) $package->price;
          $eff  = (float) ($hasSale ? $package->sale_price : $package->price);
          $save = $hasSale ? max(0, $orig - $eff) : 0;
          $pct  = ($hasSale && $orig>0) ? round(($save/$orig)*100) : null;
        @endphp
        <div class="card-clean p-4 p-md-5 position-sticky" style="top:86px">
          <h2 class="mb-2" style="font-weight:800; letter-spacing:-.3px">{{ $package->name }}</h2>
          @if($package->short_description)
            <p class="muted mb-3">{{ $package->short_description }}</p>
          @endif

          <div class="d-flex align-items-end gap-3">
            <div class="price-xl">₹{{ number_format($eff, 2) }}</div>
            @if($hasSale)
              <div class="text-muted text-decoration-line-through">₹{{ number_format($orig, 2) }}</div>
              <span class="save-badge">Save ₹{{ number_format($save,2) }}{{ $pct ? ' • '.$pct.'%' : '' }}</span>
            @endif
          </div>

          <div class="d-flex flex-wrap gap-2 mt-4">
            <a href="{{ route('packages.buy', $package->id) }}" class="btn btn-primary btn-lg rounded-pill px-4">Buy Now</a>
            <a href="{{ url('/packages') }}" class="btn btn-danger rounded-pill px-4">Back to Packages</a>
          </div>

          @if($package->description)
            <hr class="my-4">
            <h6 class="fw-semibold mb-2">About this package</h6>
            <div class="muted">{!! $package->description !!}</div>
          @endif
        </div>
      </div>
    </div>

    {{-- Media: infinite auto-scroll (hover to pause, drag not needed for Bootstrap) --}}
    @if($package->media->count())
    <div class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="h5 fw-semibold mb-0">Gallery</h3>
        <small class="text-muted">Hover to pause</small>
      </div>

      <div class="media-wrap position-relative">
        <div id="mediaMarquee" class="media-track auto-scroll">
          {{-- pass 1 --}}
          @foreach($package->media as $m)
            <div class="media-card">
              @if($m->type==='image' && $m->path)
                <img src="{{ asset('storage/'.$m->path) }}" alt="{{ $m->alt ?? 'image' }}">
              @elseif($m->type==='video' && $m->path)
                <video src="{{ asset('storage/'.$m->path) }}" controls muted playsinline></video>
              @elseif($m->type==='pdf' && $m->path)
                <a href="{{ asset('storage/'.$m->path) }}" target="_blank" class="d-flex align-items-center justify-content-center" style="height:auto;">
                  <span class="text-primary text-decoration-underline">Open PDF</span>
                </a>
              @endif
              @if($m->alt)
                <div class="px-2 py-2 small text-muted border-top">{{ $m->alt }}</div>
              @endif
            </div>
          @endforeach
          {{-- pass 2 (duplicate for seamless loop) --}}
          @foreach($package->media as $m)
            <div class="media-card">
              @if($m->type==='image' && $m->path)
                <img src="{{ asset('storage/'.$m->path) }}" alt="{{ $m->alt ?? 'image' }}">
              @elseif($m->type==='video' && $m->path)
                <video src="{{ asset('storage/'.$m->path) }}" controls muted playsinline></video>
              @elseif($m->type==='pdf' && $m->path)
                <a href="{{ asset('storage/'.$m->path) }}" target="_blank" class="d-flex align-items-center justify-content-center" style="height:auto;">
                  <span class="text-primary text-decoration-underline">Open PDF</span>
                </a>
              @endif
              @if($m->alt)
                <div class="px-2 py-2 small text-muted border-top">{{ $m->alt }}</div>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    {{-- FAQs --}}
    @if($package->faqs->count())
    <div class="mt-5">
      <h2 class="h4 fw-semibold mb-3">FAQs</h2>
      <div class="accordion" id="faqAccordion">
        @foreach($package->faqs as $i => $faq)
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $i }}">
              <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button"
                      data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}"
                      aria-expanded="{{ $i ? 'false' : 'true' }}" aria-controls="collapse{{ $i }}">
                {{ $faq->question }}
              </button>
            </h2>
            <div id="collapse{{ $i }}" class="accordion-collapse collapse {{ $i ? '' : 'show' }}" aria-labelledby="heading{{ $i }}" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                {!! $faq->answer !!}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  <script>
    // Pause/resume the marquee on hover
    (function(){
      const marquee = document.getElementById('mediaMarquee');
      if(!marquee) return;

      const wrap = marquee.parentElement;
      wrap.addEventListener('mouseenter', ()=> marquee.classList.add('paused'));
      wrap.addEventListener('mouseleave', ()=> marquee.classList.remove('paused'));
    })();
  </script>
@endsection
