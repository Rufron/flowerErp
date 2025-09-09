@extends('layouts.employee-layout')

@section('content')
    <div class="p-6">
        @php
            $employee = Auth::guard('employees')->user();
        @endphp
        @if ($employee)
        <h1 class="text-2xl font-bold text-pink-600">👋 Hello {{ $employee->name }}</h1>
        @endif


        <p class="mt-2 text-gray-600">Here’s a quick overview of your tasks.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="p-4 bg-white rounded-xl shadow">
                <h2 class="text-lg font-semibold">🌸 Total Products</h2>
                <p class="mt-2 text-2xl font-bold text-gray-700">{{ $totalProducts }}</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow">
                <h2 class="text-lg font-semibold">⚠️ Low Stock</h2>
                <p class="mt-2 text-2xl font-bold text-red-600">8</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow">
                <h2 class="text-lg font-semibold">📦 Pending Orders</h2>
                <p class="mt-2 text-2xl font-bold text-yellow-600">5</p>
            </div>
        </div>
    </div>
@endsection
