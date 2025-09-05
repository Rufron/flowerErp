@extends('layouts.admin') {{-- use your admin layout --}}

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">👨‍💼 Employee Inventory</h1>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-pink-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Created At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($employees as $employee)
                        <tr>
                            <td class="px-6 py-4">{{ $employee->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $employee->name }}</td>
                            <td class="px-6 py-4">{{ $employee->email }}</td>
                            <td class="px-6 py-4">{{ ucfirst($employee->role) }}</td>
                            <td class="px-6 py-4">{{ $employee->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No employees found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $employees->links() }}
        </div>
    </div>
@endsection
