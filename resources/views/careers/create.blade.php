<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ isset($career) ? 'Edit Job' : 'Add New Job' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">

            {{-- Global Error Alert --}}
            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Whoops! Something went wrong.</strong>
                    <ul class="mt-2 list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ isset($career) ? route('careers.update', $career) : route('careers.store') }}">
                @csrf
                @if(isset($career))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $career->title ?? '') }}"
                            class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">Location</label>
                        <input type="text" name="location" value="{{ old('location', $career->location ?? 'Kanpur') }}"
                            class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">Type <span class="text-red-500">*</span></label>
                        <select name="type" class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                            @foreach(['Full Time', 'Part Time', 'Internship', 'Contract'] as $type)
                                <option value="{{ $type }}" @selected(old('type', $career->type ?? '') == $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience -->
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">Experience (Years)</label>
                        <input type="text" name="experience" min="0" value="{{ old('experience', $career->experience ?? '') }}"
                            class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                        @error('experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valid Through -->
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">Valid Through</label>
                        <input type="date" name="valid_through" value="{{ old('valid_through', $career->valid_through ?? '') }}"
                            class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                        @error('valid_through')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                            <option value="active" @selected(old('status', $career->status ?? '') == 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $career->status ?? '') == 'inactive')>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label class="block font-semibold mb-1 text-gray-700">Description</label>
                    <textarea id="description-editor" name="description" rows="5" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        {{ old('description', $career->description ?? '') }}
                    </textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6 text-right">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 transition">
                        {{ isset($career) ? 'Update Job' : 'Add Job' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description-editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
