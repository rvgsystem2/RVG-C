<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Contact Submissions') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

           @include('components.alartTost')

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Phone</th>
                                <th class="px-4 py-3">Subject</th>
                                <th class="px-4 py-3">Message</th>
                                <th class="px-4 py-3">Submitted At</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
                            @forelse($contacts as $contact)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $contact->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $contact->email }}</td>
                                    <td class="px-4 py-2">{{ $contact->phone ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $contact->subject ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($contact->message, 50) }}</td>
                                    <td class="px-4 py-2">{{ $contact->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('contact.delete', $contact->id) }}" method="get" class="inline">
                                            @csrf
                                   
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No contact messages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
