{{-- resources/views/backend/package_faqs/form.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ isset($faq) ? 'Edit FAQ' : 'Add FAQ' }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow-md">

        @if ($errors->any())
          <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ isset($faq) ? route('package_faqs.update', $faq->id) : route('package_faqs.store') }}"
              method="POST" class="space-y-6">
          @csrf
          @if(isset($faq)) @method('PUT') @endif

          <div>
            <label class="block text-gray-700 font-medium mb-2">Attach to Package (optional)</label>
            <select name="package_id" class="w-full px-3 py-2 border rounded">
              <option value="">— None —</option>
              @foreach($packages as $p)
                <option value="{{ $p->id }}"
                  {{ old('package_id', $preselect ?? ($faq->package_id ?? '')) == $p->id ? 'selected' : '' }}>
                  {{ $p->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Question</label>
            <input type="text" name="question"
                   value="{{ old('question', $faq->question ?? '') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                   placeholder="Enter question" required>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Answer</label>
            <textarea name="answer" id="answer" rows="6"
                      class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                      placeholder="Write the answer...">{{ old('answer', $faq->answer ?? '') }}</textarea>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Status</label>
            @php $sel = old('status', $faq->status ?? 'active'); @endphp
            <select name="status" class="w-full px-3 py-2 border rounded">
              <option value="active"   {{ $sel=='active'?'selected':'' }}>Active</option>
              <option value="inactive" {{ $sel=='inactive'?'selected':'' }}>Inactive</option>
            </select>
          </div>

          <div>
            <button class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              {{ isset($faq) ? 'Update' : 'Submit' }}
            </button>
            <a href="{{ route('package_faqs.index') }}"
               class="ml-2 px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancel</a>
          </div>
        </form>

      </div>
    </div>
  </div>

  {{-- CKEditor 4 for answer --}}
  <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      if (document.getElementById("answer")) {
        CKEDITOR.replace("answer", {
          removeButtons: 'PasteFromWord'
        });
      }
    });
  </script>
</x-app-layout>
