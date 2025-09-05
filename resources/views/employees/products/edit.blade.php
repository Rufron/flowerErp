@extends('layouts.employee-layout')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Product: {{ $product->name }}</h1>

    <form action="{{ route('employees.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Current Image</label>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="h-16 w-16 rounded-lg object-cover mt-1">
                @else
                    <p class="text-gray-400">No image</p>
                @endif
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Replace Image</label>
            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-600">
        </div>

        <div class="pt-4 flex space-x-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                Update Product
            </button>
            <a href="{{ route('employees.products.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
