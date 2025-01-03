@props([
    'variant' => '',
])

@php
    $variants = [
        '' => 'text-blue-600 dark:text-blue-500',
        'danger' => 'text-red-600 hover:text-red-900',
    ];

    $variant = $variants[$variant] ?? '';
@endphp

<a {{ $attributes->merge(['class' => 'font-medium hover:underline cursor-pointer ' . $variant]) }}
    wire:navigate>{{ $slot }}</a>
