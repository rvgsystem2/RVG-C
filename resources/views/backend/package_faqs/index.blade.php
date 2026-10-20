{{-- resources/views/backend/package_faqs/index_grouped.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Package FAQs</h2>
  </x-slot>

  <div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow-md">

        @if (session('success'))
          <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mb-4">
          <a href="{{ route('package_faqs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add FAQ</a>
        </div>

        @forelse($packages as $pkg)
          <div id="pkg-{{ $pkg->id }}" class="mb-8 border-b pb-6 {{ (string)($highlight ?? '') === (string)$pkg->id ? 'ring-2 ring-blue-400 rounded-lg p-2' : '' }}">
            <div class="flex items-center justify-between mb-3">
              <div>
                <h3 class="text-lg font-semibold">{{ $pkg->name }}</h3>
                <p class="text-sm text-gray-500">FAQs: {{ $pkg->faqs->count() }}</p>
              </div>
              <a href="{{ route('package_faqs.create', ['package_id'=>$pkg->id]) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Add FAQ</a>
            </div>

            <div class="space-y-3">
              @foreach($pkg->faqs as $faq)
                <details class="border rounded-lg p-4">
                  <summary class="cursor-pointer font-medium flex items-center justify-between">
                    <span>{{ $faq->question }}</span>
                    <span class="text-xs px-2 py-1 rounded {{ $faq->status==='active'?'bg-green-100 text-green-700':'bg-gray-100 text-gray-700' }}">
                      {{ ucfirst($faq->status) }}
                    </span>
                  </summary>
                  <div class="mt-3 text-gray-700 prose prose-sm max-w-none">
                    {!! $faq->answer !!}
                  </div>
                  <div class="mt-3 flex gap-2">
                    <a href="{{ route('package_faqs.edit', $faq->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">Edit</a>
                    <form action="{{ route('package_faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Delete this FAQ?')">
                      @csrf @method('DELETE')
                      <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">Delete</button>
                    </form>
                  </div>
                </details>
              @endforeach
            </div>
          </div>
        @empty
          <p>No FAQs found.</p>
        @endforelse

        <div class="mt-4">
          {{ $packages->withQueryString()->links() }}
        </div>
      </div>
    </div>
  </div>

  @if(!empty($highlight))
  <script>
    window.addEventListener('load', () => {
      const el = document.getElementById('pkg-{{ $highlight }}');
      if (el) el.scrollIntoView({behavior:'smooth', block:'center'});
    });
  </script>
  @endif
</x-app-layout>
