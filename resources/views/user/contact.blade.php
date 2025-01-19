<x-user>
    @push('css')
        <style>
            .accordion {
                --bs-accordion-color: #E4D4BF;
                --bs-accordion-bg: transparent;
                --bs-accordion-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, border-radius 0.15s ease;
                --bs-accordion-border-color: transparent;
                --bs-accordion-border-width: var(--bs-border-width);
                --bs-accordion-border-radius: var(--bs-border-radius);
                --bs-accordion-inner-border-radius: calc(var(--bs-border-radius) -(var(--bs-border-width)));
                --bs-accordion-btn-padding-x: 1.25rem;
                --bs-accordion-btn-padding-y: 1rem;
                --bs-accordion-btn-color: #E4D4BF;
                --bs-accordion-btn-bg: transparent;
                --bs-accordion-btn-icon: url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'%3E%3C!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --%3E%3Cstyle%3Esvg%7Bfill:%23e4d48f%7D%3C/style%3E%3Cpath d='M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z' /%3E%3C/svg%3E);
                --bs-accordion-btn-icon-width: 1.25rem;
                --bs-accordion-btn-icon-transform: rotate(-180deg);
                --bs-accordion-btn-icon-transition: transform 0.2s ease-in-out;
                --bs-accordion-btn-active-icon: url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'%3E%3C!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --%3E%3Cstyle%3Esvg%7Bfill:%23e4d48f%7D%3C/style%3E%3Cpath d='M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z' /%3E%3C/svg%3E);
                --bs-accordion-btn-focus-border-color: #86b7fe;
                --bs-accordion-btn-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
                --bs-accordion-body-padding-x: 1.25rem;
                --bs-accordion-body-padding-y: 1rem;
                --bs-accordion-active-color: #E4D4BF;
                --bs-accordion-active-bg: transparent;
            }

            * {
                font-family: "Montserrat", sans-serif !important;
                font-optical-sizing: auto !important;
                font-style: normal !important;
            }

            .pmclr {
                color: #e4d4bf !important;
            }

            .card_hidden {
                max-height: 180px !important;
            }

            .hidden {
                display: none;
                overflow: none;
            }

            .card-list {
                padding: 30px;
                margin: 10px;
                width: 100%;
                position: relative;
                max-height: 500px !important;
                overflow: hidden;
            }

            .opbg {
                background-color: rgba(0, 0, 0, 0.5) !important;
            }

            .card-header:first-child {
                border-radius: var(--bs-card-inner-border-radius) var(--bs-card-inner-border-radius) 0 0 !important;
            }

            .card-header {
                padding: var(--bs-card-cap-padding-y) var(--bs-card-cap-padding-x);
                margin-bottom: 0;
                color: var(--bs-card-cap-color);
                background-color: var(--bs-card-cap-bg);
                border-bottom: var(--bs-card-border-width) solid var(--bs-card-border-color);
            }

            .icon-btn::after {
                flex-shrink: 0 !important;
                width: var(--bs-accordion-btn-icon-width) !important;
                height: var(--bs-accordion-btn-icon-width) !important;
                margin-left: auto !important;
                content: "";
                background-image: var(--bs-accordion-btn-icon) !important;
                background-repeat: no-repeat !important;
                background-size: var(--bs-accordion-btn-icon-width) !important;
                transition: var(--bs-accordion-btn-icon-transition) !important;
            }

            .opbg {
                background-color: rgba(0, 0, 0, 0.05);
                padding: 20px;
                border-radius: 8px;
            }

            .pmclr {
                margin-bottom: 20px;
            }

            .card-header {
                padding: var(--bs-card-cap-padding-y) var(--bs-card-cap-padding-x);
                margin-bottom: 0;
                color: var(--bs-card-cap-color);
                background-color: var(--bs-card-cap-bg);
                border-bottom: var(--bs-card-border-width) solid var(--bs-card-border-color);
            }

            .icons-list {
                display: flex !important;
                gap: 5px !important;
            }

            .icon-btn {
                font-weight: 100;
                cursor: pointer;
                position: absolute;
                top: 0;
                right: 0;
                z-index: 9999;
                font-size: 52px !important;
                padding: 10px;
                transition: transform 0.3s ease !important;
            }

            .icon-btn {
                transform: rotate(180deg) !important;
                /* Rotate the icon to show "+" when active */
            }

            tbody,
            td,
            tfoot,
            th,
            thead,
            tr {
                border-color: inherit !important;
                border-style: solid !important;
                border-width: 0 !important;
            }
        </style>
    @endpush
    <br> <br> <br>
    <!-- Contact Section -->
    <section id="contact" class="contact section bg-transparent">
        <div class="row pmclr">
            <div class="col-md-6">
                <div id="card-list1" class="card-list opbg mb-5 card_hidden">
                    <div class="card-header">
                        <h3>Central Sushi Dijon</h3>
                        <p class="mb-3">25 Place Darcy <br>21000 DIJON</p>
                        <h4 class="mb-3" style="color: #ba321c!important;">03 80 23 22 00</h4>
                        <div class="icons-list">
                            <span id="icon-btn1" class="icon-btn"
                                onclick="toggleCard('card-list-content1', 'icon-btn1')">+</span>
                        </div>
                    </div>
                    <div id="card-list-content1" class="card-list-content hidden">
                        <p>{{ __('sentence.time_schedules') }}</p>
                        <table style="text-align: left; width: 70%;">
                            @foreach ($time_schedules as $time_schedule)
                                @if ($time_schedule->restaurant_id == 4)
                                    <tr>
                                        {!! $time_schedule->time_schedule ?? '' !!}
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3 d-flex justify-content-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2704.535575207828!2d5.0314998!3d47.3234108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f29d94bd63fdcb%3A0x5c3d38bb2bb2ac71!2s25%20Pl.%20Darcy%2C%2021000%20Dijon%2C%20France!5e0!3m2!1sen!2sae!4v1709789861376!5m2!1sen!2sae"
                    width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="row pmclr">
            <div class="col-md-6">
                <div id="card-list2" class="card-list opbg mb-5 card_hidden">
                    <div class="card-header">
                        <h3>Central Sushi Besançon</h3>
                        <p class="mb-3">35 Avenue Carnot <br>25000 BESANCON</p>
                        <h4 class="mb-3" style="color: #ba321c!important;">03 70 88 97 00</h4>
                        <div class="icons-list">
                            <span id="icon-btn2" class="icon-btn"
                                onclick="toggleCard('card-list-content2', 'icon-btn2')">+</span>
                        </div>
                    </div>
                    <div id="card-list-content2" class="card-list-content hidden">
                        <p>{{ __('sentence.time_schedules') }}</p>
                        <table style="text-align: left; width: 70%;">
                            @foreach ($time_schedules as $time_schedule)
                                @if ($time_schedule->restaurant_id == 5)
                                    <tr>
                                        {!! $time_schedule->time_schedule ?? '' !!}
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3 d-flex justify-content-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2708.535068686864!2d6.028422399999999!3d47.2452395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478d63238af430cd%3A0xdc33127591633489!2s35%20Av.%20Sadi%20Carnot%2C%2025000%20Besan%C3%A7on%2C%20France!5e0!3m2!1sen!2sae!4v1709790005587!5m2!1sen!2sae"
                    width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div class="row pmclr">
            <div class="col-md-6">
                <div id="card-list3" class="card-list opbg mb-5 card_hidden">
                    <div class="card-header">
                        <h3>Central Sushi Belfort</h3>
                        <p class="mb-3">60 Faubourg de Montbéliard<br>90000 BELFORT</p>
                        <h4 class="mb-3" style="color: #ba321c!important;">03 84 58 67 37</h4>
                        <div class="icons-list">
                            <span id="icon-btn3" class="icon-btn"
                                onclick="toggleCard('card-list-content3', 'icon-btn3')">+</span>
                        </div>
                    </div>
                    <div id="card-list-content3" class="card-list-content hidden">
                        <p>{{ __('sentence.time_schedules') }}</p>
                        <table style="text-align: left; width: 70%;">
                            @foreach ($time_schedules as $time_schedule)
                                @if ($time_schedule->restaurant_id == 6)
                                    <tr style="color: #ffffff">
                                        {!! $time_schedule->time_schedule ?? '' !!}
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3 d-flex justify-content-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2711.8571351266864!2d6.8619278!3d47.6370358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479238d2c08706d7%3A0x38004eb2399998e8!2s60%20Faubourg%20de%20Montb%C3%A9liard%2C%2090000%20Belfort%2C%20France!5e0!3m2!1sen!2sae!4v1709790154123!5m2!1sen!2sae"
                    width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </section><!-- /Contact Section -->

    @push('js')
        <script>
            function initMapNOS() {
                const locations = [{
                        lat: 47.323430,
                        lng: 5.031508
                    }, // New York City
                    {
                        lat: 47.245721,
                        lng: 6.028465
                    }, // Los Angeles
                    {
                        lat: 47.631816,
                        lng: 6.856420
                    } // London
                ];

                const map = new google.maps.Map(document.getElementById('map-nos'), {
                    zoom: 7,
                    center: locations[0]
                });

                locations.forEach((location) => {
                    new google.maps.Marker({
                        position: location,
                        map: map
                    });
                });
            }

            initMapNOS();
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            function toggleCard(contentId, iconId) {
                var content = document.getElementById(contentId);
                var icon = document.getElementById(iconId);

                // Toggle the content visibility with jQuery
                $(content).toggle("slow", function() {
                    // Once the toggle is complete, check if it's visible
                    if ($(content).is(":visible")) {
                        icon.innerHTML = '-'; // Change icon to '-'
                    } else {
                        icon.innerHTML = '+'; // Change icon to '+'
                    }
                });
            }
        </script>
    @endpush

</x-user>
