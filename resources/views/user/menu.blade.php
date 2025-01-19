@php
    $timeSelect = session()->get('delivery_time');
@endphp
<x-user>
    @push('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/menu.css') }}">

        <style>
            .modal-content {
                position: relative;
                display: flex;
                flex-direction: column;
                width: 100%;
                max-width: 417px !important;
                color: var(--bs-modal-color);
                pointer-events: auto;
                background-color: var(--bs-modal-bg);
                background-clip: padding-box;
                border: var(--bs-modal-border-width) solid var(--bs-modal-border-color);
                border-radius: var(--bs-modal-border-radius);
                outline: 0;
            }
        </style>
        <style>
            .category-slider {
                scrollbar-width: none;
                /* For Firefox */
                -ms-overflow-style: none;
                /* For Internet Explorer and Edge */
            }

            .category-slider::-webkit-scrollbar {
                display: none;
                /* For Chrome, Safari, and Opera */
            }

            .list-group {
                --bs-list-group-color: none;
                --bs-list-group-bg: none;
                --bs-list-group-border-color: none;
                --bs-list-group-border-width: none;
                --bs-list-group-border-radius: none;
                --bs-list-group-item-padding-x: none;
                --bs-list-group-item-padding-y: none;
                --bs-list-group-action-color: none;
                --bs-list-group-action-hover-color: none;
                --bs-list-group-action-hover-bg: none;
                --bs-list-group-action-active-color: none;
                --bs-list-group-action-active-bg: none;
                --bs-list-group-disabled-color: none;
                --bs-list-group-disabled-bg: none;
                --bs-list-group-active-color: none;
                --bs-list-group-active-bg: none;
                --bs-list-group-active-border-color: none;
                all: unset;
            }

            .category-link {
                border-radius: 0px;
            }

            .category-link.active {
                background-color: #ffffff;
                color: #000;
            }

            body {
                position: relative;
            }
        </style>
    @endpush
    <br><br>
    <div class="category-slider d-block d-md-none">
        <ul class="slider-wrapper list-group" id="categoriesScroll" data-bs-spy="scroll" data-bs-target="#categoriesScroll"
            data-bs-offset="100">
            @foreach ($categories as $category)
                @if ($category->childs->count() > 0)
                    @foreach ($category->childs as $child)
                        <li class="list-group-item">
                            <a href="#{{ $child->slug }}" class="category-link">{{ $child->name }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>

    {{-- <x-user.about /> --}}
    <section id="menu" class="menu section bg-transparent">

        <!-- Section Title -->
        <div class="ms-3 me-3" style="" data-aos="fade-up">
            <div class="row">
                <div class="section-title col-md-4">
                    <h2>{{ __('sentence.menu') }}</h2>
                    <p style="color: var(--default-color)">{{ $restaurant->name }}</p>
                </div>
                <div class="section-title col-md-5">
                    {{-- <h2 class="mb-2" style="font-size: 26px;">{{ __('sentence.take_away') }}</h2> --}}
                    {{-- <h6 style="color: color-mix(in srgb, var(--default-color), transparent 30%); margin-bottom: 0px ;"
                        hidden>
                        {{ __('sentence.current_location') }} : (40 to 60 Minutes)</h6> --}}

                    @if ($restaurant->delivery_option == 'both' || $restaurant->delivery_option == 'home_delivery')
                        <button class="Delivery" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><h2 class="mb-2" style="font-size: 26px;">{{ __('sentence.choose_delivery') }}</h2></button>
                            <p style="font-size:18px; color:#ff883e;">{{ session()->get('address') }}, {{ session()->get('postalCode') }}</p>
                    @endif
                </div>
                <div class="section-title col-md-3">
                    <form id="timeForm" action="{{ route('time_update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="" class="form-content mb-2">{{ __('sentence.current_delay') }} : (40  to 60
                            Minutes)</label>
                        <select name="TimeOption"
                            class="form-select selectpicker  bg-transparent text-light delivery-time"
                            data-container="body" onchange="submitTimeForm()">
                            @foreach ($timeSlots as $time)
                                <option value="{{ $time }}"
                                    {{ isset($timeSelect[0]) && $time == $timeSelect[0] ? 'selected' : '' }}>
                                    {{ $time }}</option>
                            @endforeach
                        </select>
                    </form>


                </div>

            </div>

        </div><!-- End Section Title -->




        <div class="container-fluid isotope-layout">
            <div class="row">
                <!-- Sidebar for larger screens -->
                <div class="col-md-3 col-sm-12 d-none d-md-block"
                    style="position: sticky; top: 150px; height: 100vh; overflow-y: auto;">
                    @foreach ($categories as $category)
                        <div class="accordion" id="accordionExample{{ $category->id }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree{{ $category->id }}" aria-expanded="false"
                                        aria-controls="collapseThree" style="color: var(--default-color);">
                                        {{ $category->name }}
                                    </button>
                                </h2>
                                @if ($category->childs->count() > 0)
                                    @foreach ($category->childs as $child)
                                        <div id="collapseThree{{ $child->parent_id }}"
                                            class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample{{ $child->parent_id }}">
                                            <a href="#{{ $child->slug }}" class="accordion-body"
                                                style="color: var(--default-color);">
                                                <div>{{ $child->name }}</div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Main Content Area -->
                <div class="col-md-9 col-sm-12 ps-0 pe-0">
                    <div class="row ms-0 me-md-5 scrollspy-example" data-bs-spy="scroll"
                        data-bs-target="#categoriesScroll" data-bs-offset="0" tabindex="0">
                        @foreach ($categories as $category)
                            @foreach ($category->childs as $child)
                                <div class="menu-header text-center pe-4" data-aos="fade-up" data-aos-delay="200">
                                    <h4 id="{{ $child->slug }}">{{ $child->name }}</h4>
                                    <hr class="ms-3" style="opacity: 1.25; margin-right: 39px;">
                                    <p class="mt-2 fst-italic">{{ $child->description }}</p>
                                </div>

                                <div class="row p-0">
                                    @foreach ($child->products as $product)
                                        <div class="col-md-3 col-sm-6 col-6 ps-0 pe-0">
                                            <x-viewProduct.product :restaurant="$restaurant" :product="$product" />
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- Modal -->
    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content " style="background-color: #000">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-colour" id="exampleModalLabel">
                        {{ __('sentence.enter_your_shipping_address') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group text-center">
                        <input type="text" id="map_address_input" name="location" value=""
                            class="form-control form-control-lg location text-center"
                            style="color: #ffffff; border-radius: 0px !important; background-color: black; border: 0px; padding-right: 0;"
                            placeholder="{{ __('sentence.enter_Location') }}" aria-label="{{ __('sentence.enter_Location') }}" aria-describedby="button-addon2">
                        <button class="btn bg-black border-0 btn-outline-orange" style="border-left: 0px"
                            type="button" onclick="getCurrentLocation()" id="location-button">
                            <i class="bi bi-geo-alt fs-4"></i>
                        </button>
                        <button id="checkDZ"class="btn btn-outline-orange"
                            style="background-color: var(--accent-color) !important; border-color: var(--accent-color) !important; color: #ffffff !important;">
                            ENTRÉE
                        </button>
                    </div>
                </div><!--  Item -->

            </div>
        </div>
    </div>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel" style="background: rgba(0, 0, 0, 0.5)">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel" style="background: rgba(0, 0, 0, 0.5)">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @foreach ($categories as $category)
                        <div class="accordion" id="accordionExample{{ $category->id }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree{{ $category->id }}"
                                        aria-expanded="false" aria-controls="collapseThree"
                                        style="color: var(--default-color);">
                                        {{ $category->name }}
                                    </button>
                                </h2>
                                @if ($category->childs->count() > 0)
                                    @foreach ($category->childs as $child)
                                        <div id="collapseThree{{ $child->parent_id }}"
                                            class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample{{ $child->parent_id }}">
                                            <a href="#{{ $child->name }}" class="accordion-body"
                                                style="color: var(--default-color);">
                                                <div>{{ $child->name }}</div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        @push('js')
            <script>
                function submitTimeForm() {
                    // Submit the form when an option is selected
                    document.getElementById('timeForm').submit();
                }
            </script>



            <script>
                document.querySelectorAll('.category-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
                        target: '#categoriesScroll'
                    });

                    // Function to scroll the categoriesScroll element to the active link
                    const scrollToActiveCategory = () => {
                        const activeLink = document.querySelector('#categoriesScroll .active');
                        if (activeLink) {
                            activeLink.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest',
                                inline: 'nearest'
                            });
                        }
                    };

                    // Scroll the categories when the user clicks on a category link
                    document.querySelectorAll('.category-link').forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            const targetId = this.getAttribute('href').substring(1);
                            const targetElement = document.getElementById(targetId);
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });

                            // Scroll the categories to keep the clicked link in view
                            scrollToActiveCategory();
                        });
                    });

                    // Scroll categories when a section becomes active (handled by scrollSpy)
                    document.body.addEventListener('activate.bs.scrollspy', function() {
                        scrollToActiveCategory();
                    });

                    // Manually trigger scrollSpy refresh on scroll
                    window.addEventListener('scroll', function() {
                        scrollSpy.refresh();
                    });
                });
            </script>
        @endpush
</x-user>
