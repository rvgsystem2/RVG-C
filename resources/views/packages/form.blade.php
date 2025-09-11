<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($package) ? 'Edit Package' : 'Create Package' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">
                    {{ isset($package) ? 'Edit Package' : 'Create New Package' }}
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

                <form action="{{ isset($package) ? route('package.update', $package->id) : route('package.store') }}"
                    method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    {{-- @if (isset($package))
                        @method('PUT')
                    @endif --}}

                    {{-- Row 1: Label + Name --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Category</label>
                            <select name="package_category_id"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('package_category_id', $package->package_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Label</label>
                            <input type="text" name="label" value="{{ old('label', $package->label ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                                placeholder="e.g. Basic / Pro / Popular" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Name</label>
                            <input type="text" name="name" value="{{ old('name', $package->name ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                                placeholder="Enter package name" required>
                        </div>
                    </div>

                    {{-- Short Description --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Short Description</label>
                        <input type="text" name="short_description"
                            value="{{ old('short_description', $package->short_description ?? '') }}" maxlength="300"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                            placeholder="One-liner summary (max 300 chars)">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                            placeholder="Detailed package description...">{{ old('description', $package->description ?? '') }}</textarea>
                    </div>

                    {{-- Row 2: Price + Sale Price + Duration Days --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Price (₹)</label>
                            <input type="text" name="price" value="{{ old('price', $package->price ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                                placeholder="e.g. 3540" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Sale Price (₹)</label>
                            <input type="text" name="sale_price"
                                value="{{ old('sale_price', $package->sale_price ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                                placeholder="Optional">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Duration (days)</label>
                            <input type="number" name="duration_days" min="1"
                                value="{{ old('duration_days', $package->duration_days ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                                placeholder="e.g. 365">
                        </div>
                    </div>

                    {{-- Row 3: Status --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                            @php
                                $statuses = ['active' => 'Active', 'inactive' => 'Inactive', 'draft' => 'Draft'];
                                $selectedStatus = old('status', $package->status ?? 'active');
                            @endphp
                            @foreach ($statuses as $val => $label)
                                <option value="{{ $val }}" {{ $selectedStatus === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Row 4: Image + Image Alt --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Main Image</label>
                            <input type="file" name="image"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                            @if (isset($package) && $package->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $package->image) }}" alt="current image"
                                        class="h-24 rounded border">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Image Alt Text</label>
                            <input type="text" name="image_alt"
                                value="{{ old('image_alt', $package->image_alt ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                                placeholder="Describe the image for SEO/accessibility">
                        </div>
                    </div>

                    {{-- Row 5: Thumbnail --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Thumbnail</label>
                        <input type="file" name="thumbnail"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                        @if (isset($package) && $package->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="current thumbnail"
                                    class="h-16 rounded border">
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition">
                            {{ isset($package) ? 'Update' : 'Submit' }}
                        </button>
                        <a href="{{ route('package.index') }}"
                            class="ml-3 px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        if (document.getElementById("description")) {
            CKEDITOR.replace("description", {
                removeButtons: 'PasteFromWord'
            });
        }
    });
</script>

</x-app-layout>
