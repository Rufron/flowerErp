@extends('layouts.employee-layout')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-pink-600">📦 Product Inventory</h1>
        <a href="{{ route('employees.products.create') }}"
            class="mt-4 inline-block bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600">
            ➕ Add New Product
        </a>

        <div class="mt-6 overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium">#</th>
                        <th class="px-4 py-2 text-left font-medium">Name</th>
                        <th class="px-4 py-2 text-left font-medium">Stock</th>
                        <th class="px-4 py-2 text-left font-medium">Image</th>
                        <th class="px-4 py-2 text-left font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $i => $product)
                        <tr>
                            <td class="px-4 py-2">{{ $products->firstItem() + $i }}</td>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">{{ $product->stock }}</td>
                            <td class="px-4 py-2">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="h-12 w-12 object-cover rounded-lg" alt="{{ $product->name }}">
                                @else
                                    <span class="text-gray-400">No image</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('employees.products.edit', $product->id) }}"
                                    class="text-blue-600">Edit</a>
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('employees.products.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination links -->
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
