<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($page_meta['title']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session()->has('flash'))
                <x-flash-message
                    variant="{{ session('flash')['type'] }}">{{ session('flash')['message'] }}</x-flash-message>
            @endif

            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <form class="space-y-6" wire:submit.prevent="{{ $page_meta['form']['action'] }}">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input class="mt-1 block w-full" id="name" name="name" type="text"
                            wire:model="form.name" autocomplete="off" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.name')" />
                    </div>

                    <div>
                        <x-input-label for="icon" :value="__('Upload Icon')" />
                        <x-file-input id="icon" name="icon" wire:model="form.icon" autocomplete="off" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.icon')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
