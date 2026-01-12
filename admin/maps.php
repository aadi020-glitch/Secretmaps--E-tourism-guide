<script>
const map = L.map('map').setView([19.0760, 72.8777], 5); // Default center

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);

// Predefined destinations
const destinations = [
    {name: "Ajanta Caves", lat: 20.5520, lng: 75.7033},
    {name: "Lonar Lake", lat: 19.9722, lng: 76.5236},
    {name: "Kaas Plateau", lat: 17.9524, lng: 73.8936},
    {name: "Amboli", lat: 15.9189, lng: 74.0033}
];

destinations.forEach(dest => {
    L.marker([dest.lat, dest.lng]).addTo(map)
        .bindPopup(dest.name);
});

let userMarker, routeLayer, destMarker;

// --- Search & Directions ---
const searchBtn = document.getElementById('searchBtn');
const searchBox = document.getElementById('searchBox');

// Replace with your actual API key
const apiKey = 'YOUR_OPENROUTESERVICE_API_KEY';

searchBtn.addEventListener('click', () => {
    const query = searchBox.value.trim();
    if (!query) return alert("Please enter a location!");

    // Nominatim search
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`, {
        headers: { 'User-Agent': 'SecretMapsApp/1.0' }
    })
    .then(res => res.json())
    .then(data => {
        if (!data.length) return alert("Location not found!");

        const destLat = parseFloat(data[0].lat);
        const destLon = parseFloat(data[0].lon);

        // Remove previous destination marker
        if (destMarker) map.removeLayer(destMarker);
        destMarker = L.marker([destLat, destLon]).addTo(map)
                         .bindPopup(query)
                         .openPopup();

        map.setView([destLat, destLon], 13);

        // Get user location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;

                // Remove previous user marker
                if (userMarker) map.removeLayer(userMarker);
                userMarker = L.marker([userLat, userLon], {
                    icon: L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/64/64113.png',
                        iconSize: [30,30]
                    })
                }).addTo(map)
                  .bindPopup("You are here").openPopup();

                // Remove previous route
                if (routeLayer) map.removeLayer(routeLayer);

                // Fetch route from OpenRouteService
                fetch('https://api.openrouteservice.org/v2/directions/driving-car', {
                    method: 'POST',
                    headers: {
                        'Authorization': apiKey,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        coordinates: [
                            [userLon, userLat],
                            [destLon, destLat]
                        ]
                    })
                })
                .then(res => res.json())
                .then(routeData => {
                    const coords = routeData.features[0].geometry.coordinates.map(c => [c[1], c[0]]);
                    routeLayer = L.polyline(coords, {color: 'blue', weight: 5}).addTo(map);
                    map.fitBounds(routeLayer.getBounds());
                })
                .catch(err => console.error("Routing error:", err));

            }, err => {
                alert("Unable to get your location. Showing destination only.");
            });
        } else {
            alert("Geolocation not supported. Showing destination only.");
        }
    })
    .catch(err => console.error("Search error:", err));
});
</script>
