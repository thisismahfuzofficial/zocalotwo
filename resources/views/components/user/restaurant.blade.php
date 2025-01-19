@push('css')
    <style>
        .member img {
            width: 100%;
            height: 400px;
            /* Adjust height as needed */
            object-fit: cover;
        }

        .restaurantName {
            display: none;
        }

        @media (min-width: 320px) and (max-width: 480px) {
            .restaurantName {
                display: block !important;
                text-align: center !important;
            }

            .member:hover ~ .restaurantName {
                display: none;
                opacity: 0 !important;
                transition: 0.4s;
            }
        }
        @media (min-width: 412px) and (max-width: 915px) {
            .restaurantName {
                display: block !important;
                text-align: center !important;
            }

            .member:hover ~ .restaurantName {
                display: none;
                opacity: 0 !important;
                transition: 0.4s;
            }
        }
    </style>
@endpush

<section id="chefs" class="chefs section bg-transparent">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ __('sentence.restaurants') }}</h2>
        <p style="color: #E5D5BF">{{ __('sentence.restaurantstitle') }}</p>
    </div><!-- End Section Title -->
    <div class="container">
        <div class="row gy-4">
            @foreach ($restaurants as $restaurant)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ $restaurant->status == 1 ? route('restaurant.menu', $restaurant->slug) : 'javascript:void(0)' }}" onclick="{{ $restaurant->status != 0 ? 'window.history.back()' : "alert('The restaurant is closed.!')" }}">
                        <div class="member">
                            <img src="{{ $restaurant->image ? Storage::url($restaurant->image) : asset('niko/image/restaurant.jpg') }}"
                                class="img-fluid" alt="">
                            <div class="member-info">
                                <div class="member-info-content">
                                    <h4>{{ $restaurant->name }}</h4>
                                    <span>{{ $restaurant?->address['address'] ?? '' }}</span>
                                </div>
                                <div class="member-info-content mt-2">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    </div>

</section>
