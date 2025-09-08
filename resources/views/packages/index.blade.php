<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Package Management') }}
            </h2>
            <button onclick="openPackageModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Package
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Packages</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($packages as $package)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium">{{ $package->name }}</td>
                                    <td class="px-4 py-3">
                                        <div class="line-clamp-2 max-w-[420px]">{{ strip_tags($package->description) }}</div>
                                    </td>
                                    <td class="px-4 py-3 font-semibold">₹ {{ number_format((float)$package->price, 2) }}</td>
                                    <td class="px-4 py-3">
                                        @if ($package->image)
                                            <img src="{{ asset('storage/' . $package->image) }}"
                                                 alt="{{ $package->image_alt ?? $package->name }}"
                                                 class="h-16 w-16 object-cover rounded shadow">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 capitalize">
                                        <span class="px-2 py-1 rounded text-xs
                                            {{ $package->status === 'active' ? 'bg-green-100 text-green-700' :
                                               ($package->status === 'inactive' ? 'bg-gray-100 text-gray-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ $package->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <button type="button" onclick='openPackageModal(@json($package))'
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </button>

                                            <form action="{{ route('package.delete', $package->id) }}" method="POST"
                                                  onsubmit="return confirm('Delete this package?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-400">No packages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $packages->links() ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="packageModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closePackageModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="packageModalTitle">Add Package</h3>

            <form id="packageForm" method="POST" enctype="multipart/form-data" action="{{ route('package.store') }}">
                @csrf
                <input type="hidden" name="package_id" id="package_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="pkg_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input type="text" name="price" id="pkg_price" placeholder="e.g. 2999"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="pkg_description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="pkg_image_input"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none"
                               accept="image/*" onchange="previewPackageImage(event)">
                        <div class="mt-2">
                            <img id="pkg_image_preview" src="#" alt="Image Preview"
                                 class="h-20 rounded shadow hidden object-cover" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                        <input type="text" name="image_alt" id="pkg_image_alt"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="pkg_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closePackageModal()"
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

    {{-- Optional: CKEditor 4 for rich description --}}
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        function openPackageModal(pkg = null) {
            const modal = document.getElementById('packageModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('packageForm');
            const preview = document.getElementById('pkg_image_preview');

            // Initialize CKEditor once
            if (!CKEDITOR.instances.pkg_description) {
                CKEDITOR.replace('pkg_description');
            }

            if (pkg) {
                document.getElementById('packageModalTitle').innerText = 'Edit Package';
                form.action = "{{ url('/package/update') }}/" + pkg.id;
                // Hidden id (optional if route includes id)
                document.getElementById('package_id').value = pkg.id;

                document.getElementById('pkg_name').value = pkg.name ?? '';
                document.getElementById('pkg_price').value = pkg.price ?? '';
                CKEDITOR.instances.pkg_description.setData(pkg.description ?? '');
                document.getElementById('pkg_image_alt').value = pkg.image_alt ?? '';
                document.getElementById('pkg_status').value = pkg.status ?? 'active';

                if (pkg.image) {
                    preview.src = "/storage/" + pkg.image;
                    preview.classList.remove('hidden');
                } else {
                    preview.classList.add('hidden');
                }
            } else {
                document.getElementById('packageModalTitle').innerText = 'Add Package';
                form.action = "{{ route('package.store') }}";
                form.reset();
                if (CKEDITOR.instances.pkg_description) CKEDITOR.instances.pkg_description.setData('');
                preview.classList.add('hidden');
            }
        }

        function closePackageModal() {
            const modal = document.getElementById('packageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function previewPackageImage(event) {
            const input = event.target;
            const preview = document.getElementById('pkg_image_preview');

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
    </script>
</x-app-layout>
