<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-bold text-2xl text-gray-800">Customer Purchases</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <div class="bg-green-50 text-green-700 rounded-lg px-3 py-2 text-sm">Paid: <b>{{ $stats['paid'] }}</b></div>
                <div class="bg-yellow-50 text-yellow-700 rounded-lg px-3 py-2 text-sm">Created: <b>{{ $stats['created'] }}</b></div>
                <div class="bg-red-50 text-red-700 rounded-lg px-3 py-2 text-sm">Failed: <b>{{ $stats['failed'] }}</b></div>
                <div class="bg-blue-50 text-blue-700 rounded-lg px-3 py-2 text-sm">Revenue: <b>₹ {{ number_format($stats['revenue'],2) }}</b></div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
                {{-- Filters --}}
                <form method="GET" class="grid md:grid-cols-5 gap-3 mb-5">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Search name/phone/order/payment"
                           class="md:col-span-2 w-full px-3 py-2 border border-gray-300 rounded">
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded">
                        <option value="">All Status</option>
                        <option value="paid" {{ $status==='paid'?'selected':'' }}>Paid</option>
                        <option value="created" {{ $status==='created'?'selected':'' }}>Created</option>
                        <option value="failed" {{ $status==='failed'?'selected':'' }}>Failed</option>
                    </select>
                    <input type="date" name="from" value="{{ $from }}" class="w-full px-3 py-2 border border-gray-300 rounded">
                    <input type="date" name="to"   value="{{ $to   }}" class="w-full px-3 py-2 border border-gray-300 rounded">
                    <div class="md:col-span-5 flex gap-2">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded">Filter</button>
                        <a href="{{ route('purchases.index') }}" class="px-4 py-2 bg-gray-100 rounded">Reset</a>
                    </div>
                </form>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs">
                            @php
                              $toggleDir = $dir==='asc'?'desc':'asc';
                              $sortLink = fn($col) => request()->fullUrlWithQuery(['sort'=>$col,'dir'=>$toggleDir]);
                            @endphp
                            <tr>
                                <th class="px-4 py-3"><a href="{{ $sortLink('created_at') }}">Date</a></th>
                                <th class="px-4 py-3">Package</th>
                                <th class="px-4 py-3">Customer</th>
                                <th class="px-4 py-3">Phone</th>
                                <th class="px-4 py-3"><a href="{{ $sortLink('amount') }}">Amount</a></th>
                                <th class="px-4 py-3"><a href="{{ $sortLink('status') }}">Status</a></th>
                                <th class="px-4 py-3">Order ID</th>
                                <th class="px-4 py-3">Payment ID</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $o)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $o->created_at->format('d M Y, h:i A') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold">{{ $o->package->name ?? '—' }}</div>
                                        <div class="text-xs text-gray-500">Pkg ID: {{ $o->package_id }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $o->name ?? '—' }}</div>
                                        <div class="text-xs text-gray-500">{{ $o->business_name ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ $o->phone }}</td>
                                    <td class="px-4 py-3 font-semibold">₹ {{ number_format($o->amount,2) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs
                                          {{ $o->status==='paid' ? 'bg-green-100 text-green-700' :
                                             ($o->status==='failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                          {{ ucfirst($o->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs">{{ $o->razorpay_order_id }}</td>
                                    <td class="px-4 py-3 text-xs">{{ $o->razorpay_payment_id ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('purchases.show', $o->id) }}"
                                           class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="px-4 py-6 text-center text-gray-500">No purchases found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
