<x-main>
    @php
        $firstItem = Cart::getContent()->last();
        $restaurant = $firstItem ? App\Models\Restaurant::find($firstItem->attributes->restaurent) : null;
        $infoRestaurant = session('info_restaurant');
        $orderType = $infoRestaurant['order_type'];
        $delivery_time = $infoRestaurant['delivery_time'];
        
        $address = $infoRestaurant['address'];
        
    @endphp
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <p><span class="description-title">Check Out</span></p>
        </div>
        <form action="{{ route('order_store') }}" method="post">
            @csrf
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gap-4">
                    <div class="col-md-7 border rounded ">
                        <div class="">
                            @if ($restaurant->latest())
                                <div class="content mb-3 mt-5" data-aos="fade-up">
                                    <h2 class="text-colour">{{ $restaurant->name }}</h2>

                                    <div class="d-flex gap-3">
                                    </div>
                                </div>
                            @endif

                            <div class="row gy-4">

                                <div class="col-md-6 ">
                                    <input type="text" class="form-control" name="f_name"
                                        placeholder="Your first name" required value={{ auth()->user()->name ?? '' }}>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="l_name" class="form-control"
                                        placeholder="Your last name" required value={{ auth()->user()->l_name ?? '' }}>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" id="number_type" name="phone" class="form-control"
                                        placeholder="Phone number" required value={{ auth()->user()->phone ?? '' }}>
                                </div>

                                <div class="col-md-6">


                                    <select id="delivery-time" class="form-select border-0 bg-light"></select>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <input type="text" name="address" class="form-control"
                                        placeholder="Your email address" required value={{ $address }}>
                                </div>

                                <div class="col-md-12">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Your email address" required=""
                                        value="{{ old('email', auth()->user()->email ?? '') }}">
                                    @error('email')
                                        <p class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <textarea name="commment" class="form-control" placeholder="Additional information" style="height:122px;"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 border rounded ">
                        <div class="heading border-bottom">
                            <div class="h3 py-2">Your Cart</div>
                        </div>
                        <div class="title d-flex justify-content-between my-2">
                            <div class="h4">Product</div>
                            <div class="h4">Price</div>
                        </div>
                        <hr>
                        <div class="products d-flex justify-content-between mt-2">
                            {{-- <p> {{ $product->name }} <span>* {{ $product->quantity }}</span></p>
                                <p>${{ number_format($product->price * $product->quantity, 2) }}</p> --}}
                            <table class="table-responsive" style="width: 100%;">
                                @foreach (Cart::getContent() as $product)
                                    <tr style="height: 38px;">
                                        <td class="ps-3" style="font-size: 18pxpx;">
                                            {{ $product->name }} * {{ $product->quantity }}
                                        </td>
                                        <td class="text-end" style="font-size: 18px;">
                                            $ {{ number_format($product->price * $product->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <hr class="mt-3">
                        <div class="ps-3">
                            @if ($restaurant->enable_payment)
                                <div class="form-check mt-2 mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="payment_method2" checked value="Card">
                                    <label class="form-check-label" style="font-size: 15px;" for="payment_method2">Card
                                    </label>
                                </div>
                            @endif
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="payment_method1" value="Cash on delivery">
                                <label class="form-check-label" style="font-size: 15px;" for="payment_method1">
                                    Cash on delivery
                                </label>
                            </div>

                        </div>
                        <hr>
                        <div class="title d-flex justify-content-between my-2">
                            <div class="h4">Subtotal</div>
                            <div class="h4">${{ number_format(Cart::getSubTotal(), 2) }}</div>
                        </div>
                        <div class="title d-flex justify-content-between my-2">
                            <div class="h4">Management fees</div>
                            <div class="h4">$00.00</div>
                        </div>
                        <div class="title d-flex justify-content-between my-2">
                            <div class="h4">VAT</div>
                            <div class="h4">$00.00</div>
                        </div>
                        <div class="title d-flex justify-content-between my-2">
                            <div class="h3">Total</div>
                            <div class="h3">$ {{ number_format(Cart::getSubTotal(), 2) }}</div>
                        </div>
                        <button class="btn btn-danger w-100 my-3">Make Payment</button>
                    </div>
                </div>
            </div>
        </form>


    </section><!-- /Contact Section -->

    @push('js')
        <script>
            // Fetch the delivery time from server-side data
            const preSelectedTime = @json($infoRestaurant['delivery_time'] ?? null);

            // Function to generate time options
            function generateDeliveryTimes(preSelectedTime = null) {
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

                // Set the selected value
                if (preSelectedTime) {
                    select.value = preSelectedTime;
                } else {
                    select.value = `asap(${formatTime(startTime)})`;
                }
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

            // Generate the delivery times with the pre-selected value
            generateDeliveryTimes(preSelectedTime);
        </script>
    @endpush


</x-main>
