<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Service Details Management') }}
            </h2>
            <button onclick="openServiceModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md hover:from-blue-900 hover:to-green-600 transition">
                + Add Service Detail
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Service Details</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Short Description</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($serviceDetails as $detail)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $detail->category->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $detail->sort_description }}</td>
                                    <td class="px-4 py-3">
                                        @if ($detail->image)
                                            <img src="{{ asset('storage/' . $detail->image) }}"
                                                alt="{{ $detail->image_alt }}"
                                                class="w-20 h-14 object-cover rounded">
                                        @else
                                            <span class="text-gray-400 italic">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)"
                                                onclick='openServiceModal(@json($detail))'
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>

                                            <form action="{{ route('service-detail.delete', $detail->id) }}"
                                                method="POST"
                                                onsubmit="deleteServiceDetail(event)"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-400 text-base">
                                        No service details found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $serviceDetails->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="serviceModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto flex justify-center items-center">
        <div class="bg-white w-full max-w-3xl mx-4 my-8 p-6 rounded shadow-lg relative animate__animated animate__fadeInDown">
            <h2 class="text-xl font-bold mb-4" id="modalTitle">Add Service Detail</h2>

            <form id="serviceForm" action="{{ route('service-detail.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="detail_id" id="detail_id">

                <div id="formErrors"
                    class="hidden mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 text-sm">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                        <input type="text" name="sort_description" id="sort_description"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="image" onchange="previewImage(event)"
                            class="w-full border rounded px-3 py-2">
                        <img id="preview" src="" alt="Preview" class="mt-2 hidden h-20 rounded border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image Alt Text</label>
                        <input type="text" name="image_alt" id="image_alt"
                            class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="mt-4 flex justify-end gap-3">
                    <button type="button" onclick="closeServiceModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-green-600 text-white rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('description');

        function openServiceModal(detail = null) {
            const modal = document.getElementById('serviceModal');
            const form = document.getElementById('serviceForm');
            const preview = document.getElementById('preview');
            const errorsBox = document.getElementById('formErrors');
            const submitBtn = document.getElementById('submitBtn');

            modal.classList.remove('hidden');

            errorsBox.classList.add('hidden');
            errorsBox.innerHTML = '';

            submitBtn.disabled = false;
            submitBtn.innerText = 'Save';

            document.getElementById('modalTitle').innerText = detail ? 'Edit Service Detail' : 'Add Service Detail';
            document.getElementById('detail_id').value = detail?.id ?? '';

            form.action = detail
                ? `/service-detail/update/${detail.id}`
                : `{{ route('service-detail.store') }}`;

            document.getElementById('category_id').value = detail?.category_id ?? '';
            document.getElementById('sort_description').value = detail?.sort_description ?? '';
            document.getElementById('image_alt').value = detail?.image_alt ?? '';
            document.getElementById('image').value = '';

            if (CKEDITOR.instances.description) {
                CKEDITOR.instances.description.setData(detail?.description ?? '');
            }

            if (detail?.image) {
                preview.src = `/storage/${detail.image}`;
                preview.classList.remove('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }

            removeFieldErrors();
        }

        function closeServiceModal() {
            document.getElementById('serviceModal').classList.add('hidden');
            clearForm();
            clearFormErrors();
        }

        function clearForm() {
            const form = document.getElementById('serviceForm');

            form.reset();
            document.getElementById('detail_id').value = '';
            document.getElementById('preview').src = '';
            document.getElementById('preview').classList.add('hidden');

            if (CKEDITOR.instances.description) {
                CKEDITOR.instances.description.setData('');
            }

            document.getElementById('serviceForm').action = `{{ route('service-detail.store') }}`;
            document.getElementById('modalTitle').innerText = 'Add Service Detail';
            document.getElementById('submitBtn').innerText = 'Save';
            document.getElementById('submitBtn').disabled = false;
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function clearFormErrors() {
            const errorsBox = document.getElementById('formErrors');
            errorsBox.classList.add('hidden');
            errorsBox.innerHTML = '';
            removeFieldErrors();
        }

        function removeFieldErrors() {
            const fields = ['category_id', 'sort_description', 'image', 'image_alt', 'description'];
            fields.forEach(field => {
                const el = document.getElementById(field);
                if (el) {
                    el.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                }
            });
        }

        function showFormErrors(errors) {
            clearFormErrors();

            const errorsBox = document.getElementById('formErrors');
            let html = '<ul class="list-disc pl-5 space-y-1">';

            Object.keys(errors).forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                }

                errors[field].forEach(message => {
                    html += `<li>${message}</li>`;
                });
            });

            html += '</ul>';

            errorsBox.innerHTML = html;
            errorsBox.classList.remove('hidden');
        }

        document.getElementById('serviceForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            clearFormErrors();

            const form = this;
            const submitBtn = document.getElementById('submitBtn');

            if (CKEDITOR.instances.description) {
                CKEDITOR.instances.description.updateElement();
            }

            const formData = new FormData(form);

            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();

                if (!response.ok) {
                    if (response.status === 422) {
                        showFormErrors(result.errors || {});
                    } else {
                        alert(result.message || 'Something went wrong.');
                    }

                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Save';
                    return;
                }

                alert(result.message || 'Saved successfully.');
                closeServiceModal();
                window.location.reload();

            } catch (error) {
                console.error(error);
                alert('Something went wrong. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Save';
            }
        });

        async function deleteServiceDetail(event) {
            event.preventDefault();

            if (!confirm('Are you sure you want to delete this service detail?')) {
                return false;
            }

            const form = event.target;
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();

                if (!response.ok) {
                    alert(result.message || 'Delete failed.');
                    return false;
                }

                alert(result.message || 'Deleted successfully.');
                window.location.reload();

            } catch (error) {
                console.error(error);
                alert('Something went wrong while deleting.');
            }

            return false;
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeServiceModal();
            }
        });

        document.getElementById('serviceModal').addEventListener('click', function(e) {
            if (e.target.id === 'serviceModal') {
                closeServiceModal();
            }
        });
    </script>
</x-app-layout>