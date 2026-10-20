{{-- resources/views/backend/purchases/indexdiscountuser.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800">Discounted Payment Links</h2>
            <a href="{{ route('paylink.create') }}"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">
                + Create Link
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6">

                {{-- Filters --}}
                <form method="GET" action="{{ route('paylink.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-5">
                    <div class="md:col-span-2">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Search by name, phone, business, package…"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
                    </div>
                    <div>
                        <select name="status"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-200">
                            <option value="">All Status</option>
                            <option value="created" {{ request('status') == 'created' ? 'selected' : '' }}>Created
                            </option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-black">Filter</button>
                        <a href="{{ route('paylink.index') }}"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200">Reset</a>
                    </div>
                </form>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Created</th>
                                <th class="px-4 py-3 text-left">Customer</th>
                                <th class="px-4 py-3 text-left">Phone</th>
                                <th class="px-4 py-3 text-left">Package</th>
                                <th class="px-4 py-3 text-right">MRP</th>
                                <th class="px-4 py-3 text-left">Disc</th>
                                <th class="px-4 py-3 text-right">Final</th>
                                <th class="px-4 py-3 text-left">Expires</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $o)
                                @php
                                    // Derive values safely
                                    $mrp = $o->mrp_amount ?? ($o->amount ?? 0);
                                    $final = $o->final_amount ?? ($o->payable_amount ?? 0);
                                    $discTxt =
                                        $o->discount_type === 'percent'
                                            ? ($o->discount_value
                                                ? $o->discount_value . '%'
                                                : '—')
                                            : ($o->discount_type === 'flat'
                                                ? '₹' . number_format((float) $o->discount_value, 2)
                                                : '—');

                                    $status = strtolower($o->status ?? 'created');
                                    $badge =
                                        [
                                            'paid' => 'bg-green-100 text-green-700 border border-green-200',
                                            'expired' => 'bg-gray-100 text-gray-700 border border-gray-200',
                                            'cancelled' => 'bg-red-50 text-red-700 border border-red-200',
                                            'created' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                        ][$status] ?? 'bg-blue-50 text-blue-700 border border-blue-200';

                                    $publicUrl =
                                        $o->public_url ??
                                        ($o->pay_url ?? (isset($o->code) ? url('/pay/' . $o->code) : null));
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 align-top">#{{ $o->id }}</td>
                                    <td class="px-4 py-3 align-top">{{ $o->created_at?->format('d M Y, h:i A') }}</td>
                                    <td class="px-4 py-3 align-top">
                                        <div class="font-medium text-gray-900">
                                            {{ $o->customer_name ?? ($o->name ?? '—') }}</div>
                                        @if (!empty($o->business_name))
                                            <div class="text-xs text-gray-500">{{ $o->business_name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="font-mono">{{ $o->customer_phone ?? ($o->phone ?? '—') }}</span>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-gray-900">
                                            {{ $o->package->name ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">₹{{ number_format((float) $mrp, 2) }}
                                    </td>
                                    <td class="px-4 py-3 align-top">{{ $discTxt }}</td>
                                    <td class="px-4 py-3 align-top text-right font-semibold">
                                        ₹{{ number_format((float) $o->amount_payable, 2) }}</td>
                                    <td class="px-4 py-3 align-top">
                                        {{ $o->expires_at ? \Carbon\Carbon::parse($o->expires_at)->format('d M Y, h:i A') : '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-center">
                                        <span class="px-2.5 py-1 rounded-full text-xs {{ $badge }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>


                                    <td class="px-4 py-3 align-top">
                                        @php $publicUrl = $o->link_token ? url('/pay/'.$o->link_token) : null; @endphp
                                        <div class="flex items-center justify-center gap-2">
                                            @if ($publicUrl)
                                                <a href="{{ $publicUrl }}" target="_blank"
                                                    class="px-3 py-1.5 rounded border bg-white hover:bg-gray-50 text-sm">Open</a>
                                                <button type="button"
                                                    class="px-3 py-1.5 rounded border bg-white hover:bg-gray-50 text-sm copy-btn"
                                                    data-copy="{{ $publicUrl }}">Copy</button>
                                            @else
                                                <span class="text-xs text-gray-400">No URL</span>
                                            @endif

                                            <a href="{{ route('paylink.edit', $o) }}"
                                                class="px-3 py-1.5 rounded border bg-white hover:bg-gray-50 text-sm">edit</a>

                                            <form action="{{ route('paylink.destroy', $o) }}" method="get"
                                                class="inline" onsubmit="return confirm('Delete this link?')">
                                                {{-- @csrf @method('DELETE') ✅ FIX --}}
                                                <button
                                                    class="px-3 py-1.5 rounded border bg-white hover:bg-gray-50 text-sm">delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-4 py-6 text-center text-gray-500">No payment links
                                        found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-5">
                    {{ $orders->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const u = btn.dataset.copy;
                if (!u) return;
                navigator.clipboard.writeText(u).then(() => {
                    btn.textContent = 'Copied';
                    setTimeout(() => btn.textContent = 'Copy', 1200);
                });
            });
        });
    </script>
</x-app-layout>
