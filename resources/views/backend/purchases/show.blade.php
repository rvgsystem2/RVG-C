<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800">Purchase Details</h2>
            <a href="{{ route('purchases.index') }}" class="px-4 py-2 bg-gray-100 rounded">← Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Package</h3>
                        <div class="text-gray-700">{{ $po->package->name ?? '—' }}</div>
                        <div class="text-sm text-gray-500">ID: {{ $po->package_id }}</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Amount</h3>
                        <div class="text-gray-700">₹ {{ number_format($po->amount,2) }} {{ $po->currency }}</div>
                        <div class="text-sm text-gray-500">Status:
                            <span class="px-2 py-1 rounded text-xs
                              {{ $po->status==='paid' ? 'bg-green-100 text-green-700' :
                                 ($po->status==='failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                              {{ ucfirst($po->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Customer</h3>
                        <div class="text-gray-700">{{ $po->name ?? '—' }}</div>
                        <div class="text-gray-700">{{ $po->business_name ?? '—' }}</div>
                        <div class="text-gray-700">{{ $po->phone }}</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Gateway</h3>
                        <div class="text-sm text-gray-700">Order ID: {{ $po->razorpay_order_id }}</div>
                        <div class="text-sm text-gray-700">Payment ID: {{ $po->razorpay_payment_id ?? '—' }}</div>
                        <div class="text-sm text-gray-700">Signature: {{ $po->razorpay_signature ?? '—' }}</div>
                    </div>
                </div>

                <div class="text-sm text-gray-500">
                    Created: {{ $po->created_at->format('d M Y, h:i A') }} |
                    Updated: {{ $po->updated_at->format('d M Y, h:i A') }}
                </div>

                <div>
                    <a href="{{ route('purchases.index') }}" class="px-4 py-2 bg-gray-900 text-white rounded">Back to list</a>
                    <a href="{{ url('/packages') }}" class="ml-2 px-4 py-2 bg-gray-100 rounded">Go to Packages</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
