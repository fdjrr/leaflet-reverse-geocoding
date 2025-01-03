<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($page_meta['title']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div wire:ignore>
                <div id="map" style="width: 100%; height: 500px;z-index:0"></div>
            </div>
        </div>
    </div>

    <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
        id="create-spot-modal" aria-hidden="true" tabindex="-1">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600 md:p-5">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Spot
                    </h3>
                    <button
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg ms-auto hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        type="button">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form wire:submit.prevent="createSpot">
                    <div class="p-4 space-y-4 md:p-5">
                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                            With less than a month to go before the European Union enacts new consumer privacy
                            laws for
                            its
                            citizens, companies around the world are updating their terms of service agreements
                            to
                            comply.
                        </p>
                    </div>
                    <div class="flex items-center p-4 border-t border-gray-200 rounded-b dark:border-gray-600 md:p-5">
                        <button
                            class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@script
    <script>
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

            const $targetEl = document.getElementById('create-spot-modal');

            const modal = new Modal($targetEl);
            modal.show()
        }
    </script>
@endscript
