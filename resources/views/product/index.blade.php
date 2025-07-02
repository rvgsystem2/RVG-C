<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Product Management') }}
            </h2>
            <button onclick="openProductModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Product
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Products</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Number</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $product->name }}</td>
                                    <td class="px-4 py-3">{{ $product->number }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ asset('storage/' . $product->image ) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md">
                                    </td>
                                    <td class="px-4 py-3 capitalize">{{ $product->status }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openProductModal(@json($product))'
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('product.delete', $product->id) }}" method="get"
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
                                    <td colspan="4" class="text-center py-6 text-gray-400">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closeProductModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="productModalTitle">Add Product</h3>

            <form id="productForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" id="product_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="product_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                        <input type="text" name="number" id="product_number"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="product_image"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="product_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                        <input type="text" name="url" id="product_url"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="product_description"
                                  class="w-full px-3 py-2 border border-gray-300 rounded" rows="3"></textarea>
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeProductModal()"
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
        function openProductModal(product = null) {
            const modal = document.getElementById('productModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('productForm');

            if (product) {
                document.getElementById('productModalTitle').innerText = 'Edit Product';
                form.action = `/product/update/${product.id}`;

                document.getElementById('product_id').value = product.id ?? '';
                document.getElementById('product_name').value = product.name ?? '';
                document.getElementById('product_number').value = product.number ?? '';
                document.getElementById('product_url').value = product.url ?? '';
                document.getElementById('product_status').value = product.status ?? 'active';
                document.getElementById('product_description').value = product.description ?? '';
            } else {
                document.getElementById('productModalTitle').innerText = 'Add Product';
                form.action = `{{ route('product.store') }}`;
                form.reset();
            }
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
