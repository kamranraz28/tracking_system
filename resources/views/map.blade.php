<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h3>Location Map</h3>
    <h2>Retail: {{ $name }} ({{ $id }})</h2>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Get lat, lon, name, and id from the PHP variables passed to JavaScript
        var lat = {{ $lat }};
        var lon = {{ $lon }};
        var name = "{{ $name }}";
        var id = "{{ $id }}";

        // Initialize the map
        var map = L.map('map').setView([lat, lon], 13); // Adjust zoom level as needed

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add a marker with the name and ID in the popup
        L.marker([lat, lon])
            .bindPopup("<b>" + name + "</b><br>ID: " + id)
            .addTo(map)
            .openPopup(); // Opens popup by default
    </script>
</body>
</html>
