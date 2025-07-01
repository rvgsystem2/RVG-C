<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Service Category Management') }}
            </h2>
            <button onclick="openCategoryModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Category
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Categories</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Slug</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($categories as $cat)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <i class="fa {{ $cat->icon ?? 'fa-cog' }} text-gray-700 mr-2"></i>
                                        {{ $cat->name }}
                                    </td>
                                    <td class="px-4 py-3">{{ $cat->slug }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $cat->status }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openCategoryModal(@json($cat))'
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('service-category.delete', $cat->id) }}" method="get"
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-400">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closeCategoryModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="categoryModalTitle">Add Category</h3>

            <form id="categoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category_id" id="category_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="category_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200"
                               oninput="generateSlug(this.value)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" name="slug" id="category_slug"
                               class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-100" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon Class (e.g., fa-home)</label>
                        <input type="text" name="icon" id="icon_input"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none">
                        <div class="mt-2">
                            <i id="icon_preview" class="fa fa-cog text-2xl text-gray-600 hidden"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="category_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeCategoryModal()"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded shadow">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCategoryModal(category = null) {
            const modal = document.getElementById('categoryModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('categoryForm');
            const iconPreview = document.getElementById('icon_preview');

            if (category) {
                document.getElementById('categoryModalTitle').innerText = 'Edit Category';
                form.action = `/service-category/update/${category.id}`;
                document.getElementById('category_id').value = category.id;

                document.getElementById('category_name').value = category.name ?? '';
                document.getElementById('category_slug').value = category.slug ?? '';
                document.getElementById('category_status').value = category.status ?? 'active';
                document.getElementById('icon_input').value = category.icon ?? '';

                if (category.icon) {
                    iconPreview.className = `fa ${category.icon} text-2xl text-gray-600`;
                    iconPreview.classList.remove('hidden');
                } else {
                    iconPreview.classList.add('hidden');
                }
            } else {
                document.getElementById('categoryModalTitle').innerText = 'Add Category';
                form.action = `{{ route('service-category.store') }}`;
                form.reset();
                document.getElementById('category_slug').value = '';
                iconPreview.classList.add('hidden');
            }
        }

        function closeCategoryModal() {
            const modal = document.getElementById('categoryModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function generateSlug(name) {
            let slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('category_slug').value = slug;
        }

        document.getElementById('icon_input').addEventListener('input', function () {
            const preview = document.getElementById('icon_preview');
            const value = this.value.trim();
            if (value) {
                preview.className = `fa ${value} text-2xl text-gray-600`;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
