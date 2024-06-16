<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <h4 class="text-xl capitalize">Current Location</h4>
    <!-- start:: Markers Map -->
    <div id="map" style="height: 400px;"></div>
    <!-- end:: Markers Map -->
</div>

@push('scripts')
<script>
var map = L.map('map').setView([14.0860746, 100.608406], 6);
var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});
osm.addTo(map);

        var marker, circle;
        var lastPosition;

        function updatePosition(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            var accuracy = position.coords.accuracy;

            // Check if position has changed significantly
            if (!lastPosition || Math.abs(lat - lastPosition.lat) > 0.001 || Math.abs(long - lastPosition.lng) > 0.001) {
                if (marker) {
                    map.removeLayer(marker);
                }
                if (circle) {
                    map.removeLayer(circle);
                }

                marker = L.marker([lat, long]).addTo(map);
                circle = L.circle([lat, long], {radius: accuracy}).addTo(map);

                var bounds = L.latLngBounds([lat, long]);
                bounds.extend(circle.getBounds());
                map.fitBounds(bounds);

                lastPosition = {lat: lat, lng: long};
            }

            console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy);
        }

        if (!navigator.geolocation) {
            console.log("Your browser doesn't support geolocation feature!");
        } else {
            navigator.geolocation.getCurrentPosition(updatePosition);
            setInterval(function() {
                navigator.geolocation.getCurrentPosition(updatePosition);
            }, 10000); // Update every 10 seconds
        }

    </script>
@endpush




