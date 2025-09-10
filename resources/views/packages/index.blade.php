<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('Package Management') }}
            </h2>
             <a href="{{ route('package_media.index') }}"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Package Media
            </a>
 <a href="{{ route('package_faqs.index') }}"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Package Faq
            </a>
            <a href="{{ route('package.create') }}"
                class="px-5 py-2 bg-gradient-to-r from-green-600 to-blue-900 text-white font-semibold rounded-lg shadow-md transition">
                + Add Package
            </a>
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
                                            <a href="{{ route('package.edit', $package->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <a href="{{ route('packageshow', $package->id) }}"
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                📋 View
                                            </a>

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

   
</x-app-layout>
