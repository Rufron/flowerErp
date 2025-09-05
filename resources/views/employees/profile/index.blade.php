@extends('layouts.employee-layout')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-pink-600">👤 Profile Settings</h1>

    <form class="mt-6 max-w-md space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" value="Employee Name" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" value="employee@example.com" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>
        <button class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow">Update</button>
    </form>
</div>
@endsection
