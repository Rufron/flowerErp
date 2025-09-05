@extends('layouts.employee-layout')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-pink-600">⚠️ Low Stock Alerts</h1>
    <p class="mt-2 text-gray-600">These items need restocking.</p>

    <ul class="mt-6 space-y-3">
        <li class="p-4 bg-red-50 border-l-4 border-red-500 rounded">
            🌸 Tulips — Only <span class="font-bold">3</span> left
            <button class="ml-4 text-sm text-blue-600 underline">Request Restock</button>
        </li>
    </ul>
</div>
@endsection
