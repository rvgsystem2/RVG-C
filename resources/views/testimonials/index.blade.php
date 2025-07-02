<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Testimonial Management') }}
            </h2>
            <button onclick="openTestimonialModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Testimonial
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Testimonials</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Designation</th>
                                <th class="px-4 py-3">Company</th>
                                <th class="px-4 py-3">Message</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($testimonials as $testimonial)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" class="w-12 h-12 rounded-full" alt="{{ $testimonial->name }}">
                                    </td>
                                    <td class="px-4 py-3">{{ $testimonial->name }}</td>
                                    <td class="px-4 py-3">{{ $testimonial->designation }}</td>
                                    <td class="px-4 py-3">{{ $testimonial->company }}</td>
                                    <td class="px-4 py-3">{{ Str::limit($testimonial->message, 50) }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $testimonial->status }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openTestimonialModal(@json($testimonial))'
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('testimonials.delete', $testimonial->id) }}" method="get"
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
                                    <td colspan="7" class="text-center py-6 text-gray-400">No testimonials found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Modal -->
    <div id="testimonialModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closeTestimonialModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="testimonialModalTitle">Add Testimonial</h3>

            <form id="testimonialForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="testimonial_id" id="testimonial_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="testimonial_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                        <input type="text" name="designation" id="testimonial_designation"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                        <input type="text" name="company" id="testimonial_company"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="testimonial_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" id="testimonial_message" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeTestimonialModal()"
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
        function openTestimonialModal(data = null) {
            const modal = document.getElementById('testimonialModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('testimonialForm');

            if (data) {
                document.getElementById('testimonialModalTitle').innerText = 'Edit Testimonial';
                form.action = `/testimonials/update/${data.id}`;
                document.getElementById('testimonial_id').value = data.id;
                document.getElementById('testimonial_name').value = data.name ?? '';
                document.getElementById('testimonial_designation').value = data.designation ?? '';
                document.getElementById('testimonial_company').value = data.company ?? '';
                document.getElementById('testimonial_message').value = data.message ?? '';
                document.getElementById('testimonial_status').value = data.status ?? 'active';
            } else {
                document.getElementById('testimonialModalTitle').innerText = 'Add Testimonial';
                form.action = `{{ route('testimonials.store') }}`;
                form.reset();
            }
        }

        function closeTestimonialModal() {
            const modal = document.getElementById('testimonialModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
