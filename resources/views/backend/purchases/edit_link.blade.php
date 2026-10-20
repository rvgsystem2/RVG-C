{{-- resources/views/backend/purchases/edit_link.blade.php --}}
<x-app-layout>
  <x-slot name="header"><h2 class="font-bold text-xl">Edit Payment Link</h2></x-slot>

  <div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-xl rounded-2xl p-6">

        @if ($errors->any())
          <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc ml-5 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('paylink.update',$paymentLink->id) }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          @csrf
          @method('PUT')

          {{-- Package --}}
          <div>
            <label class="block mb-1 text-sm font-medium">Package</label>
            <select name="package_id" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
              @foreach($packages as $p)
                @php $price = $p->sale_price ?? $p->price; @endphp
                <option value="{{ $p->id }}"
                  {{ $paymentLink->package_id == $p->id ? 'selected' : '' }}>
                  {{ $p->name }} (₹{{ number_format($price,2) }})
                </option>
              @endforeach
            </select>
          </div>

          {{-- Phone --}}
          <div>
            <label class="block mb-1 text-sm font-medium">Customer Phone</label>
            <input name="phone" value="{{ old('phone',$paymentLink->phone) }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
          </div>

          {{-- Name --}}
          <div>
            <label class="block mb-1 text-sm font-medium">Customer Name</label>
            <input name="name" value="{{ old('name',$paymentLink->name) }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
          </div>

          {{-- Business --}}
          <div>
            <label class="block mb-1 text-sm font-medium">Business Name</label>
            <input name="business_name" value="{{ old('business_name',$paymentLink->business_name) }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
          </div>

          {{-- Discount Type --}}
          <div>
            <label class="block mb-1 text-sm font-medium">Discount Type</label>
            <select name="discount_type" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
              <option value="none" {{ $paymentLink->discount_type=='none'?'selected':'' }}>None</option>
              <option value="flat" {{ $paymentLink->discount_type=='flat'?'selected':'' }}>Flat</option>
              <option value="percent" {{ $paymentLink->discount_type=='percent'?'selected':'' }}>Percent</option>
            </select>
          </div>

          {{-- Discount Value --}}
          <div>
            <label class="block mb-1 text-sm font-medium">Discount Value</label>
            <input type="number" step="0.01" name="discount_value"
                   value="{{ old('discount_value',$paymentLink->discount_value) }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
          </div>

          {{-- Discount Reason --}}
          <div class="md:col-span-2">
            <label class="block mb-1 text-sm font-medium">Discount Reason</label>
            <input name="discount_reason"
                   value="{{ old('discount_reason',$paymentLink->discount_reason) }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
          </div>

          {{-- Expiry --}}
          <div>
            <label class="block mb-1 text-sm font-medium">Expires At</label>
            <input type="datetime-local" name="expires_at"
                   value="{{ old('expires_at',$paymentLink->expires_at?->format('Y-m-d\TH:i')) }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
          </div>

          <div class="md:col-span-2 flex gap-3">
            <button class="px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">Update</button>
            <a href="{{ route('paylink.index') }}" class="px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
