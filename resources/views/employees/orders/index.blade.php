@extends('layouts.employee-layout')

@section('content')
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
@endsection
