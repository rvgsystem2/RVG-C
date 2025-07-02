<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Team Management') }}
            </h2>
            <button onclick="openTeamModal()"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Team Member
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alartTost')

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Team Members</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Designation</th>
                                <th class="px-4 py-3">Company</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($teams as $member)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $member->name }}</td>
                                    <td class="px-4 py-3">{{ $member->designation }}</td>
                                    <td class="px-4 py-3">{{ $member->company }}</td>
                                    <td class="px-4 py-3">
                                        @if ($member->image)
                                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}"
                                                 class="w-16 h-16 object-cover rounded-full">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 capitalize">{{ $member->status }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="javascript:void(0)" onclick='openTeamModal(@json($member))'
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('team.delete', $member->id) }}" method="get"
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
                                    <td colspan="5" class="text-center py-6 text-gray-400">No team members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="teamModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 overflow-auto">
        <div onclick="closeTeamModal()" class="absolute inset-0 z-40"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl z-50 overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-semibold mb-4" id="teamModalTitle">Add Team Member</h3>

            <form id="teamForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="team_id" id="team_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="team_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                        <input type="text" name="designation" id="team_designation"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                        <input type="text" name="company" id="team_company"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="team_image"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" id="team_message"
                                  class="w-full px-3 py-2 border border-gray-300 rounded" rows="3"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="team_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <input type="text" name="facebook" id="team_facebook"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                        <input type="text" name="linkedin" id="team_linkedin"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <input type="text" name="instagram" id="team_instagram"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">GitHub</label>
                        <input type="text" name="github" id="team_github"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" id="team_whatsapp"
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeTeamModal()"
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
        function openTeamModal(team = null) {
            const modal = document.getElementById('teamModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const form = document.getElementById('teamForm');

            if (team) {
                document.getElementById('teamModalTitle').innerText = 'Edit Team Member';
                form.action = `/team/update/${team.id}`;

                document.getElementById('team_id').value = team.id ?? '';
                document.getElementById('team_name').value = team.name ?? '';
                document.getElementById('team_designation').value = team.designation ?? '';
                document.getElementById('team_company').value = team.company ?? '';
                document.getElementById('team_status').value = team.status ?? 'active';
                document.getElementById('team_message').value = team.message ?? '';
                document.getElementById('team_facebook').value = team.facebook ?? '';
                document.getElementById('team_linkedin').value = team.linkedin ?? '';
                document.getElementById('team_instagram').value = team.instagram ?? '';
                document.getElementById('team_github').value = team.github ?? '';
                document.getElementById('team_whatsapp').value = team.whatsapp ?? '';
            } else {
                document.getElementById('teamModalTitle').innerText = 'Add Team Member';
                form.action = `{{ route('team.store') }}`;
                form.reset();
            }
        }

        function closeTeamModal() {
            const modal = document.getElementById('teamModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
