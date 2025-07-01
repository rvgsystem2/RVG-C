<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('About Management') }}
            </h2>
            <button onclick="openAboutModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add About
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Abouts</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Subtitle</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($abouts as $about)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $about->title }}</td>
                                    <td class="px-4 py-3">{{ $about->subtitle }}</td>
                                    <td class="px-4 py-3">
                                        @if ($about->image)
                                            <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->image_alt }}"
                                                 class="h-16 w-16 object-cover rounded shadow">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 capitalize">{{ $about->status }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openAboutModal(@json($about))'
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('about.delete', $about->id) }}" method="get"
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
                                    <td colspan="4" class="text-center py-6 text-gray-400">No about records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="aboutModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closeAboutModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="aboutModalTitle">Add About</h3>

            <form id="aboutForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="about_id" id="about_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="about_title"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                        <input type="text" name="subtitle" id="about_subtitle"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="about_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="about_image_input"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none"
                               onchange="previewAboutImage(event)">
                        <div class="mt-2">
                            <img id="about_image_preview" src="#" alt="Image Preview"
                                 class="h-20 rounded shadow hidden object-cover" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                        <input type="text" name="image_alt" id="about_image_alt"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="about_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeAboutModal()"
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

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        function openAboutModal(about = null) {
            const modal = document.getElementById('aboutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('aboutForm');
            const preview = document.getElementById('about_image_preview');

            if (about) {
                document.getElementById('aboutModalTitle').innerText = 'Edit About';
                form.action = `/about/update/${about.id}`;
                document.getElementById('about_id').value = about.id;

                document.getElementById('about_title').value = about.title ?? '';
                document.getElementById('about_subtitle').value = about.subtitle ?? '';
                CKEDITOR.instances.about_description.setData(about.description ?? '');
                document.getElementById('about_image_alt').value = about.image_alt ?? '';
                document.getElementById('about_status').value = about.status ?? 'active';

                if (about.image) {
                    preview.src = `/storage/${about.image}`;
                    preview.classList.remove('hidden');
                } else {
                    preview.classList.add('hidden');
                }
            } else {
                document.getElementById('aboutModalTitle').innerText = 'Add About';
                form.action = `{{ route('about.store') }}`;
                form.reset();
                CKEDITOR.instances.about_description.setData('');
                preview.classList.add('hidden');
            }
        }

        function closeAboutModal() {
            const modal = document.getElementById('aboutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function previewAboutImage(event) {
            const input = event.target;
            const preview = document.getElementById('about_image_preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }

        // Initialize CKEditor
        window.onload = function () {
            CKEDITOR.replace('about_description');
        };
    </script>
</x-app-layout>
