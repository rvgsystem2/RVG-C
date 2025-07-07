<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">All Career Openings</h2>
{{--            <a href="{{ route('applications.create') }}"--}}
{{--               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Add Job</a>--}}
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
                        <th class="px-4 py-2">name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Expires</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $application)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $application->position_name ?? $application->career?->title }}</td>
                            <td class="px-4 py-2 text-center">{{ $application->name }}</td>
                            <td class="px-4 py-2 text-center">{{ $application->email }}</td>
                            <td class="px-4 py-2 text-center">{{ $application->phone }}</td>
                            <td class="px-4 py-2 text-center">{{ ucfirst($application->status) }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('applications.show', $application) }}" class="text-blue-600 hover:underline">Show</a>
                                <form action="{{ route('applications.delete', $application) }}" method="get" class="inline-block" onsubmit="return confirm('Delete this job?')">
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
