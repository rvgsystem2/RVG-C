<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow px-6 py-4 rounded-lg">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ isset($category) ? 'Edit Category' : 'Create Category' }}
            </h2>
            <a href="{{ route('package-categories.index') }}" class="px-4 py-2 rounded-lg border bg-gray-50 hover:bg-gray-100">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl shadow border border-gray-200">

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ isset($category) ? route('package-categories.update', $category->id) : route('package-categories.store') }}"
                      class="space-y-5">
                    @csrf
                    {{-- @if(isset($category)) @method('PUT') @endif --}}

                    {{-- Name --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Category Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $category->name ?? '') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                               placeholder="e.g., Jewellery, Digital Marketing, Website" required>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Status</label>
                        <div class="grid grid-cols-2 gap-3 max-w-xs">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="status" value="active"
                                       class="text-green-600 focus:ring-green-500"
                                       {{ old('status', $category->status ?? 'active') === 'active' ? 'checked' : '' }}>
                                <span>Active</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="status" value="inactive"
                                       class="text-red-600 focus:ring-red-500"
                                       {{ old('status', $category->status ?? '') === 'inactive' ? 'checked' : '' }}>
                                <span>Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                            {{ isset($category) ? 'Update Category' : 'Create Category' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
