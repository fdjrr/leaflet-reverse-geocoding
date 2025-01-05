<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($page_meta['title']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <x-button-link :href="route('spot.create')">{{ __('Create') }}</x-button-link>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rtl:text-right">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3" scope="col">
                                Spot Name
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Latitude
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Longitude
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Category
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($spots as $spot)
                            <tr
                                class="border-b odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-gray-900 even:dark:bg-gray-800">
                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row">
                                    {{ $spot->name }}
                                </th>
                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row">
                                    {{ $spot->lat }}
                                </th>
                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row">
                                    {{ $spot->long }}
                                </th>
                                <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row">
                                    {{ $spot->category?->name }}
                                </th>
                                <td class="flex items-center px-6 py-4">
                                    <x-link class="ms-3" href="{{ route('spot.edit', $spot->slug) }}">Edit</x-link>
                                    <x-link class="ms-3" wire:click.prevent="delete({{ $spot->id }})"
                                        variant="danger">Remove</x-link>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
