@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800">➕ Add New Product</h1>

    <!-- Route points to products.store -->
    <form action="{{ route('employees.products.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" name="name" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm" placeholder="Enter product name" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm" rows="3" placeholder="Enter description"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" name="stock" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm" placeholder="0">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Upload Image</label>
            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-600">
        </div>

        <div class="pt-4">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection
