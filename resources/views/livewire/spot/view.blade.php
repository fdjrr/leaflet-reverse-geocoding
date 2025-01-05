<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($page_meta['title']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            @if (session()->has('flash'))
                <x-flash-message
                    variant="{{ session('flash')['type'] }}">{{ session('flash')['message'] }}</x-flash-message>
            @endif
            <div wire:ignore>
                <div id="map" style="width: 100%; height: 500px;z-index:0"></div>
            </div>
        </div>
    </div>

    <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
        id="createSpotModal" aria-hidden="true" tabindex="-1" wire:ignore.self>
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600 md:p-5">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Spot
                    </h3>
                    <button
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg ms-auto hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        id="closeSpotModal" type="button">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form wire:submit.prevent="{{ $page_meta['form']['action'] }}">
                    <div class="p-4 space-y-4 md:p-5">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input class="block w-full mt-1" id="name" name="name" type="text"
                                wire:model="form.name" autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('form.name')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="lat" :value="__('Latitude')" />
                                <x-text-input class="block w-full mt-1" id="lat" type="text" lat="lat"
                                    wire:model="form.lat" autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('form.lat')" />
                            </div>

                            <div>
                                <x-input-label for="long" :value="__('Longitude')" />
                                <x-text-input class="block w-full mt-1" id="long" type="text" long="long"
                                    wire:model="form.long" autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('form.long')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <x-select class="block w-full mt-1" id="category_id" name="category_id"
                                wire:model="form.category_id">
                                <option value="">Choose Category</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @empty
                                @endforelse
                            </x-select>
                            <x-input-error class="mt-2" :messages="$errors->get('form.category_id')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea class="block w-full mt-1" id="description" name="description" type="text"
                                wire:model="form.description" autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('form.description')" />
                        </div>
                    </div>
                    <div class="flex items-center p-4 border-t border-gray-200 rounded-b dark:border-gray-600 md:p-5">
                        <x-primary-button>Create</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        const $targetEl = document.getElementById('createSpotModal');

        const modal = new Modal($targetEl);

        let currentMarker;

        const map = L.map('map').setView([51.505, -0.09], 13);
        const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer)

        map.on('click', onMapClick)

        const {
            data
        } = await axios.get('/api/v1/spots');

        if (data.success) {
            const spots = data.data

            spots.map((spot) => {
                const marker = L.marker([spot.lat, spot.long], {
                        title: spot.name,
                    })
                    .bindPopup(spot.name)
                    .openPopup()
                    .addTo(map);
                marker.feature = {
                    properties: {
                        title: spot.name
                    }
                };
                markersLayer.addLayer(marker);
                map.setView([spot.lat, spot.long], 16);
            })
        }

        var controlSearch = new L.Control.Search({
            position: 'topleft',
            layer: markersLayer,
            initial: false,
            zoom: 18,
            propertyName: 'title',
        });
        map.addControl(controlSearch);

        async function onMapClick(e) {
            const latlng = e.latlng;

            if (!currentMarker) {
                currentMarker = L.marker(latlng, {
                    draggable: true
                }).addTo(map);

                currentMarker.on('dragend', onMarkerDragend);
            } else {
                currentMarker.setLatLng(latlng);
            }

            fetchDataLocation(latlng.lat, latlng.lng);
        }

        async function onMarkerDragend(e) {
            const latlng = e.target.getLatLng();

            fetchDataLocation(latlng.lat, latlng.lng);
        }

        async function fetchDataLocation(lat, long) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${long}`;

            const {
                data
            } = await axios.get(url);

            const name = data.name
            if (name) {
                $wire.set('form.name', name)
            }

            const locationLat = data.lat
            if (locationLat) {
                $wire.set('form.lat', locationLat)
            }

            const locationLong = data.lon
            if (locationLong) {
                $wire.set('form.long', locationLong)
            }

            const description = data.display_name
            if (description) {
                $wire.set('form.description', description)
            }
            modal.show()
        }

        const closeSpotModal = document.getElementById('closeSpotModal');
        if (closeSpotModal) {
            closeSpotModal.addEventListener('click', () => {
                modal.hide()
            })
        }

        $wire.on('closeCreateSpotModal', () => {
            modal.hide()
        })
    </script>
@endscript
