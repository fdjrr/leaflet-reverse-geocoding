<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-3 max-w-7xl sm:px-6 lg:px-8">
            <livewire:spot.map />
        </div>
    </div>
</x-app-layout>
