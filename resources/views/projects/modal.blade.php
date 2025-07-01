<!-- Project Modal -->
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

        // Show existing thumb image if editing
        const thumbPreview = document.getElementById('thumb_preview');
        if (project?.thumb_image) {
            thumbPreview.src = `/storage/${project.thumb_image}`;
            thumbPreview.classList.remove('hidden');
        } else {
            thumbPreview.classList.add('hidden');
        }

        // Clear gallery preview
        document.getElementById('galleryPreview').innerHTML = '';
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
