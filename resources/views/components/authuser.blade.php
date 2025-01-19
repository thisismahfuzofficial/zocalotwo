<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sushi</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('logo/sushiFav.png') }}" rel="icon">
    <link href="{{ asset('logo/sushiFav.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('niko/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('niko/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('niko/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('niko/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('niko/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('niko/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('niko/custom.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('style.css')}}" />

    @stack('css')
    <!-- =======================================================
  * Template Name: Restaurantly
  * Template URL: https://bootstrapmade.com/restaurantly-restaurant-template/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

<body class="index-page body-colour" style="height: 100vh">

   

    <main class="main">

        {{ $slot }}

        {{-- <x-user.extra/> --}}
    </main>

   

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Vendor JS Files -->
    <script src="{{ asset('niko/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('niko/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('niko/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('niko/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('niko/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('niko/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('niko/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    {{-- logout  --}}

    <!-- Main JS File -->
    <script src="{{ asset('niko/assets/js/main.js') }}"></script>
    <script>
        $('.logout-trigger').click(() => $('#logout-form').submit());
    </script>
    <script>
        let userLatitude = null;
        let userLongitude = null;

        
        document.getElementById('location-button').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success, error);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

        function success(position) {
            userLatitude = position.coords.latitude;
            userLongitude = position.coords.longitude;

            // Call the Google Maps Geocoding API to get the address
            // const apiKey = 'AIzaSyCt4M6sXKliR4X6j3l3ubOt8HeXN-CKMMY';
            const apiKey = "{{env('GOOGLE_MAPS_API_KEY')}}";
            const geocodeUrl =
                `https://maps.googleapis.com/maps/api/geocode/json?latlng=${userLatitude},${userLongitude}&key=${apiKey}`;

            fetch(geocodeUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'OK') {
                        const address = data.results[0].formatted_address;
                        document.getElementById('location-input').value = address;
                    } else {
                        alert('Unable to retrieve address.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function error() {
            alert("Unable to retrieve your location.");
        }


        document.getElementById('enter-button').addEventListener('click', function() {
            if (userLatitude !== null && userLongitude !== null) {

                fetch('/check-location', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            latitude: userLatitude,
                            longitude: userLongitude
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect_url;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert("Please click the location icon to get your current location first.");
            }
        });
    </script>


    @stack('js')
</body>

</html>
