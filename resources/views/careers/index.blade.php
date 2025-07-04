<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">All Career Openings</h2>
            <a href="{{ route('careers.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Add Job</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="overflow-x-auto bg-white p-6 rounded shadow">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Location</th>
                            <th class="px-4 py-2">Expires</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($careers as $career)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $career->title }}</td>
                            <td class="px-4 py-2 text-center">{{ $career->type }}</td>
                            <td class="px-4 py-2 text-center">{{ $career->location }}</td>
                            <td class="px-4 py-2 text-center">{{ $career->valid_through ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">{{ ucfirst($career->status) }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('careers.edit', $career) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('careers.delete', $career) }}" method="get" class="inline-block" onsubmit="return confirm('Delete this job?')">
                                    
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
