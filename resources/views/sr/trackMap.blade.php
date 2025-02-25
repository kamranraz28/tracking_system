<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenStreetMap with Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h3>SR Tracking Map with Connected Locations</h3>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Convert PHP data to JavaScript array
        var locations = @json($locations);

        // Transform the locations into an array of [lat, lon]
        var latLonArray = locations.map(function(location) {
            return [location.lat, location.lon];
        });

        // Initialize the map and set its view to the first location if available
        var initialLatLon = latLonArray.length ? latLonArray[0] : [37.7749, -122.4194]; // Default to SF if empty
        var map = L.map('map').setView(initialLatLon, 5);

        // Add the OSM tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Mark the starting point
        if (latLonArray.length > 0) {
            L.marker(latLonArray[0], { title: 'Starting Point' })
                .bindPopup('Starting Point')
                .addTo(map)
                .openPopup();
        }

        // Mark the ending point
        if (latLonArray.length > 1) {
            L.marker(latLonArray[latLonArray.length - 1], { title: 'Ending Point' })
                .bindPopup('Ending Point')
                .addTo(map);
        }

        // Create a polyline to connect the locations
        if (latLonArray.length > 1) {
            var polyline = L.polyline(latLonArray, {
                color: 'green',
                weight: 3
            }).addTo(map);

            // Adjust the map view to fit the polyline
            map.fitBounds(polyline.getBounds());
        }

        // Create markers for intermediate points (optional)
        for (var i = 1; i < latLonArray.length - 1; i++) {
            L.marker(latLonArray[i], { title: 'Intermediate Point' }).addTo(map);
        }
    </script>
</body>
</html>
