@extends('layouts.employee-layout')

{{-- @section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-pink-600">📝 Orders</h1>

    <div class="mt-6 overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Order #</th>
                    <th class="px-4 py-2 text-left font-medium">Customer</th>
                    <th class="px-4 py-2 text-left font-medium">Status</th>
                    <th class="px-4 py-2 text-left font-medium">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr>
                    <td class="px-4 py-2">101</td>
                    <td class="px-4 py-2">John Doe</td>
                    <td class="px-4 py-2">
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Pending</span>
                    </td>
                    <td class="px-4 py-2">
                        <button class="px-3 py-1 bg-green-500 text-white text-xs rounded-lg shadow">
                            Mark as Processing
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection --}}

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-pink-600">📝 Employee Orders</h1>

    <div class="mt-6 overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Order #</th>
                    <th class="px-4 py-2 text-left font-medium">User</th>
                    <th class="px-4 py-2 text-left font-medium">Items</th>
                    <th class="px-4 py-2 text-left font-medium">Subtotal</th>
                    <th class="px-4 py-2 text-left font-medium">Status</th>
                    <th class="px-4 py-2 text-left font-medium">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-4 py-2 font-medium text-gray-700">#{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">
                            <ul class="list-disc list-inside text-gray-600">
                                @foreach ($order->items as $item)
                                    <li>{{ $item->product->name ?? $item->name }} (x{{ $item->qty }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-2 text-gray-800 font-semibold">
                            $ {{ number_format($order->subtotal, 2) }}
                        </td>
                        <td class="px-4 py-2">
                            @if ($order->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Pending</span>
                            @elseif ($order->status === 'processing')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Processing</span>
                            @elseif ($order->status === 'completed')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Completed</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
