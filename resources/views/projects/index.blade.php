
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Project Management') }}
            </h2>
            <button onclick="openProjectModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md hover:from-blue-900 hover:to-green-600 transition">
                + Add Project
            </button>
        </div>
    </x-slot>

    <!-- rest of your content -->

    <!-- paste everything below this point from previous version -->

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Projects</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Short Description</th>
                                <th class="px-4 py-3">Thumb Image</th>
                                <th class="px-4 py-3">Project Images</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($projects as $project)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $project->project_category_name }}</td>
                                <td class="px-4 py-3">{{ $project->title }}</td>
                                <td class="px-4 py-3">{{ $project->sort_description }}</td>
                                <td class="px-4 py-3">
                                    @if ($project->thumb_image)
                                    <img src="{{ asset('storage/' . $project->thumb_image) }}" class="w-40 h-40 object-cover rounded">
                                    @else
                                    <span class="text-gray-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($project->project_images)
                                        @php
                                            $images = json_decode($project->project_images, true);
                                        @endphp
                                        <div id="carousel-{{ $project->id }}" class="relative w-40 overflow-hidden">
                                            <div class="whitespace-nowrap transition-transform duration-500 ease-in-out" style="width: max-content; animation: slideLeft 15s linear infinite;">
                                                @foreach ($images as $image)
                                                    <img src="{{ asset('storage/' . $image) }}" class="inline-block w-40 h-40 object-cover rounded mr-2">
                                                @endforeach
                                            </div>
                                        </div>
                                        <style>
                                            @keyframes slideLeft {
                                                0% { transform: translateX(0); }
                                                100% { transform: translateX(-100%); }
                                            }
                                        </style>
                                    @else
                                        <span class="text-gray-400 italic">No Images</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="javascript:void(0)" onclick='openProjectModal(@json($project))'
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('projects.delete', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline-block">
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
                                <td colspan="5" class="text-center py-6 text-gray-400 text-base">
                                    No projects found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <!-- (Modal HTML remains the same...) -->

<!-- Modal Form -->
<div id="projectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto flex justify-center items-center">
    <div class="bg-white w-full max-w-3xl mx-4 my-8 p-6 rounded shadow-lg relative animate__animated animate__fadeInDown">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Add Project</h2>

        <form id="projectForm" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="project_id" id="project_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Project Category Name</label>
                    <input type="text" name="project_category_name" id="project_category_name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Short Description</label>
                    <input type="text" name="sort_description" id="sort_description" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Thumb Image</label>
                    <input type="file" name="thumb_image" id="thumb_image" onchange="previewThumb(event)" class="w-full border rounded px-3 py-2">
                    <img id="thumb_preview" src="" class="mt-2 hidden h-20 rounded" />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Project Images (Multiple)</label>
                    <input type="file" name="project_images[]" id="project_images" multiple onchange="previewGalleryImages(event)" class="w-full border rounded px-3 py-2">
                    <div id="galleryPreview" class="flex flex-wrap gap-2 mt-2"></div>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Project URL</label>
                    <input type="text" name="project_url" id="project_url" class="w-full border rounded px-3 py-2">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="w-full border rounded px-3 py-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-3">
                <button type="button" onclick="closeProjectModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
        function openProjectModal(project = null) {
            const modal = document.getElementById('projectModal');
            modal.classList.remove('hidden');

            document.getElementById('modalTitle').innerText = project ? 'Edit Project' : 'Add Project';
            const form = document.getElementById('projectForm');
            form.action = project ? `/projects/update/${project.id}` : `{{ route('projects.store') }}`;
            document.getElementById('formMethod').value = 'POST';

            document.getElementById('project_id').value = project?.id ?? '';
            document.getElementById('project_category_name').value = project?.project_category_name ?? '';
            document.getElementById('title').value = project?.title ?? '';
            document.getElementById('sort_description').value = project?.sort_description ?? '';
            document.getElementById('project_url').value = project?.project_url ?? '';
            document.getElementById('status').value = project?.status ?? 'active';

            const thumbPreview = document.getElementById('thumb_preview');
            if (project?.thumb_image) {
                thumbPreview.src = `/storage/${project.thumb_image}`;
                thumbPreview.classList.remove('hidden');
            } else {
                thumbPreview.classList.add('hidden');
            }

            const gallery = document.getElementById('galleryPreview');
            gallery.innerHTML = '';
            if (project?.project_images) {
                let images = [];
                try {
                    images = JSON.parse(project.project_images);
                } catch (e) {
                    console.error('Invalid JSON in project_images', e);
                }
                images.forEach(src => {
                    const img = document.createElement('img');
                    img.src = `/storage/${src}`;
                    img.classList = 'h-20 w-20 object-cover rounded';
                    gallery.appendChild(img);
                });
            }
        }

        function closeProjectModal() {
            document.getElementById('projectModal').classList.add('hidden');
            document.getElementById('projectForm').reset();
            document.getElementById('thumb_preview').classList.add('hidden');
            document.getElementById('galleryPreview').innerHTML = '';
        }

        function previewThumb(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const img = document.getElementById('thumb_preview');
                img.src = reader.result;
                img.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewGalleryImages(event) {
            const gallery = document.getElementById('galleryPreview');
            gallery.innerHTML = '';
            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList = 'h-20 w-20 object-cover rounded';
                    gallery.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>

</x-app-layout>


