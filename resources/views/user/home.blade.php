<x-user>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
        <style>
            @media only screen and (max-width: 600px) {
                .chefs .member .member-info {
                    background: linear-gradient(0deg, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.8) 20%, rgba(255, 255, 255, 0) 100%);
                    opacity: 1;
                    transition: 0.4s;
                }
            }
        </style>
    @endpush

    <section class="Mainslide" style="padding: 0px 0;">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
            <div class="carousel-inner">
                @foreach ($sliders as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" data-bs-interval="4000">
                        <div style="position: relative; display: inline-block;">
                            <img src="{{ Storage::url($slider->image) }}" class="d-block w-100" alt="...">
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
                            </div>
                        </div>
                        <div class="carousel-caption d-block text-start" style="top: 25%; left: 8%;">
                            <h1 class="homeSlide fw-medium">
                                {{ $slider->heading }} <span
                                    style="color: var(--accent-color)">{{ $slider->heading_end }}</span>
                            </h1>
                            <p class="col-8 slidetext">{{ $slider->title }}
                            </p>
                            <a href="#location" class="btn btn-orange-normal">{{ __('sentence.location') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section>
        <div class="container ">
            <div class="row">
                <div class="col-3 mt-5" data-aos="fade-right">
                    <img src="{{ Storage::url(Settings::setting('slide.laft')) }}" class="img-fluid" alt="laft">
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-12 mb-2" data-aos="fade-up">
                            <img src="{{ Storage::url(Settings::setting('slide.laft_top')) }}" class="img-fluid"
                                alt="laft_top">
                        </div>
                        <div class="col-12 " data-aos="fade-down">
                            <img src="{{ Storage::url(Settings::setting('slide.laft_bottom')) }}" class="img-fluid"
                                alt="laft_bottom">
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-12 mb-2" data-aos="fade-right">
                            <img src="{{ Storage::url(Settings::setting('slide.right_top')) }}" class="img-fluid"
                                alt="right_top">
                        </div>
                        <div class="col-12" data-aos="fade-left">
                            <img src="{{ Storage::url(Settings::setting('slide.right_bottom')) }}" class="img-fluid"
                                alt="right_bottom">
                        </div>

                    </div>
                </div>
                <div class="col-3  mt-5" data-aos="fade-down">
                    <img src="{{ Storage::url(Settings::setting('slide.right')) }}" class="img-fluid" alt="right">
                </div>
            </div>
        </div>
    </section>
    <section id="location" class="menu section bg-transparent">

        <!-- Section Title -->
        <div class="container section-title text-center " data-aos="fade-up">
            <h2>{{ __('sentence.location') }}</h2>
            <p style="color: #E5D5BF">{{ __('sentence.locationtitle') }}</p>
        </div><!-- End Section Title -->


        <div class="container mb-3" data-default-filter="*" data-layout="masonry" data-sort="original-order">
            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6">
                    {{-- <form action="{{ route('location.store') }}" method="post" id="location-form">
                        @csrf --}}
                    <div class="input-group mb-3 text-center">
                        <input type="text" id="map_address_input"
                            class="form-control form-control-lg location text-center" placeholder="{{ __('sentence.enter_Location') }}"
                            aria-label="{{ __('sentence.enter_Location') }}" aria-describedby="button-addon2" name="location"
                            value="{{ session()->get('current_location') ?? '' }}">
                        <button class="btn btn-outline-orange" type="button" onclick="getCurrentLocation()"
                            id="location-button">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                        </button>
                        <button class="btn btn-outline-orange" id="checkDZ">ENTRÉE</button>

                    </div>
                    {{-- </form> --}}
                </div><!--  Item -->
            </div><!--  Container -->
        </div>

    </section><!-- / Section -->

    <x-user.restaurant :restaurants="$restaurants" />
</x-user>
@push('js')
    <script>
        $(document).ready(function() {
            $('#carouselExampleCaptions').carousel();
        });
    </script>
@endpush
