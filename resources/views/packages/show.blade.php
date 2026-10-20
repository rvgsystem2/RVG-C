<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
      <h2 class="font-bold text-2xl text-gray-800">Package Management</h2>
      <a href="{{ route('package.create') }}"
         class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
        + Add Package
      </a>
    </div>
  </x-slot>

  <div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @include('components.alartTost')

      @php $hero = $package->thumbnail ?? $package->image; @endphp

      <div class="mx-auto">
        <!-- TOP: HERO + SUMMARY -->
        <div class="grid lg:grid-cols-5 gap-8">
          <!-- Left: Hero -->
          <div class="lg:col-span-3 relative">
            <div class="relative rounded-3xl overflow-hidden shadow-xl ring-1 ring-gray-200/70">
              @if($hero)
                <img src="{{ asset('storage/'.$hero) }}"
                     alt="{{ $package->image_alt ?? $package->name }}"
                     class="w-full h-[380px] md:h-[480px] object-cover">
              @else
                <div class="w-full h-[380px] md:h-[480px] bg-gradient-to-br from-gray-100 to-gray-200"></div>
              @endif

              <!-- floating chips -->
              <div class="absolute top-4 left-4 flex gap-2">
                @if($package->label)
                  <span class="backdrop-blur bg-white/70 text-gray-800 text-xs px-3 py-1 rounded-full shadow">
                    {{ $package->label }}
                  </span>
                @endif
                <span class="backdrop-blur bg-white/70 text-gray-800 text-xs px-3 py-1 rounded-full shadow capitalize">
                  {{ $package->status }}
                </span>
              </div>
            </div>
          </div>

          <!-- Right: Title + Pricing + CTA -->
          <div class="lg:col-span-2">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ $package->name }}</h1>

            @if($package->short_description)
              <p class="mt-3 text-gray-600 leading-relaxed">{{ $package->short_description }}</p>
            @endif

            <div class="mt-6">
              @php $eff = $package->sale_price ?? $package->price; @endphp
              <div class="flex items-end gap-3">
                <span class="text-4xl font-extrabold">₹{{ number_format((float) $eff, 2) }}</span>
                @if(!is_null($package->sale_price))
                  <span class="line-through text-gray-400 text-xl">₹{{ number_format((float) $package->price, 2) }}</span>
                  <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 font-semibold">
                    Save ₹{{ number_format((float) ($package->price - $package->sale_price), 2) }}
                  </span>
                @endif
              </div>
              @if($package->duration_days)
                <div class="mt-1 text-sm text-gray-600">Validity: {{ $package->duration_days }} days</div>
              @endif
            </div>

            <div class="mt-7 flex flex-wrap gap-3">
              <a href="{{ url('/contact') }}"
                 class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-gray-900 text-white hover:bg-black transition shadow">
                Contact
              </a>
              <a href="{{ url('/packages') }}"
                 class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-gray-100 text-gray-900 hover:bg-gray-200 transition shadow">
                All Packages
              </a>
            </div>

            @if($package->description)
              <div class="mt-8 bg-white rounded-2xl p-5 shadow ring-1 ring-gray-100">
                <h3 class="font-semibold text-gray-900 mb-3">About this package</h3>
                <div class="prose prose-sm max-w-none">{!! $package->description !!}</div>
              </div>
            @endif
          </div>
        </div>

        <!-- MEDIA STRIP: Infinite modern carousel -->
        @if($package->media->count())
        <div class="mt-12">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-xl font-semibold">Gallery</h3>
            <div class="flex gap-2">
              <button id="mediaPrev" class="h-9 w-9 rounded-full border bg-white hover:bg-gray-50 shadow flex items-center justify-center" aria-label="Prev">
                ‹
              </button>
              <button id="mediaNext" class="h-9 w-9 rounded-full border bg-white hover:bg-gray-50 shadow flex items-center justify-center" aria-label="Next">
                ›
              </button>
            </div>
          </div>

          <div class="relative group">
            <!-- gradient edges -->
            <div class="pointer-events-none absolute inset-y-0 left-0 w-12 bg-gradient-to-r from-white to-transparent rounded-l-2xl"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-12 bg-gradient-to-l from-white to-transparent rounded-r-2xl"></div>

            <div id="mediaWrap" class="overflow-hidden rounded-2xl border bg-white">
              <div id="mediaTrack" class="flex gap-3 px-3 py-3 select-none">
                @foreach($package->media as $m)
                  <div class="flex-none w-[220px]">
                    <div class="rounded-xl overflow-hidden border shadow-sm bg-white">
                      @if($m->type === 'image' && $m->path)
                        <img src="{{ asset('storage/'.$m->path) }}" alt="{{ $m->alt ?? 'image' }}"
                             class="h-[140px] w-full object-cover hover:scale-[1.02] transition">
                      @elseif($m->type === 'video' && $m->path)
                        <video src="{{ asset('storage/'.$m->path) }}" class="h-[140px] w-full object-cover"
                               controls muted playsinline></video>
                      @elseif($m->type === 'pdf' && $m->path)
                        <a href="{{ asset('storage/'.$m->path) }}" target="_blank"
                           class="h-[140px] w-full flex items-center justify-center bg-gray-50">
                          <span class="text-sm text-blue-600 underline">Open PDF</span>
                        </a>
                      @endif
                    </div>
                    @if($m->alt)
                      <div class="mt-1 text-xs text-gray-600 truncate">{{ $m->alt }}</div>
                    @endif
                  </div>
                @endforeach
              </div>
            </div>

            <!-- drag hint -->
            <div class="mt-2 text-xs text-gray-400">Tip: drag to scroll · hover to pause</div>
          </div>
        </div>
        @endif

        <!-- FAQS -->
        @if($package->faqs->count())
        <div class="mt-12">
          <h2 class="text-xl font-semibold mb-4">FAQs</h2>
          <div class="grid md:grid-cols-2 gap-4">
            @foreach($package->faqs as $faq)
              <details class="group bg-white rounded-2xl p-5 shadow border">
                <summary class="cursor-pointer font-medium text-gray-900 flex items-center justify-between">
                  <span>{{ $faq->question }}</span>
                  <span class="ml-4 transition group-open:rotate-180">⌄</span>
                </summary>
                <div class="mt-3 text-gray-700 prose prose-sm max-w-none">{!! $faq->answer !!}</div>
              </details>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Styles for nicer scroll UX -->
  <style>
    #mediaWrap::-webkit-scrollbar { height: 8px }
    #mediaWrap::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 9999px }
    .grabbing { cursor: grabbing !important; }
  </style>

  <!-- Carousel JS: infinite auto-scroll + drag + pause-on-hover -->
  <script>
    (function(){
      const wrap  = document.getElementById('mediaWrap');
      const track = document.getElementById('mediaTrack');
      const prev  = document.getElementById('mediaPrev');
      const next  = document.getElementById('mediaNext');
      if (!wrap || !track) return;

      // 1) Duplicate children once for seamless loop
      const children = Array.from(track.children);
      children.forEach(node => track.appendChild(node.cloneNode(true)));

      // 2) Auto-scroll
      let speed = 0.6; // px per tick
      let raf, paused = false;

      function loop(){
        if (!paused) {
          wrap.scrollLeft += speed;
          const half = (track.scrollWidth / 2);
          if (wrap.scrollLeft >= half) wrap.scrollLeft -= half; // loop back
        }
        raf = requestAnimationFrame(loop);
      }
      raf = requestAnimationFrame(loop);

      // Pause on hover
      wrap.addEventListener('mouseenter', ()=> paused = true);
      wrap.addEventListener('mouseleave', ()=> paused = false);

      // 3) Drag to scroll
      let isDown = false, startX, startLeft;
      wrap.addEventListener('mousedown', (e)=>{ isDown=true; wrap.classList.add('grabbing'); startX=e.pageX; startLeft=wrap.scrollLeft; paused=true; });
      window.addEventListener('mouseup', ()=>{ if(isDown){ isDown=false; wrap.classList.remove('grabbing'); paused=false; }});
      window.addEventListener('mousemove', (e)=>{ if(!isDown) return; const dx=e.pageX-startX; wrap.scrollLeft=startLeft-dx; });
      wrap.addEventListener('touchstart', ()=> paused=true, {passive:true});
      wrap.addEventListener('touchend',   ()=> paused=false, {passive:true});

      // 4) Arrow controls
      const step = 300;
      prev?.addEventListener('click', ()=>{ paused=true; wrap.scrollBy({left:-step, behavior:'smooth'}); setTimeout(()=>paused=false, 400); });
      next?.addEventListener('click', ()=>{ paused=true; wrap.scrollBy({left:+step, behavior:'smooth'}); setTimeout(()=>paused=false, 400); });

      // Cleanup on page change
      window.addEventListener('beforeunload', ()=> cancelAnimationFrame(raf));
    })();
  </script>
</x-app-layout>
