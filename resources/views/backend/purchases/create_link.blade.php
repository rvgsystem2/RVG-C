{{-- resources/views/backend/purchases/create_link.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl text-gray-800">Create Discounted Payment Link</h2>
  </x-slot>

  <div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-xl rounded-2xl p-6">

        {{-- Success flash --}}
        @if(session('ok'))
          <div class="mb-6 rounded-lg border border-green-200 bg-green-50 text-green-800 px-4 py-3">
            {{ session('ok') }}
            @if(session('url'))
              <div class="mt-2 flex items-center gap-3">
                <a href="{{ session('url') }}" target="_blank" class="text-blue-700 underline break-all">
                  {{ session('url') }}
                </a>
                <button type="button" data-copy="{{ session('url') }}"
                        class="copy-btn px-3 py-1.5 text-sm rounded border bg-white hover:bg-gray-50">
                  Copy Link
                </button>
              </div>
            @endif
          </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
          <div class="mb-6 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
            <ul class="list-disc ml-5 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('paylink.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6" id="paylinkForm">
          @csrf

          {{-- Package --}}
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Package</label>
            <select name="package_id" id="packageSelect"
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200"
                    required>
              <option value="">Select…</option>
              @foreach($packages as $p)
                @php
                  // Prefer sale_price if present, else price
                  $price = $p->sale_price ?? $p->price;
                @endphp
                <option
                  value="{{ $p->id }}"
                  data-price="{{ $price }}"
                  data-mrp="{{ $p->price }}"
                  data-sale="{{ $p->sale_price ?? '' }}"
                >
                  {{ $p->name }} (₹{{ number_format((float)$price, 2) }})
                </option>
              @endforeach
            </select>
          </div>

          {{-- Phone --}}
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Phone (91XXXXXXXXXX)</label>
            <input name="phone" id="phone" value="{{ old('phone') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200"
                   placeholder="91XXXXXXXXXX" required
                   minlength="12" maxlength="12" pattern="^91[0-9]{10}$">
            <p class="text-xs text-gray-500 mt-1">Must start with 91 and contain 12 digits in total.</p>
          </div>

          {{-- Customer Name --}}
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
            <input name="name" value="{{ old('name') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200"
                   placeholder="Optional">
          </div>

          {{-- Business Name --}}
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
            <input name="business_name" value="{{ old('business_name') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200"
                   placeholder="Optional">
          </div>

          {{-- Discount Type --}}
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
            <select name="discount_type" id="discountType"
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
              <option value="none" {{ old('discount_type') === 'none' ? 'selected' : '' }}>None</option>
              <option value="flat" {{ old('discount_type') === 'flat' ? 'selected' : '' }}>Flat (₹)</option>
              <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Percent (%)</option>
            </select>
          </div>

          {{-- Discount Value --}}
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
            <input name="discount_value" id="discountValue" type="number" step="0.01"
                   value="{{ old('discount_value', 0) }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
          </div>

          {{-- Expires At --}}
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Expires At (optional)</label>
            <input name="expires_at" id="expiresAt" type="datetime-local" value="{{ old('expires_at') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
            <p id="expiryPreview" class="text-xs text-gray-500 mt-1 hidden"></p>
          </div>

          {{-- Summary Card --}}
          <div class="col-span-1 md:col-span-2">
            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
              <h3 class="font-semibold text-gray-800 mb-3">Summary</h3>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                <div>
                  <div class="text-gray-500">MRP</div>
                  <div class="text-lg font-bold" id="mrpTxt">₹0.00</div>
                </div>
                <div>
                  <div class="text-gray-500">Discount</div>
                  <div class="text-lg font-bold" id="discountTxt">₹0.00</div>
                </div>
                <div>
                  <div class="text-gray-500">Final Payable</div>
                  <div class="text-2xl font-extrabold text-green-700" id="finalTxt">₹0.00</div>
                </div>
              </div>
            </div>
          </div>

          {{-- Actions --}}
          <div class="col-span-1 md:col-span-2 flex items-center gap-3">
            <button class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">
              Create Link
            </button>
            <a href="{{ route('paylink.index') }}"
               class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200">
              Back to List
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Copy buttons (flash + session link)
    document.querySelectorAll('.copy-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const url = btn.getAttribute('data-copy');
        if(!url) return;
        navigator.clipboard.writeText(url).then(() => {
          btn.textContent = 'Copied!';
          setTimeout(() => btn.textContent = 'Copy Link', 1500);
        });
      });
    });

    const pkgSel = document.getElementById('packageSelect');
    const typeSel = document.getElementById('discountType');
    const valInp  = document.getElementById('discountValue');

    const mrpTxt = document.getElementById('mrpTxt');
    const discountTxt = document.getElementById('discountTxt');
    const finalTxt = document.getElementById('finalTxt');

    const expiresAt = document.getElementById('expiresAt');
    const expiryPreview = document.getElementById('expiryPreview');

    function toMoney(n){ return '₹' + (Number(n||0).toFixed(2)); }

    function calc(){
      const opt = pkgSel.options[pkgSel.selectedIndex];
      const base = opt ? Number(opt.dataset.price || 0) : 0;

      const t = typeSel.value;
      const v = Number(valInp.value || 0);

      let disc = 0;
      if(t === 'flat') {
        disc = Math.min(v, base);
      } else if(t === 'percent') {
        disc = Math.min((base * v) / 100, base);
      }

      const final = Math.max(base - disc, 0);

      mrpTxt.textContent = toMoney(base);
      discountTxt.textContent = toMoney(disc);
      finalTxt.textContent = toMoney(final);
    }

    function showExpiry(){
      if(!expiresAt.value){ expiryPreview.classList.add('hidden'); return; }
      const when = new Date(expiresAt.value);
      if(isNaN(when.getTime())) { expiryPreview.classList.add('hidden'); return; }
      expiryPreview.classList.remove('hidden');
      expiryPreview.textContent = 'Link will expire on: ' + when.toLocaleString();
    }

    [pkgSel, typeSel, valInp].forEach(el => el.addEventListener('input', calc));
    expiresAt && expiresAt.addEventListener('input', showExpiry);

    // Initial compute on load
    calc(); showExpiry();

    // Enforce phone format 91 + 10 digits
    const phone = document.getElementById('phone');
    phone.addEventListener('input', () => {
      phone.value = phone.value.replace(/\D/g, '').slice(0, 12);
      if(!phone.value.startsWith('91')) phone.value = '91';
    });
  </script>
</x-app-layout>
