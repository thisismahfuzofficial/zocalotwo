
// Function to initialize the map for map-nos div


$(document).ready(function () {
    // Fetch Google Maps API key from the server
    fetch('/\)
        .then(response => response.text())
        .then(apiKey => {
            let key = JSON.parse(apiKey);

            // Load Google Maps API with the retrieved API key
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key=${key}&libraries=geometry,places&callback=initMapNOS`;
            script.async = true;
            script.defer = true;
            script.onload = function () {
                // Now that the Google Maps API is loaded, you can use it

                // Autocomplete functionality
                var input = document.getElementById('map_address_input');

                var options = {
                    componentRestrictions: {
                        country: 'fr'
                    }
                };


                var autocomplete = new google.maps.places.Autocomplete(input, options);

                // Fetch the current location when the document is ready
                // Function to geocode an address
                function geocodeAddress(address, callback) {
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'address': address
                    }, function (results, status) {
                        if (status === 'OK') {
                            callback({
                                lat: results[0].geometry.location.lat(),
                                lng: results[0].geometry.location.lng()
                            });
                        } else {
                            alert('Select Correct Address');
                        }
                    });
                }
                console.log(geocodeAddress);

                function checkIfPointInAnyZone(point, callback) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', '/zones', true);
                    xhr.onload = function () {

                        var zones = JSON.parse(xhr.responseText);

                        for (var i = 0; i < zones.length; i++) {
                            var zone = zones[i];

                            var polygon = new google.maps.Polygon({
                                paths: zone.coordinates.map(coord => ({
                                    lat: coord.lat,
                                    lng: coord.lng
                                }))
                            });
                            if (google.maps.geometry.poly.containsLocation(point, polygon)) {
                                callback(zone);
                                return;
                            }
                        }
                        callback(null);
                    };
                    xhr.send();
                }

                // Your other code here
                $('#checkDZ').click(function () {
                    var address = $('#map_address_input').val();

                    geocodeAddress(address, function (location) {
                        var lat = location.lat;
                        var lng = location.lng;

                        var point = new google.maps.LatLng(lat, lng);

                        checkIfPointInAnyZone(point, function (zone) {

                            if (zone) {
                                $.ajax({
                                    url: '/store-in-session',
                                    method: 'POST',
                                    data: {
                                        'method': 'delivery',
                                        'restaurant': zone
                                            .restaurant_id,
                                        'address': address,
                                        _token: '{{ csrf_token() }}' // Ensure you have CSRF token included
                                    },
                                    success: function (response) {
                                        console.log(
                                            'Restaurant name stored in session'
                                        );
                                        console.log(zone
                                            .restaurant_id);
                                        window.location.href =
                                            "/menu"; // Redirect to the menu page
                                    },
                                    error: function (jqXHR,
                                        textStatus, errorThrown
                                    ) {
                                        alert(
                                            'An error occurred. Please try again.'
                                        );
                                    }
                                });
                            } else {
                                alert(
                                    'Nous ne pouvons pas délivrer cette adresse, veuillez sélectionner un restaurant pour retirer votre commande'
                                );
                            }
                        });

                    });
                });
            };

            // Append the script to the document head
            document.head.appendChild(script);
        });
});

// Function to get address from latitude and longitude
function getAddressFromLatLng(lat, lng) {
    var geocoder = new google.maps.Geocoder();
    var latlng = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
    };

    geocoder.geocode({
        'location': latlng
    }, function (results, status) {
        if (status === 'OK') {
            if (results[0]) {
                document.getElementById('map_address_input').value = results[0].formatted_address;
            } else {
                alert('No results found');
            }
        } else {
            alert('Geocoder failed due to: ' + status);
        }
    });
}

// Function to get the current location of the user
function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            getAddressFromLatLng(latitude, longitude);
        }, function (error) {
            alert('Error occurred. Error code: ' + error.code);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}
