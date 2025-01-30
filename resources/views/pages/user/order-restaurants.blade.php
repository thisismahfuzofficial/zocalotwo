<x-main>
    <style>
        .accordion-button:focus {
            box-shadow: none !important;
            /* Removes focus shadow */
        }

        .accordion-button:not(.collapsed) {
            box-shadow: none !important;
            /* Removes active shadow */
        }
    </style>
    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <p><span class="description-title">nearest restaurant</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="mb-5 ">
                <div class="d-flex justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <iframe style="width: 100%; height: 400px;"
                                src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q={{ $restaurant->latitude }},{{ $restaurant->longitude }}"
                                frameborder="0" allowfullscreen></iframe>
                        
                            <div class="card-body">
                                <h3 class="fw-bold text-danger text-center">
                                    {{ $restaurant->name }}
                                </h3>
                                <p><i class="bi bi-telephone"></i> <span>{{ $restaurant->number }}</span></p>
                                <p><i class="bi bi-envelope"></i> <span>{{ $restaurant->email }}</span></p>
                                <p><i class="bi bi-geo-alt"></i> <span>{{ $restaurant->address['post_code'] }},
                                        {{ $restaurant->address['city'] }}, {{ $restaurant->address['address'] }}</span>
                                </p>
                            </div>
                        </div>
                        
                    </div>

                </div>

            </div><!-- End Google Maps -->




        </div>

    </section><!-- /Contact Section -->
    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <p><span class="description-title">Our Menu</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="category-slider d-block d-md-none">
                <ul class="slider-wrapper list-group" id="categoriesScroll" data-bs-spy="scroll"
                    data-bs-target="#categoriesScroll" data-bs-offset="100">
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
                <div class="container-fluid isotope-layout">
                    <div class="row">
                        <!-- Sidebar for larger screens -->
                        <div class="col-md-3 col-sm-12 d-none d-md-block"
                            style="position: sticky; top: 150px; height: 100vh; overflow-y: auto;">
                            @foreach ($categories as $category)
                                <div class="accordion" id="accordionExample{{ $category->id }}">
                                    <div class="accordion-item border-danger">
                                        <div class="accordion-header h2">
                                            <button class="accordion-button collapsed " type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseThree{{ $category->id }}" aria-expanded="false"
                                                aria-controls="collapseThree" style="color: var(--default-color);">
                                                {{ $category->name }}
                                            </button>
                                        </div>
                                        @if ($category->childs->count() > 0)
                                            @foreach ($category->childs as $child)
                                                <div id="collapseThree{{ $child->parent_id }}"
                                                    class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionExample{{ $child->parent_id }}">
                                                    <a href="#{{ $child->slug }}" class="accordion-body"
                                                        style="color: var(--default-color);">
                                                        <div class="ps-4">{{ $child->name }}</div>
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
                                        <div class="menu-header text-center pe-4" data-aos="fade-up"
                                            data-aos-delay="200">
                                            <h4 id="{{ $child->slug }}">{{ $child->name }}</h4>
                                            <hr class="ms-3" style="opacity: 1.25; margin-right: 39px;">
                                            <p class="mt-2 fst-italic">{{ $child->description }}</p>
                                        </div>

                                        <div class="row p-0">
                                            @foreach ($child->products as $product)
                                                <div class="col-md-3 col-sm-6 col-6 ps-0 pe-0">
                                                    <div class="" data-aos="fade-up" data-aos-delay="200">
                                                        <div class="card mb-3"
                                                            style="background: transparent; border:none">
                                                            <div class="card-body">
                                                                <div class="text-center product-hover">
                                                                    {{-- <a
                                                                    href="{{ route('single.restaurant', ['restaurant' => $restaurant->slug, 'product' => $product]) }}"> --}}
                                                                    <img class="img-fluid slideImage"
                                                                        src="{{ $product->image ? $product->image : asset('niko/assets/img/menu/lobster-bisque.jpg') }}">
                                                                    </a>

                                                                    {{-- <h4 class="" style="">
                                                                    <a href="{{ route('single.restaurant', ['restaurant' => $restaurant->slug, 'product' => $product]) }}"
                                                                        style="color: #ff883e !important; !important; font-size: 15px !important; font-weight: 300 !important;">{{ $product->name }}</a>
                                                                </h4> --}}
                                                                    <div class="d-flex gap-3 justify-content-center">
                                                                        <div class="price-container">
                                                                            <p>{{ $product->allergenes }}</p>
                                                                            <h3 class=" price text-danger">
                                                                                {{ Settings::price($product->price) }}
                                                                            </h3>



                                                                            <form action="{{ route('cart.store') }}"
                                                                                method="post" class="add-button">
                                                                                @csrf
                                                                                <input type="hidden" name="quantity"
                                                                                    value="1">
                                                                                <input type="hidden" name="product_id"
                                                                                    value="{{ $product->id }}">
                                                                                <input type="hidden"
                                                                                    name="product_price"
                                                                                    value="{{ $product->price }}">
                                                                                <input type="hidden"
                                                                                    name="restaurent_id"
                                                                                    value="{{ $restaurant->id }}">
                                                                                @if ($product->status == 1)
                                                                                    <button type="submit"
                                                                                        class="bg-danger btn text-light"
                                                                                        style="font-size: 10px !important; ">
                                                                                        <i
                                                                                            class="bi bi-plus"></i>Add</button>
                                                                                @else
                                                                                    <button disabled
                                                                                        class="bg-danger btn text-light"
                                                                                        style=" font-size: 10px !important; ">
                                                                                        <i
                                                                                            class="bi bi-plus"></i>Out of Stock</button>
                                                                                @endif
                                                                            </form>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
            <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content " style="background-color: #000">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-colour" id="exampleModalLabel">
                                {{ __('sentence.enter_your_shipping_address') }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group text-center">
                                <input type="text" id="map_address_input" name="location" value=""
                                    class="form-control form-control-lg location text-center"
                                    style="color: #ffffff; border-radius: 0px !important; background-color: black; border: 0px; padding-right: 0;"
                                    placeholder="{{ __('sentence.enter_Location') }}"
                                    aria-label="{{ __('sentence.enter_Location') }}"
                                    aria-describedby="button-addon2">
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
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
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
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseThree{{ $category->id }}"
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

            </div>


        </div>

    </section><!-- /Contact Section -->

</x-main>
