{{-- resources/views/backend/package_media/form.blade.php --}}
<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">
    {{ isset($media) ? 'Edit Media' : 'Add Media' }}
  </h2></x-slot>

  <div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow-md">

        @if ($errors->any())
          <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        <form action="{{ isset($media) ? route('package_media.update',$media->id) : route('package_media.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf @if(isset($media)) @method('PUT') @endif

          {{-- attach to package --}}
          <div>
            <label class="block mb-2">Attach to Package (optional)</label>
            <select name="package_id" class="w-full px-3 py-2 border rounded">
              <option value="">— None —</option>
              @foreach($packages as $p)
                <option value="{{ $p->id }}"
                  {{ old('package_id', $preselect ?? ($media->package_id ?? '')) == $p->id ? 'selected' : '' }}>
                  {{ $p->name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- status + alt --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block mb-2">Status</label>
              @php $sel = old('status', $media->status ?? 'active'); @endphp
              <select name="status" class="w-full px-3 py-2 border rounded">
                <option value="active"   {{ $sel=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ $sel=='inactive'?'selected':'' }}>Inactive</option>
              </select>
            </div>
            <div>
              <label class="block mb-2">Alt/Caption (optional)</label>
              <input type="text" name="alt" value="{{ old('alt', $media->alt ?? '') }}"
                     class="w-full px-3 py-2 border rounded">
            </div>
          </div>

          @if(!isset($media))
            {{-- MULTI upload --}}
            <div>
              <label class="block mb-2">Files (multiple allowed)</label>
              <input type="file" id="filesInput" name="files[]" multiple
                     accept="image/*,video/*,application/pdf"
                     class="w-full px-3 py-2 border rounded">
              <div id="filesPreview" class="mt-3 flex gap-3 overflow-x-auto"></div>
            </div>
          @else
            {{-- single replace on edit --}}
            <div>
              <label class="block mb-2">Replace File (optional)</label>
              <input type="file" id="fileEdit" name="file"
                     accept="image/*,video/*,application/pdf"
                     class="w-full px-3 py-2 border rounded">

              <div class="mt-2" id="currentPreview">
                @if($media->type==='image' && $media->path)
                  <img src="{{ asset('storage/'.$media->path) }}" class="h-24 rounded border" alt="">
                @elseif($media->type==='video' && $media->path)
                  <video src="{{ asset('storage/'.$media->path) }}" class="h-24 rounded border" controls muted playsinline></video>
                @elseif($media->type==='pdf' && $media->path)
                  <a href="{{ asset('storage/'.$media->path) }}" target="_blank" class="text-blue-600 underline">Open PDF</a>
                @endif
              </div>

              <div id="newPreview" class="mt-2"></div>
            </div>
          @endif

          <div>
            <button class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              {{ isset($media) ? 'Update' : 'Submit' }}
            </button>
            <a href="{{ route('package_media.index') }}"
               class="ml-2 px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancel</a>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script>
    // Create: multi preview
    const filesInput = document.getElementById('filesInput');
    const filesPreview = document.getElementById('filesPreview');
    filesInput?.addEventListener('change', e=>{
      filesPreview.innerHTML='';
      [...e.target.files].forEach(f=>{
        const url = URL.createObjectURL(f);
        let el;
        if (f.type.startsWith('image/')) { el=document.createElement('img'); el.src=url; el.className='h-24 rounded border'; }
        else if (f.type.startsWith('video/')) { el=document.createElement('video'); el.src=url; el.className='h-24 rounded border'; el.controls=true; el.muted=true; el.playsInline=true; }
        else if (f.type==='application/pdf') { el=document.createElement('a'); el.href=url; el.textContent=f.name; el.target='_blank'; el.className='text-blue-600 underline px-3 py-2 border rounded'; }
        else { el=document.createElement('div'); el.textContent=f.name; el.className='px-3 py-2 border rounded text-xs text-gray-500'; }
        filesPreview.appendChild(el);
      });
    });

    // Edit: single preview
    const fileEdit = document.getElementById('fileEdit');
    const newPreview = document.getElementById('newPreview');
    fileEdit?.addEventListener('change', e=>{
      newPreview.innerHTML='';
      const f = e.target.files[0]; if(!f) return;
      const url = URL.createObjectURL(f);
      let el;
      if (f.type.startsWith('image/')) { el=document.createElement('img'); el.src=url; el.className='h-24 rounded border'; }
      else if (f.type.startsWith('video/')) { el=document.createElement('video'); el.src=url; el.className='h-24 rounded border'; el.controls=true; el.muted=true; el.playsInline=true; }
      else if (f.type==='application/pdf') { el=document.createElement('a'); el.href=url; el.textContent=f.name; el.target='_blank'; el.className='text-blue-600 underline px-3 py-2 border rounded'; }
      newPreview.appendChild(el);
    });
  </script>
</x-app-layout>
