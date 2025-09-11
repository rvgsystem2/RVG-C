<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white shadow-md px-6 py-4 rounded-lg">
            <h2 class="font-bold text-2xl text-gray-800">Interested Leads</h2>

            {{-- (optional) add export route if you have one --}}
            {{-- <a href="{{ route('admin.leads.export') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">Export CSV</a> --}}
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash success --}}
            @if (session('success'))
                <div class="flex items-center gap-2 bg-green-100 text-green-700 px-4 py-3 rounded-lg shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white shadow-xl rounded-2xl border border-gray-200">
                <div class="px-6 pt-6 pb-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">All Leads</h3>
                        <p class="text-sm text-gray-500">Total: {{ $leads->total() }}</p>
                    </div>

                    {{-- (optional) simple search by query string ?q=... if controller supports it --}}
                    {{-- <form method="GET" action="{{ route('admin.leads.index') }}" class="flex items-center gap-2">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search phone or package"
                               class="px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Search</button>
                        @if(request('q'))
                          <a href="{{ route('admin.leads.index') }}" class="px-3 py-2 rounded-lg border">Clear</a>
                        @endif
                    </form> --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-t border-gray-200">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Package</th>
                                <th class="px-6 py-3">Phone</th>
                                <th class="px-6 py-3">Source</th>
                                <th class="px-6 py-3">Created (IST)</th>
                                <th class="px-6 py-3 text-center">Quick Actions</th>
                                <th class="px-6 py-3 text-center">Manage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($leads as $lead)
                                @php
                                    $pkg   = $lead->package;
                                    $pname = $pkg->name ?? '—';
                                    // normalize phone to digits; prepend 91 if 10 digits
                                    $digits = preg_replace('/\D+/', '', (string) $lead->phone);
                                    $wa = (strlen($digits) === 10) ? '91'.$digits : $digits;
                                    $tel = '+'.$wa;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-800">#{{ $lead->id }}</td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-2">
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $pname }}</div>
                                                @if($pkg)
                                                    <div class="text-xs text-gray-500">ID: {{ $pkg->id }}</div>
                                                @else
                                                    <div class="text-xs text-red-500">Package removed</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="tel:{{ $tel }}" class="text-gray-800 font-medium hover:underline">
                                                {{ $lead->phone }}
                                            </a>
                                            <button type="button"
                                                    class="text-xs px-2 py-1 rounded bg-gray-100 hover:bg-gray-200"
                                                    onclick="copyToClipboard('{{ $lead->phone }}')">
                                                Copy
                                            </button>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                            {{ $lead->source ?? 'package-details' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-gray-700">
                                        {{ optional($lead->created_at)->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="tel:{{ $tel }}"
                                               class="px-3 py-1.5 rounded-lg bg-slate-800 text-white text-xs hover:bg-slate-700">
                                                Call
                                            </a>
                                            @if($wa)
                                                <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi! We received your interest. How can we help you?') }}"
                                                   target="_blank"
                                                   class="px-3 py-1.5 rounded-lg bg-green-600 text-white text-xs hover:bg-green-700">
                                                    WhatsApp
                                                </a>
                                            @endif
                                            @if($pkg)
                                                <a href="{{ route('packages.details', $pkg->id) }}"
                                                   class="px-3 py-1.5 rounded-lg border text-xs hover:bg-gray-50">
                                                    View Package
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Delete --}}
                                            <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="get"
                                                  onsubmit="return confirm('Delete this lead?')">
                                                {{-- @csrf @method('DELETE') --}}
                                                <button type="submit"
                                                        class="px-3 py-1.5 rounded-lg bg-red-500 text-white text-xs hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        No leads found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4">
                    {{ $leads->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Toast for copy --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function copyToClipboard(text){
        if(navigator.clipboard && window.isSecureContext){
          navigator.clipboard.writeText(text).then(()=>{
            Swal.fire({toast:true, position:'top-end', icon:'success', title:'Copied', showConfirmButton:false, timer:1200});
          });
        } else {
          const ta = document.createElement('textarea');
          ta.value = text; document.body.appendChild(ta);
          ta.select(); document.execCommand('copy'); ta.remove();
          Swal.fire({toast:true, position:'top-end', icon:'success', title:'Copied', showConfirmButton:false, timer:1200});
        }
      }
    </script>
</x-app-layout>
