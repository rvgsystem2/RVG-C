<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Blog Category Management') }}
            </h2>
            <button onclick="openBlogCategoryModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Category
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Blog Categories</h2>

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
                                    <td class="px-4 py-3">{{ $cat->name }}</td>
                                    <td class="px-4 py-3">{{ $cat->slug }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $cat->status }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openBlogCategoryModal(@json($cat))'
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('blog-category.delete', $cat->id) }}" method="get"
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
    <div id="blogCategoryModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closeBlogCategoryModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="blogCategoryModalTitle">Add Blog Category</h3>

            <form id="blogCategoryForm" method="POST">
                @csrf
                <input type="hidden" name="category_id" id="blog_category_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="blog_category_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200"
                               oninput="generateBlogSlug(this.value)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" name="slug" id="blog_category_slug"
                               class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-100" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="blog_category_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeBlogCategoryModal()"
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
        function openBlogCategoryModal(category = null) {
            const modal = document.getElementById('blogCategoryModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('blogCategoryForm');

            if (category) {
                document.getElementById('blogCategoryModalTitle').innerText = 'Edit Blog Category';
                form.action = `/blog-category/update/${category.id}`;
                document.getElementById('blog_category_id').value = category.id;
                document.getElementById('blog_category_name').value = category.name ?? '';
                document.getElementById('blog_category_slug').value = category.slug ?? '';
                document.getElementById('blog_category_status').value = category.status ?? 'active';
            } else {
                document.getElementById('blogCategoryModalTitle').innerText = 'Add Blog Category';
                form.action = `{{ route('blog-category.store') }}`;
                form.reset();
                document.getElementById('blog_category_slug').value = '';
            }
        }

        function closeBlogCategoryModal() {
            const modal = document.getElementById('blogCategoryModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function generateBlogSlug(name) {
            let slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('blog_category_slug').value = slug;
        }
    </script>
</x-app-layout>
