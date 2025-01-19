    @php
        $firstItem = Cart::getContent()->last();
        $restaurant = $firstItem ? App\Models\Restaurant::find($firstItem->attributes->restaurent) : null;
        $locations = explode(',', session()->get('current_location'));
        $address = session()->get('address');
        $city = session()->get('city');
        $postalCode = session()->get('postalCode');
        $extra_charge = Settings::setting('extra.charge');

        // $zone = $restaurant ? $restaurant->zones->get() : null;
         // Cart::clear();
        //dd(Cart::getContent());
    @endphp

    <x-user>
        @push('css')
            <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

            <style>
                .sushibtn {
                    padding: 4px 3px !important;
                    border: 1px solid var(--accent-color) !important;
                    border-radius: 0px;
                    color: #ffffff;
                }

                .sushibtn {
                    padding: 4px 3px !important;
                    border: 1px solid var(--accent-color) !important;
                    border-radius: 0px;
                    background-color: var(--accent-color);
                    color: #ffffff;
                }
                @media (min-width: 360px) and (max-width: 740px) {
                    .cartTOTAL{
                        width: 100px;
                    }
                    .order_btn {
                        width: 381px !important;
                        padding-left: 0px !important;
                    }
                }
            </style>
        @endpush
        <br><br><br>
        <!-- Contact Section -->
        <section id="contact" class="contact section bg-transparent">

            <!-- Section Title -->
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-md-12 col-sm-12 mb-4">
                        <div class="container content mb-5 ps-0" data-aos="fade-up">
                            <div class="mb-2">
                                <a href="{{ route('restaurant.cart', ['slug' => $restaurant->slug]) }}" role="button"
                                    class="btn sushibtn p-md-3 goback"> <i class="bi bi-chevron-left"></i> </a>

                                {{-- <a href="{{ route('restaurant.menu', ['slug' => $restaurant->slug]) }}" role="button"
                                    class="btn sushibtn p-md-3 goback"> Menu <i class="bi bi-chevron-right"></i></a> --}}
                            </div>
                            <div class=" section-title aos-init aos-animate pb-0" data-aos="fade-up">
                                <p class="">{{ __('sentence.checkout') }}</p>
                            </div>
                            @auth
                            @else
                                <div class="d-flex gap-3">
                                    <p class="fst-italic">{{ __('sentence.returningcustomer') }}</p>
                                    <a href="{{ route('login') }}"> {{ __('sentence.login') }}</a>
                                </div>
                            @endauth

                        </div>

                        <form action="{{ route('order_store') }}" method="post" class="php-email-form"
                            data-aos="fade-up" data-aos-delay="200">
                            @csrf

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <div class="col-md-12">

                                        <select id="deliveryOption" name="delivery_option"
                                            class="form-select selectpicker" data-container="body">
                                            <option selected style="color: var(--accent-color)">
                                                {{ __('sentence.openthismenu') }}
                                            </option>

                                            @if ($restaurant->delivery_option == 'take_away')
                                                <option value="take_away" selected>{{ __('sentence.takeaway') }}
                                                </option>
                                            @elseif ($restaurant->delivery_option == 'home_delivery')
                                                <option value="home_delivery" selected>
                                                    {{ __('sentence.homedelivery') }}</option>
                                            @elseif ($restaurant->delivery_option == 'both')
                                                <option value="take_away">{{ __('sentence.takeaway') }}</option>
                                                <option value="home_delivery"
                                                    {{ session()->get('current_location') ? 'selected' : '' }}>
                                                    {{ __('sentence.homedelivery') }}
                                                </option>
                                            @endif
                                        </select>


                                    </div>

                                    <div id="takeAwayForm" class="mt-5">
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
                                                    placeholder="{{ __('sentence.your_first_name') }}" required
                                                    value={{ auth()->user()->name ?? '' }}>
                                            </div>

                                            <div class="col-md-6">
                                                <input type="text" name="l_name" class="form-control"
                                                    placeholder="{{ __('sentence.your_last_name') }}" required
                                                    value={{ auth()->user()->l_name ?? '' }}>
                                            </div>

                                            <div class="col-md-6">
                                                <input type="text" id="number_type" name="phone"
                                                    class="form-control"
                                                    placeholder="{{ __('sentence.your_phone_numder') }}" required
                                                    value={{ auth()->user()->phone ?? '' }}>
                                            </div>


                                            <div class="col-md-6">
                                                <select name="time_option"class="form-select selectpicker"
                                                    data-container="body" disabled>
                                                    @foreach ($timeSlots as $time)
                                                        <option value="{{ $time }}"
                                                            {{ isset($timeSelect[0]) && $time == $timeSelect[0] ? 'selected' : '' }}>
                                                            {{ $time }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <input type="email" name="email" disabled
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="{{ __('sentence.your_email') }}" required=""
                                                    value="{{ old('email', auth()->user()->email ?? '') }}">
                                                @error('email')
                                                    <p class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <textarea name="commment" class="form-control" placeholder="{{ __('sentence.your_comment') }}" style="height:122px;"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="homeDeliveryForm" class="mt-5">

                                        @if ($restaurant)
                                            <div class="content mb-3 mt-5" data-aos="fade-up">
                                                <h2 class="text-colour">{{ $restaurant->name }}</h2>
                                                <div class="d-flex gap-3">
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row gy-4">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="f_name"
                                                    placeholder="{{ __('sentence.your_first_name') }}" required=""
                                                    value={{ auth()->user()->name ?? '' }}>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="l_name"
                                                    placeholder="{{ __('sentence.your_last_name') }}" required=""
                                                    value={{ auth()->user()->l_name ?? '' }}>
                                            </div>


                                            <div class="col-md-12">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="{{ __('sentence.your_email') }}" required
                                                    value={{ auth()->user()->email ?? '' }}>
                                            </div>

                                            <div class="col-md-12 input-group text-center">
                                                <input type="text" name="address" id="map_address_input"
                                                    class="form-control"
                                                    placeholder="{{ __('sentence.your_address') }}" required
                                                    value="{{ auth()->user()->address ?? $address }}">

                                                <button class="btn bg-black border-0 btn-outline-orange"
                                                    style="border-left: 0px" type="button"
                                                    onclick="getCurrentLocation()" id="location-button">
                                                    <i class="bi bi-geo-alt fs-4"></i>
                                                </button>
                                                <button id="checkDZ"class="btn btn-outline-orange"
                                                    style="background-color: var(--accent-color) !important; border-color: var(--accent-color) !important; color: #ffffff !important;">
                                                    ENTRÉE
                                                </button>

                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" name="city" class="form-control"
                                                    placeholder="{{ __('sentence.your_city') }}" required=""
                                                    value="{{ auth()->user()->city ?? $city }}">

                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="post_code" class="form-control"
                                                    placeholder="{{ __('sentence.your_post_code') }}" required=""
                                                    value={{ auth()->user()->post_code ?? $postalCode }}>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="number_type" name="phone"
                                                    class="form-control"
                                                    placeholder="{{ __('sentence.your_phone_numder') }}" required
                                                    value={{ auth()->user()->phone ?? '' }}>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="house" class="form-control"
                                                    placeholder="{{ __('sentence.your_house') }}"
                                                    value={{ auth()->user()->house ?? '' }}>
                                            </div>


                                            <div class="col-md-6">
                                                <select name="time_option" class="form-select selectpicker"
                                                    data-container="body" disabled>
                                                    @foreach ($timeSlots as $time)
                                                        <option value="{{ $time }}"
                                                            {{ isset($timeSelect[0]) && $time == $timeSelect[0] ? 'selected' : '' }}>
                                                            {{ $time }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col-md-12">
                                                <textarea name="commment" class="form-control" placeholder="{{ __('sentence.your_comment') }}"
                                                    style="height:122px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-sm-12">

                                    <div class="checkout_main_body">
                                        <div class="container content mb-3 mt-3" data-aos="fade-up">
                                            <h2 class="text-colour">{{ __('sentence.yourorder') }}</h2>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table-responsive" style="width: 100%;">
                                                <thead class="">
                                                    <tr>
                                                        <td class="fs-4 fw-medium ps-3 pe-0">
                                                            {{ __('sentence.products') }}
                                                            <hr>
                                                        </td>
                                                        <td class="fs-4 fw-medium text-center pe-3 ps-0">
                                                            {{ __('sentence.price') }}
                                                            <hr>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    @foreach (Cart::getContent() as $product)
                                                        <tr style="height: 38px;">
                                                            <td class="ps-3" style="font-size: 13px;">
                                                                {{ $product->name }} * {{ $product->quantity }}
                                                            </td>
                                                            <td class="text-center" style="font-size: 13px;">
                                                                {{ number_format($product->price * $product->quantity, 2) }} €
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr style="border-top: 1px solid var(--accent-color)">
                                                        <td>
                                                            <p class="fs-5 fw-medium ps-3 pt-2 pb-2">
                                                                {{ __('sentence.paymentmethod') }}
                                                            </p>
                                                            <div class="ps-3">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="payment_method" id="payment_method1"
                                                                        value="Cash on delivery">
                                                                    <label class="form-check-label"
                                                                        style="font-size: 15px;"
                                                                        for="payment_method1">
                                                                        {{ __('sentence.cashondelivery') }}
                                                                    </label>
                                                                </div>
                                                                <div class="">
                                                                    <p style="font-size: smaller; color: var(--accent-color); margin-bottom: .5rem !important;">Aucun paiement CB ne sera accepté à la livraison</p>
                                                                </div>
                                                                @if ($restaurant->enable_payment)
                                                                    <div class="form-check mt-2 mb-3">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="payment_method" id="payment_method2"
                                                                            checked value="Card">
                                                                        <label class="form-check-label"
                                                                            style="font-size: 15px;"
                                                                            for="payment_method2">{{ __('sentence.onlinecreditcard') }}
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr style="border-top: 1px solid var(--accent-color)">
                                                        <td class="fs-6 fw-medium ps-3 pt-2 pb-2">
                                                            {{ __('sentence.subtotal') }}</td>
                                                        <td class="fs-6 fw-medium text-center">
                                                            {{ number_format(Cart::getSubTotal() - Settings::totalTax() , 2) }}€
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-6 fw-medium ps-3 pt-2 pb-2">
                                                            {{ __('sentence.extra_charge') }}</td>
                                                        <td class="fs-6 fw-medium text-center">
                                                            {{ $extra_charge }} €
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-6 fw-medium ps-3 pt-2 pb-2">
                                                            {{ __('sentence.total_tax') }}</td>
                                                        <td class="fs-6 fw-medium text-center">
                                                                {{ Settings::totalTax() }} €
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-5 fw-medium ps-3 pt-2 pb-2">
                                                            {{ __('sentence.totle') }}</td>
                                                        <td class="fs-5 fw-medium text-center cartTOTAL">
                                                            {{ number_format(Cart::getSubTotal() + (float) ($extra_charge ?? 0), 2) }}
                                                            €
                                                        </td>
                                                    </tr>

                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="btn-wrapper text-center pt-0 pb-0 pe-md-3">
                                            <button type="submit" class="order_btn" id="orderButton"
                                                disabled>{{ __('sentence.order_button') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- End Contact Form -->
                </div>

            </div>
        </section><!-- /Contact Section -->
        @push('js')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="script.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deliveryOption = document.getElementById('deliveryOption');
                    const takeAwayForm = document.getElementById('takeAwayForm');
                    const homeDeliveryForm = document.getElementById('homeDeliveryForm');
                    const orderButton = document.getElementById('orderButton');

                    // Function to set form inputs' disabled state
                    const setFormDisabledState = (form, disabled) => {
                        if (form) {
                            const inputs = form.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => input.disabled = disabled);
                        }
                    };

                    // Function to update the visibility of forms
                    const updateFormVisibility = () => {
                        const selectedOption = deliveryOption.value;

                        if (selectedOption === 'take_away') {
                            takeAwayForm.style.display = 'block';
                            homeDeliveryForm.style.display = 'none';
                            setFormDisabledState(takeAwayForm, false);
                            setFormDisabledState(homeDeliveryForm, true);
                            orderButton.disabled = false;
                        } else if (selectedOption === 'home_delivery') {
                            takeAwayForm.style.display = 'none';
                            homeDeliveryForm.style.display = 'block';
                            setFormDisabledState(takeAwayForm, true);
                            setFormDisabledState(homeDeliveryForm, false);
                            orderButton.disabled = false;
                        } else {
                            takeAwayForm.style.display = 'none';
                            homeDeliveryForm.style.display = 'none';
                            orderButton.disabled = true;
                        }
                    };

                    // Add event listener for changes in the delivery option
                    deliveryOption.addEventListener('change', updateFormVisibility);

                    // Initialize form visibility on page load
                    updateFormVisibility();
                });
            </script>
        @endpush
    </x-user>
