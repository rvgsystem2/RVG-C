<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ __('SEO Management') }}
            </h2>
            <a href="{{ route('seo.create') }}"
                class="px-5 py-2 bg-gradient-to-r from-green-700 to-blue-800 text-white font-semibold rounded-lg shadow-md hover:from-blue-800 hover:to-green-700 transition">
                + Add SEO
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4 shadow">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">SEO Entries</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Page Type</th>
                                <th class="px-6 py-4">Blogs/Service</th>
                                <th class="px-6 py-4">Packages</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($seos as $seo)
                                <tr>
                                    <td class="px-6 py-3 text-gray-800">{{ $seo->id }}</td>
                                    <td class="px-6 py-3">{{ $seo->meta_title ?? '-' }}</td>
                                    {{-- <td class="px-6 py-3">{{ $seo->slug ?? '-' }}</td> --}}
                                    <td class="px-6 py-3 capitalize">{{ $seo->page_type ?? '-' }}</td>

                                    </td>
                                    <td class="px-6 py-3">
    @if ($seo->blog)
        Blog: {{ $seo->blog->title }}
    @elseif ($seo->serviceDetail)
        Service: {{ $seo->serviceDetail->title }}
        @if($seo->serviceDetail->category)
            <div class="text-xs text-gray-500">
                (Category: {{ $seo->serviceDetail->category->name }})
            </div>
        @endif
    @elseif ($seo->package)
        Package: {{ $seo->package->name }}
    @else
        -
    @endif
</td>


                                    <td class="px-6 py-3">
                                        {{ $seo->blog ? 'Blog: ' . $seo->blog->title : ($seo->serviceDetail ? 'Service: ' . $seo->serviceDetail->sort_description : ($seo->package ? 'Package: ' . $seo->package->name : '-')) }}
                                    </td>


                                    <td class="px-6 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('seo.edit', $seo->id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('seo.delete', $seo->id) }}" method="get"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                {{-- @method('DELETE') --}}
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-gray-400">
                                        No SEO entries found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $seos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
