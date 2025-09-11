<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">Package Categories</h2>

            <a href="{{ route('package-categories.create') }}"
               class="px-5 py-2 bg-gradient-to-r from-[#c21108] to-[#000308] text-white font-semibold rounded-lg shadow-md hover:from-[#000308] hover:to-[#c21108] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c21108] transition">
                + Add Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success flash --}}
            @if (session('success'))
                <div class="flex items-center bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-md">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Filters --}}
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 mb-4">
                <form method="GET" action="{{ route('package-categories.index') }}" class="grid sm:grid-cols-3 gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Search</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                               placeholder="Search by name...">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Status</label>
                        <select name="status"
                                class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                            <option value="">All</option>
                            <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">Filter</button>
                        @if(request()->hasAny(['q','status']))
                            <a href="{{ route('category.index') }}"
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg border hover:bg-gray-200">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">All Categories</h3>
                    <span class="text-sm text-gray-500">Total: {{ $categories->total() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-blue-50 to-blue-100 text-gray-700 uppercase font-semibold text-xs">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Created</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $category->id }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $category->name }}</td>
                                    <td class="px-6 py-4">
                                        @if($category->status === 'active')
                                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Active</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $category->created_at?->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            
                                           <a href="{{ route('packages.byCategory', $category->id) }}"
   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold shadow">
   📦 View Packages
</a>

{{-- Copy link --}}
<a href="javascript:void(0);"
   onclick="copyToClipboard('{{ route('packages.byCategory', $category->id) }}')"
   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-semibold shadow">
   📋 Copy Link
</a>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Link copied to clipboard!');
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>


                                            <a href="{{ route('package-categories.edit', $category->id) }}"
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold shadow">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('package-categories.delete', $category->id) }}" method="get"
                                                  onsubmit="return confirm('Delete this category?')">
                                                {{-- @csrf @method('DELETE') --}}
                                                <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold shadow">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-400 text-base">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
