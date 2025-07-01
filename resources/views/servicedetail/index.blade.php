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
                                    <td class="px-4 py-3">{{ $detail->category->name }}</td>
                                    <td class="px-4 py-3">{{ $detail->sort_description }}</td>
                                    <td class="px-4 py-3">
                                        @if ($detail->image)
                                            <img src="{{ asset('storage/' . $detail->image) }}" alt="{{ $detail->image_alt }}" class="w-20 h-14 object-cover rounded">
                                        @else
                                            <span class="text-gray-400 italic">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openServiceModal(@json($detail))'
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('service-detail.delete', $detail->id) }}" method="get" onsubmit="return confirm('Are you sure?')" class="inline-block">
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
                                    <td colspan="4" class="text-center py-6 text-gray-400 text-base">
                                        No service details found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
<!-- Modal -->
<div id="serviceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto flex justify-center items-center">
    <div class="bg-white w-full max-w-3xl mx-4 my-8 p-6 rounded shadow-lg relative animate__animated animate__fadeInDown">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Add Service Detail</h2>

        <form id="serviceForm" action="{{ route('service-detail.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="detail_id" id="detail_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Short Description</label>
                    <input type="text" name="sort_description" id="sort_description" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" onchange="previewImage(event)" class="w-full border rounded px-3 py-2">
                    <img id="preview" src="" alt="Preview" class="mt-2 hidden h-20 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image Alt Text</label>
                    <input type="text" name="image_alt" id="image_alt" class="w-full border rounded px-3 py-2">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="5" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="mt-4 flex justify-end gap-3">
                <button type="button" onclick="closeServiceModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');

    function openServiceModal(detail = null) {
        const modal = document.getElementById('serviceModal');
        modal.classList.remove('hidden');

        document.getElementById('modalTitle').innerText = detail ? 'Edit Service Detail' : 'Add Service Detail';

        const form = document.getElementById('serviceForm');
        const method = document.getElementById('formMethod');

        form.action = detail ? `/service-detail/update/${detail.id}` : `{{ route('service-detail.store') }}`;
        method.value = 'POST';

        document.getElementById('detail_id').value = detail?.id ?? '';
        document.getElementById('category_id').value = detail?.category_id ?? '';
        document.getElementById('sort_description').value = detail?.sort_description ?? '';
        document.getElementById('image_alt').value = detail?.image_alt ?? '';

        if (CKEDITOR.instances.description) {
            CKEDITOR.instances.description.setData(detail?.description ?? '');
        }

        const preview = document.getElementById('preview');
        if (detail?.image) {
            preview.src = `/storage/${detail.image}`;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function closeServiceModal() {
        document.getElementById('serviceModal').classList.add('hidden');
    }
</script>
</x-app-layout>
