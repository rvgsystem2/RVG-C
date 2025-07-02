<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Blog Management') }}
            </h2>
            <button onclick="openBlogModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Blog
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Blogs</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Author</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($blogs as $blog)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $blog->title }}</td>
                                    <td class="px-4 py-3">{{ $blog->category->name }}</td>
                                    <td class="px-4 py-3">{{ $blog->author }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openBlogModal(@json($blog))'
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('blog.delete', $blog->id) }}" method="get"
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
                                    <td colspan="4" class="text-center py-6 text-gray-400">No blogs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="blogModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closeBlogModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="blogModalTitle">Add Blog</h3>

            <form id="blogForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="blog_id" id="blog_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="blog_title"
                               class="w-full px-3 py-2 border border-gray-300 rounded" oninput="generateSlug(this.value)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" name="slug" id="blog_slug"
                               class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-100" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" name="author" id="blog_author"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Short Content</label>
                        <textarea name="sort_content" id="blog_sort_content"
                                  class="w-full px-3 py-2 border border-gray-300 rounded" rows="2"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="content" id="blog_content"
                                  class="w-full px-3 py-2 border border-gray-300 rounded" rows="4"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Image</label>
                        <input type="file" name="thumbnail_img" id="thumbnail_img"
                               class="w-full px-3 py-2 border border-gray-300 rounded" onchange="previewImage(this, 'thumbPreview')">
                        <img id="thumbPreview" class="mt-2 w-24 h-auto hidden rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Alt Text</label>
                        <input type="text" name="thumbnail_img_alt" id="thumbnail_img_alt"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Main Image</label>
                        <input type="file" name="image" id="image"
                               class="w-full px-3 py-2 border border-gray-300 rounded" onchange="previewImage(this, 'mainPreview')">
                        <img id="mainPreview" class="mt-2 w-24 h-auto hidden rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image Alt Text</label>
                        <input type="text" name="image_alt" id="image_alt"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeBlogModal()"
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

    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <script>
        function openBlogModal(blog = null) {
            const modal = document.getElementById('blogModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('blogForm');
            document.getElementById('thumbPreview').classList.add('hidden');
            document.getElementById('mainPreview').classList.add('hidden');

            if (blog) {
                document.getElementById('blogModalTitle').innerText = 'Edit Blog';
                form.action = `/blog/update/${blog.id}`;
                document.getElementById('blog_id').value = blog.id ?? '';
                document.getElementById('blog_title').value = blog.title ?? '';
                document.getElementById('blog_slug').value = blog.slug ?? '';
                document.getElementById('category_id').value = blog.category_id ?? '';
                document.getElementById('blog_author').value = blog.author ?? '';
                document.getElementById('blog_sort_content').value = blog.sort_content ?? '';
                CKEDITOR.instances.blog_content.setData(blog.content ?? '');
                document.getElementById('thumbnail_img_alt').value = blog.thumbnail_img_alt ?? '';
                document.getElementById('image_alt').value = blog.image_alt ?? '';

                if (blog.thumbnail_img) {
                    const thumb = document.getElementById('thumbPreview');
                    thumb.src = `/storage/${blog.thumbnail_img}`;
                    thumb.classList.remove('hidden');
                }
                if (blog.image) {
                    const main = document.getElementById('mainPreview');
                    main.src = `/storage/${blog.image}`;
                    main.classList.remove('hidden');
                }
            } else {
                document.getElementById('blogModalTitle').innerText = 'Add Blog';
                form.action = `{{ route('blog.store') }}`;
                form.reset();
                CKEDITOR.instances.blog_content.setData('');
            }
        }

        function closeBlogModal() {
            const modal = document.getElementById('blogModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function generateSlug(title) {
            let slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('blog_slug').value = slug;
        }

        function previewImage(input, targetId) {
            const preview = document.getElementById(targetId);
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('blog_content')) {
                CKEDITOR.replace('blog_content');
            }
        });
    </script>
</x-app-layout>
