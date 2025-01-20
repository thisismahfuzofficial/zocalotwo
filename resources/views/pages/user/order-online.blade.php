<x-main>
    <style>
        select.form-select:focus {
            outline: none;
            box-shadow: none;
            border-color: inherit;
        }

        select.form-select:active {
            outline: none;
            box-shadow: none;
            border-color: inherit;
        }

        input.form-control:focus {
            outline: none;
            box-shadow: none;
            border-color: inherit;
        }

        input.form-control {
            border: none;
        }
    </style>
    <div class="" style="height: 90vh;">
        <div class="row h-100">
            <div class="col-md-5 bg-light d-flex align-items-center justify-content-center">

                <div class="form-box  col-10">
                    <h1 class="fw-bold text-center">
                        Welcome to <span class="text-danger">TacoZocalo</span>
                    </h1>
                    <form action="{{ route('page.order-online-data') }}" method="POST">
                        @csrf
                        <div class="d-flex align-items-center border border-danger p-1 mb-2 shadow-sm">
                            <div class="px-3 col-3 border-end" style="white-space: nowrap;">
                                Type
                            </div>
                            <select class="form-select border-0 bg-light" name="order_type">
                                <option value="pick-up" selected>Pick Up</option>
                                <option value="home-delivery">Home Delivery</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center border border-danger p-1 md-2 shadow-sm">
                            <div class="px-3 col-3 border-end" style="white-space: nowrap;">
                                When
                            </div>
                            <select id="delivery-time" class="form-select border-0 bg-light"
                                name="delivery-time"></select>
                        </div>

                        <div class="d-flex align-items-center border border-danger p-1 my-2 shadow-sm">
                            <div class="px-3 col-3 border-end" style="white-space: nowrap;">
                                Near
                            </div>
                            <!-- Visible input for the city -->
                            <input id="cityInput" type="text" class="form-control border-0 bg-light"
                                placeholder="Getting location..." name="address">
                            <!-- Hidden input for latitude and longitude -->
                            <input id="latitudeInput" type="hidden" name="latitude">
                            <input id="longitudeInput" type="hidden" name="longitude">
                            <div class="col-1 px-1 border-start text-center btn" id="getLocationBtn">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-outline-danger px-5">Find Zocalo
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>

                    </form>
                </div>

            </div>
            <div class="col-md-7 bg-danger">

            </div>
        </div>
    </div>
    <script>
        // Function to generate time options
        function generateDeliveryTimes() {
            const select = document.getElementById("delivery-time");
            const now = new Date();

            // Round current time to the nearest 30 minutes
            const minutes = now.getMinutes();
            const roundedMinutes = minutes <= 30 ? 30 : 60; // Round up to the next half-hour
            now.setMinutes(roundedMinutes, 0, 0);

            const startTime = now; // Start time is now (rounded)
            const endTime = new Date(); // End time is 12:00 AM
            endTime.setHours(24, 0, 0, 0);

            // Add the "ASAP" option
            const asapOption = document.createElement("option");
            asapOption.value = `asap(${formatTime(startTime)})`;
            asapOption.textContent = `ASAP (${formatTime(startTime)})`;
            select.appendChild(asapOption);

            // Generate time slots in 30-minute intervals
            let currentTime = new Date(startTime);
            while (currentTime <= endTime) {
                const option = document.createElement("option");
                option.value = `time(${formatTime(currentTime)})`;
                option.textContent = formatTime(currentTime);
                select.appendChild(option);

                currentTime.setMinutes(currentTime.getMinutes() + 30);
            }

            // Select the "ASAP" option by default
            select.value = `asap(${formatTime(startTime)})`;
        }

        // Helper function to format time as "h:mm am/pm"
        function formatTime(date) {
            const hours = date.getHours();
            const minutes = date.getMinutes();
            const ampm = hours >= 12 ? "pm" : "am";
            const formattedHours = hours % 12 || 12;
            const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
            return `${formattedHours}.${formattedMinutes} ${ampm}`;
        }

        // Generate the delivery times on page load
        generateDeliveryTimes();
    </script>

<script>
    document.getElementById('getLocationBtn').addEventListener('click', function () {
        const cityInput = document.getElementById('cityInput');
        const latitudeInput = document.getElementById('latitudeInput');
        const longitudeInput = document.getElementById('longitudeInput');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async function (position) {
                    const { latitude, longitude } = position.coords;

                    // Store latitude and longitude in the hidden fields
                    latitudeInput.value = latitude;
                    longitudeInput.value = longitude;

                    // Use a reverse geocoding API to get the city and country
                    const apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;
                    try {
                        const response = await fetch(apiUrl);
                        const data = await response.json();

                        // Extract city and country
                        const city = data.address.city || data.address.town || data.address.village || "Unknown city";
                        const country = data.address.country || "Unknown country";

                        // Set city and country in the visible input
                        cityInput.value = `${city}, ${country}`;
                    } catch (error) {
                        console.error("Error fetching location details:", error);
                        cityInput.value = "Unable to fetch location details.";
                    }
                },
                function (error) {
                    console.error(error);
                    cityInput.value = "Unable to get location.";
                }
            );
        } else {
            cityInput.value = "Geolocation not supported by your browser.";
        }
    });
</script>
</x-main>
