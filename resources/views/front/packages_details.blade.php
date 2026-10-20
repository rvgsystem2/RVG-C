@extends('component.main', ['seos' => $seos])

@section('content')
  <style>
    :root{ --radius-lg:16px; --ring:1px solid #e5e7eb; --shadow-sm:0 6px 16px rgba(0,0,0,.06) }
    .muted{color:#64748b}

    /* Hero */
    .hero{border-radius: var(--radius-lg); overflow:hidden; border:var(--ring); background:#fff; position:relative}
    .hero .ratio{--bs-aspect-ratio:56.25%}
    .hero img{width:100%; height:100%; object-fit:contain; object-position:center; background:#fff}
    .overlay-top{position:absolute; inset:0; pointer-events:none;
      background: linear-gradient(180deg, rgba(0,0,0,0) 60%, rgba(0,0,0,.28))}
    .ribbon{position:absolute; top:12px; left:12px}
    .chip{backdrop-filter: blur(6px); background: rgba(255,255,255,.9); border:1px solid #e5e7eb; border-radius:999px; padding:.25rem .7rem; font-size:.75rem; color:#0f172a}

    /* Cards */
    .card-clean{border:var(--ring); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); background:#fff}
    .price-xl{font-weight:800; font-size: clamp(28px, 4.2vw, 38px); letter-spacing:-.4px}
    .save-badge{background:#e8fff3; color:#0a7a3b; border-radius:999px; padding:.25rem .6rem; font-weight:600; font-size:.75rem}

    /* Gallery */
    .media-wrap{overflow:hidden; border-radius:16px; border:1px solid #e5e7eb; background:#fafafa}
    .media-track{display:flex; gap:12px; padding:12px 12px; will-change:transform}
    .media-card{width:260px; flex:0 0 auto; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb; background:#fff; box-shadow:var(--shadow-sm)}
    .media-figure{width:100%; aspect-ratio:4/3; display:flex; align-items:center; justify-content:center; background:#fff}
    .media-figure img,.media-figure video{max-width:100%; max-height:100%; object-fit:contain; display:block}

    .auto-scroll{animation:scrollX 30s linear infinite}
    .paused{animation-play-state:paused!important}
    @keyframes scrollX{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}

    /* Rich text */
    .rich-text h2,.rich-text h3{font-weight:800; letter-spacing:-.2px}
    .rich-text ul{margin-left:1rem}
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
    {{-- ===== Top: Image + Summary (short) ===== --}}
    <div class="row g-4 align-items-start">
      <div class="col-lg-7">
        <div class="hero position-relative">
          @php $hero = $package->thumbnail ?? $package->image; @endphp
          <div class="ratio">
            @if($hero)
              <img src="{{ asset('storage/'.$hero) }}"
                   alt="{{ $package->image_alt ?? $package->name }}"
                   loading="eager" fetchpriority="high" decoding="async">
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">No Image</div>
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

  {{-- Interested → opens modal --}}
  <button type="button" class="btn btn-danger rounded-pill px-4"
          data-bs-toggle="modal" data-bs-target="#interestModal">
    Interested
  </button>
</div>

        </div>
      </div>
    </div>

    {{-- ===== Full-width Details (moves out of sticky card) ===== --}}
    @if($package->description)
      <div class="mt-5">
        <div class="card-clean p-4 p-md-5 rich-text">
          <h2 class="h4 fw-semibold mb-3">About this package</h2>
          <div class="muted">{!! $package->description !!}</div>
        </div>
      </div>
    @endif

    {{-- ===== Gallery: infinite auto-scroll ===== --}}
    @if($package->media->count())
      <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h3 class="h5 fw-semibold mb-0">More Demos</h3>
          <small class="text-muted">Hover to pause</small>
        </div>

        <div class="media-wrap position-relative">
          <div id="mediaMarquee" class="media-track auto-scroll">
            @foreach($package->media as $m)
              <div class="media-card">
                <div class="media-figure">
                  @if($m->type==='image' && $m->path)
                    <img src="{{ asset('storage/'.$m->path) }}" alt="{{ $m->alt ?? 'image' }}" loading="lazy" decoding="async">
                  @elseif($m->type==='video' && $m->path)
                    <video src="{{ asset('storage/'.$m->path) }}" controls muted playsinline preload="metadata"></video>
                  @elseif($m->type==='pdf' && $m->path)
                    <a href="{{ asset('storage/'.$m->path) }}" target="_blank" class="text-decoration-underline">Open PDF</a>
                  @endif
                </div>
                @if($m->alt)
                  <div class="px-2 py-2 small text-muted border-top">{{ $m->alt }}</div>
                @endif
              </div>
            @endforeach
            {{-- duplicate for seamless loop --}}
            @foreach($package->media as $m)
              <div class="media-card">
                <div class="media-figure">
                  @if($m->type==='image' && $m->path)
                    <img src="{{ asset('storage/'.$m->path) }}" alt="{{ $m->alt ?? 'image' }}" loading="lazy" decoding="async">
                  @elseif($m->type==='video' && $m->path)
                    <video src="{{ asset('storage/'.$m->path) }}" controls muted playsinline preload="metadata"></video>
                  @elseif($m->type==='pdf' && $m->path)
                    <a href="{{ asset('storage/'.$m->path) }}" target="_blank" class="text-decoration-underline">Open PDF</a>
                  @endif
                </div>
                @if($m->alt)
                  <div class="px-2 py-2 small text-muted border-top">{{ $m->alt }}</div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    {{-- ===== FAQs ===== --}}
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
              <div id="collapse{{ $i }}" class="accordion-collapse collapse {{ $i ? '' : 'show' }}"
                   aria-labelledby="heading{{ $i }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">{!! $faq->answer !!}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>


{{-- SweetAlert2 (if not loaded elsewhere) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
  $businessPhone = '7800378002'; // Real Victory Groups
  $waPhone = '91' . $businessPhone; // WhatsApp format (country code without +)
  $waText = urlencode("Hi, I'm interested in the package: {$package->name} (ID: {$package->id}).");
@endphp

<div class="modal fade" id="interestModal" tabindex="-1" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="interestModalLabel">Interested in {{ $package->name }}?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Keep action as fallback; JS will intercept submit --}}
      <form id="interestForm" action="{{ route('interest.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="package_id" value="{{ $package->id }}">

        <div class="modal-body">
          {{-- Phone input --}}
          <label class="form-label">Enter your number</label>
          <input
            type="tel"
            name="phone"
            class="form-control"
            placeholder="enter your phone number"
            inputmode="tel"
            pattern="^(\+?91[6-9]\d{9}|[6-9]\d{9})$"
            required>
          {{-- Inline error holder --}}
          <div id="phoneError" class="invalid-feedback d-block" style="display:none;"></div>

          <div class="form-text">
            Indian numbers only. Example: <b>9876543210</b> or <b>+919876543210</b>.
          </div>

          <hr class="my-4">

          <div class="d-grid gap-2">
            <a href="tel:+91{{ $businessPhone }}" class="btn btn-secondary">
              📞 Call Us: +91 {{ $businessPhone }}
            </a>
            <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" target="_blank" class="btn btn-success">
              💬 WhatsApp Us
            </a>
          </div>
        </div>

        <div class="modal-footer">
          <button id="interestSubmit" type="submit" class="btn btn-primary">
            Submit
          </button>
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
(function(){
  const form = document.getElementById('interestForm');
  if(!form) return;

  const submitBtn = document.getElementById('interestSubmit');
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  function setLoading(state){
    if(!submitBtn) return;
    if(state){
      submitBtn.disabled = true;
      submitBtn.dataset._t = submitBtn.innerHTML;
      submitBtn.innerHTML = 'Submitting...';
    } else {
      submitBtn.disabled = false;
      if(submitBtn.dataset._t){ submitBtn.innerHTML = submitBtn.dataset._t; }
    }
  }

  function clearErrors(){
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    const phoneError = document.getElementById('phoneError');
    if(phoneError){ phoneError.style.display='none'; phoneError.textContent=''; }
  }

  function showErrors(errors){
    if(errors?.phone){
      const input = form.querySelector('[name="phone"]');
      const holder = document.getElementById('phoneError');
      if(input) input.classList.add('is-invalid');
      if(holder){
        holder.textContent = Array.isArray(errors.phone) ? errors.phone[0] : errors.phone;
        holder.style.display = 'block';
      }
    }
  }

  async function submitAjax(e){
    e.preventDefault();
    clearErrors();

    setLoading(true);
    try{
      const fd = new FormData(form);
      const res = await fetch(form.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf || '',
          'Accept': 'application/json'
        },
        body: fd
      });

      if(res.ok){
        const data = await res.json().catch(()=>({}));
        // Success alert
        await Swal.fire({
          icon: 'success',
          title: 'Thank you!',
          text: (data && data.message) ? data.message : 'We will contact you shortly.',
          confirmButtonText: 'OK'
        });

        // Reset + close modal
        form.reset();
        clearErrors();

        const modalEl = document.getElementById('interestModal');
        if(window.bootstrap){
          const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
          instance.hide();
        } else {
          // Fallback: manually hide if Bootstrap instance not found
          modalEl.classList.remove('show'); modalEl.style.display='none';
          document.body.classList.remove('modal-open');
          document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        }
      } else if(res.status === 422){
        const data = await res.json();
        showErrors(data.errors || {});
        Swal.fire({
          icon: 'error',
          title: 'Please fix the errors',
          html: Object.values(data.errors || {}).flat().join('<br>')
        });
      } else {
        const text = await res.text();
        console.error(text);
        Swal.fire({icon:'error', title:'Oops!', text:'Something went wrong. Please try again.'});
      }
    } catch(err){
      console.error(err);
      Swal.fire({icon:'error', title:'Network error', text:'Please check your connection and try again.'});
    } finally {
      setLoading(false);
    }
  }

  form.addEventListener('submit', submitAjax);
})();
</script>



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
