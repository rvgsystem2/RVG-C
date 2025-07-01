<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($banner) ? 'Edit Banner' : 'Create Banner' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">
                    {{ isset($banner) ? 'Edit Banner' : 'Add New Banner' }}
                </h2>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($banner) ? route('banner.update', $banner->id) : route('banner.store') }}"
                      method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    {{-- @if(isset($banner)) @method('PUT') @endif --}}

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                               placeholder="Enter banner title">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Subtitle</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle ?? '') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                               placeholder="Enter banner subtitle">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Banner Image</label>
                        <input type="file" name="image" class="w-full px-4 py-2 border rounded-lg">
                        @if (isset($banner) && $banner->image)
                            <img src="{{ asset('storage/' . $banner->image) }}" class="mt-3 h-20 rounded" alt="Banner Preview">
                        @endif
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Alt Text</label>
                        <input type="text" name="img_alt_text" value="{{ old('img_alt_text', $banner->img_alt_text ?? '') }}"
                               class="w-full px-4 py-2 border rounded-lg" placeholder="For image SEO/accessibility">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border rounded-lg">
                            @foreach(['active', 'inactive', 'draft'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $banner->status ?? '') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 shadow">
                            {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
