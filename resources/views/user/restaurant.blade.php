<x-main>
    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <p><span class="description-title">We are located at</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="mb-5 ">
                <div class="row ">
                    @foreach ($restaurants as $restaurant)
                        <div class="col-md-4 mt-3">
                            <div class="card">

                                <iframe style="width: 100%; height: 200px;"
                                    src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q={{ $restaurant->latitude }},{{ $restaurant->longitude }}"
                                    frameborder="0" allowfullscreen=""></iframe>

                                <div class="card-body">
                                    <h3 class="fw-bold text-danger text-center">
                                        {{ $restaurant->name }}
                                    </h3>
                                    <p><i class="bi bi-telephone"></i> <span>{{ $restaurant->number }}</span></p>
                                    <p><i class="bi bi-envelope"></i> <span>{{ $restaurant->email }}</span></p>
                                    {{-- <p><i class="bi bi-geo-alt"></i> <span>{{ $restaurant->address }}</span></p> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div><!-- End Google Maps -->




        </div>

    </section><!-- /Contact Section -->

</x-main>
