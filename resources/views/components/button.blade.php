@props(['type' => 'primary', 'text' => 'Button'])

@php
    $baseClasses = "px-4 py-2 rounded font-semibold text-white shadow";
    $types = [
        'primary' => 'bg-blue-600 hover:bg-blue-700',
        'success' => 'bg-green-600 hover:bg-green-700',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-black',
        'danger'  => 'bg-red-600 hover:bg-red-700',
    ];

    $classes = $baseClasses . ' ' . ($types[$type] ?? $types['primary']);
@endphp

<a href="#" class="btn btn-{{ $type }} btn-sm">{{ $text }}</a>
