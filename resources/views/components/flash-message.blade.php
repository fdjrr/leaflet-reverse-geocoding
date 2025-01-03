@props([
    'variant' => 'primary',
])

@php
    $classes = [
        'primary' => 'bg-blue-50 dark:bg-gray-800 dark:text-blue-400',
        'danger' => 'bg-red-50 dark:bg-gray-800 dark:text-red-400',
        'success' => 'bg-green-50 dark:bg-gray-800 dark:text-green-400',
        'warning' => 'bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300',
        'dark' => 'bg-gray-50 dark:bg-gray-800 dark:text-gray-300',
    ];
@endphp

<div role="alert" {{ $attributes->merge(['class' => 'mb-4 rounded-lg p-4 text-sm ' . $classes[$variant]]) }}>
    {{ $slot }}
</div>
