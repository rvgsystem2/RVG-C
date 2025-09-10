{{-- resources/views/backend/package_media/index_grouped.blade.php --}}
<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Package Media (Grouped)</h2></x-slot>

  <div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow-md">

        @if (session('success'))
          <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mb-4">
          <a href="{{ route('package_media.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Media</a>
        </div>

        <style>
          .strip{display:flex;gap:.75rem;overflow-x:auto;padding-bottom:.25rem;scroll-snap-type:x mandatory}
          .card{flex:0 0 auto;scroll-snap-align:start;border:1px solid #e5e7eb;border-radius:.5rem;padding:.5rem;background:#fff}
          .card img,.card video{height:88px;border-radius:.375rem}
          .strip::-webkit-scrollbar{height:8px}
          .strip::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:9999px}
          .actions{display:flex;gap:.4rem;margin-top:.4rem}
        </style>

        @php $highlight = $highlight ?? null; @endphp
        @forelse($packages as $pkg)
          <div id="pkg-{{ $pkg->id }}" class="mb-8 border-b pb-6 {{ (string)$highlight === (string)$pkg->id ? 'ring-2 ring-blue-400 rounded-lg p-2' : '' }}">
            <div class="flex items-center justify-between mb-3">
              <div>
                <h3 class="text-lg font-semibold">{{ $pkg->name }}</h3>
                <p class="text-sm text-gray-500">Total: {{ $pkg->media->count() }} files</p>
              </div>
              <a href="{{ route('package_media.create', ['package_id'=>$pkg->id]) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Upload more</a>
            </div>

            <div class="strip">
              @foreach($pkg->media as $m)
                <div class="card">
                  @if($m->type === 'image' && $m->path)
                    <img src="{{ asset('storage/'.$m->path) }}" alt="{{ $m->alt ?? 'image' }}">
                  @elseif($m->type === 'video' && $m->path)
                    <video src="{{ asset('storage/'.$m->path) }}" muted playsinline controls></video>
                  @elseif($m->type === 'pdf' && $m->path)
                    <a href="{{ asset('storage/'.$m->path) }}" target="_blank" class="block px-3 py-6 text-center bg-gray-50 rounded">
                      <span class="text-sm text-blue-600 underline">Open PDF</span>
                    </a>
                  @else
                    <div class="px-3 py-6 text-center bg-gray-50 rounded text-gray-400">—</div>
                  @endif

                  <div class="actions">
                    <a href="{{ route('package_media.edit', $m->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">Edit</a>
                    <form action="{{ route('package_media.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Delete this media?')">
                      @csrf @method('DELETE')
                      <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">Delete</button>
                    </form>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @empty
          <p>No media found.</p>
        @endforelse

        <div class="mt-4">{{ $packages->withQueryString()->links() }}</div>
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
