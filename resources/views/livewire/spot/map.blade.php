<div>
    <div wire:ignore>
        <div id="map" style="width: 100%; height: 500px"></div>
    </div>
</div>

@script
    <script>
        const map = L.map('map').setView([51.505, -0.09], 13);
        const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer)

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
    </script>
@endscript
