<x-user>
    @push('css')
        <style>
            .form-select{
                font-size: 14px !important;
                padding: 10px 15px !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                color: var(--default-color) !important;
                background-color:
                    color-mix(in srgb, var(--background-color), transparent 50%) !important;
                border-color:
                    color-mix(in srgb, var(--accent-color), transparent 70%) !important;
            }
            .form-select:focus {
                border-color: var(--accent-color) !important;
            }
            input[type="file"] {
                font-size: 14px !important;
                padding: 10px 15px !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                color: var(--default-color) !important;
                background-color:
                    color-mix(in srgb, var(--background-color), transparent 50%) !important;
                border-color:
                    color-mix(in srgb, var(--accent-color), transparent 70%) !important;
            }

            input[type='file']:focus {
                border-color: var(--accent-color) !important;
            }
            input[type='file']::placeholder {
                color: var(--accent-color) !important;
            }
        </style>
    @endpush
    <br> <br> <br>
    <!-- Contact Section -->
    <section id="contact" class="contact section bg-transparent">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>{{ __('sentence.recruitments') }}</h2>
            <p>{{ __('sentence.join_the_central_sushi_team') }}</p>
        </div><!-- End Section Title -->



        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-4">


                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>{{ __('sentence.email') }}</h3>
                            <p>{{ Settings::setting('site.email') }}</p>
                        </div>
                    </div><!-- End Info Item -->
                </div>

                <div class="col-lg-8">
                    <form action="{{ route('recrutment.mail') }}" method="post" class="php-email-form"
                        data-aos="fade-up" data-aos-delay="200" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="{{ __('sentence.your_name') }}"
                                    required="">
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="{{ __('sentence.your_email') }}"
                                    required="">
                            </div>


                            <div class="col-md-6">
                                <select class="form-select mb-3"
                                    style="border: 1px solid var(--accent-color);" name="terget_position">
                                    <option selected>{{ __('sentence.target_position') }}</option>
                                    <option value="{{ __('sentence.versatile_delivery_person') }}">{{ __('sentence.versatile_delivery_person') }}  </option>
                                    <option value="{{ __('sentence.multipurpose_server') }}">{{ __('sentence.multipurpose_server') }} </option>
                                    <option value="{{ __('sentence.kitchen_assistant') }}">{{ __('sentence.kitchen_assistant') }} </option>
                                    <option value="{{ __('sentence.chef_sushi') }} ">{{ __('sentence.chef_sushi') }} </option>
                                    <option value="{{ __('sentence.manager') }}">{{ __('sentence.manager') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select mb-3"
                                    style="border: 1px solid var(--accent-color);" name="city">
                                    <option selected>{{ __('sentence.city') }}</option>
                                    <option value="dijon">Dijon</option>
                                    <option value="besancon">Besancon</option>
                                    <option value="belfort">Belfort</option>
                                </select>
                            </div>

                            <div class="col-md-12 ">
                                <div class="custom-file">
                                    <label for="fileInpute">{{ __('sentence.deposer_votre_cv_file') }}</label>
                                    <input type="file" id="fileInput" name="cv_file"
                                        class="form-control bg-transparent mt-2" placeholder="Your CV">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="d-xl-block user-logout-button mt-3">{{ __('sentence.submit') }}</button>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->
</x-user>
