<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Banner Management') }}
            </h2>
            <button onclick="openBannerModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Banner
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Banners</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead
                            class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Subtitle</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($banners as $banner)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        @if ($banner->image)
                                            <img src="{{ asset('storage/' . $banner->image) }}"
                                                alt="{{ $banner->img_alt_text }}"
                                                class="h-50 w-20 object-cover rounded">
                                        @else
                                            <span class="text-gray-400 italic">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $banner->title }}</td>
                                    <td class="px-4 py-3">{{ $banner->subtitle }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $banner->status }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)"
                                                onclick='openBannerModal(@json($banner))'
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('banner.delete', $banner->id) }}" method="get"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                <button
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-400">No banners found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="bannerModal"
        class="fixed inset-0 z-50 bg-black bg-opacity-60 hidden items-center justify-center transition-all duration-300">
        <!-- Click outside to close -->
        <div onclick="closeBannerModal()" class="absolute inset-0 z-40"></div>

        <!-- Modal content -->
        <div
            class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-xl z-50 animate__animated animate__fadeInDown">
            <h3 class="text-xl font-semibold mb-4" id="bannerModalTitle">Add Banner</h3>

            <form id="bannerForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="banner_id" id="banner_id">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="banner_title"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                        <input type="text" name="subtitle" id="banner_subtitle"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    {{-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none">
                    </div> --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="banner_image_input"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none"
                            onchange="previewImage(event)">

                        <div class="mt-2">
                            <img id="banner_image_preview" src="#" alt="Image Preview"
                                class="h-20 rounded shadow hidden object-cover" />
                        </div>
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                        <input type="text" name="img_alt_text" id="banner_img_alt"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="banner_status"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeBannerModal()"
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
    function openBannerModal(banner = null) {
    const modal = document.getElementById('bannerModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    const form = document.getElementById('bannerForm');
    const methodInput = document.getElementById('formMethod');
    const preview = document.getElementById('banner_image_preview');

    if (banner) {
        document.getElementById('bannerModalTitle').innerText = 'Edit Banner';
        form.action = `{{ url('/banner/update') }}/${banner.id}`;
        methodInput.value = 'POST';

        // Show existing image
        if (banner.image) {
            preview.src = `/storage/${banner.image}`;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    } else {
        document.getElementById('bannerModalTitle').innerText = 'Add Banner';
        form.action = `{{ route('banner.store') }}`;
        methodInput.value = 'POST';
        preview.classList.add('hidden');
    }

    document.getElementById('banner_title').value = banner?.title ?? '';
    document.getElementById('banner_subtitle').value = banner?.subtitle ?? '';
    document.getElementById('banner_img_alt').value = banner?.img_alt_text ?? '';
    document.getElementById('banner_status').value = banner?.status ?? 'active';
}

function closeBannerModal() {
        const modal = document.getElementById('bannerModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
  </script>

</x-app-layout>
