<x-user>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    @endpush
    <br><br><br>
    <!-- Contact Section -->
    <section id="contact" class="contact section bg-transparent">

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-md-8 ">
                    <h3 class="text-colour mb-3" data-aos="fade-up" data-aos-delay="200">
                        {{ __('sentence.updateyourname') }}</h3>
                    <form method="POST" action="{{ route('user.update.name') }}" class="php-email-form"
                        data-aos="fade-up" data-aos-delay="200">
                        @csrf
                        <div class="row gy-4">

                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control capitalize-first"
                                    placeholder="{{ __('sentence.your_first_name') }}" required value="{{ ucfirst(auth()->user()->name) }}">
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="last_name" class="form-control capitalize-first"
                                    placeholder="{{ __('sentence.your_last_name') }}" required value="{{ ucfirst(auth()->user()->l_name) }}">
                            </div>

                            <div class="col-md-10">
                                <input type="email" class="form-control" name="email" placeholder="{{ __('sentence.your_email') }}"
                                    required="" value="{{ auth()->user()->email }}" disabled>

                            </div>



                            <div class="col-md-12 text-start">
                                <button type="submit">{{ __('sentence.update') }}</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-md-4 ">
                    <h3 class="text-colour mb-3" data-aos="fade-up" data-aos-delay="200">
                        {{ __('sentence.updateyourpassword') }}</h3>
                    <form method="POST" action="{{ route('user.update.password') }}" class="php-email-form"
                        data-aos="fade-up" data-aos-delay="200">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <input type="password" name="current_password" class="form-control"
                                    placeholder="{{ __('sentence.current_password') }}Current Password" required="">
                            </div>
                            <div class="col-md-12">
                                <input type="password" name="password" class="form-control" placeholder="{{ __('sentence.password') }}"
                                    required="">
                            </div>
                            <div class="col-md-12">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="{{ __('sentence.confirm_password') }}" required="">
                            </div>

                            <div class="col-md-12 text-start">
                                <button type="submit">{{ __('sentence.update') }}</button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>
        <div class="container mt-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-md-12 mt-4">
                <div class="d-flex justify-content-end">
                    <form action="{{ route('logout') }}" method="post" id="logout-form" class="php-email-form">
                        @csrf
                        <button type="submit"
                            class="d-xl-block user-logout-button">{{ __('sentence.logout') }}</button>
                    </form>
                </div>
            </div>

        </div>




    </section><!-- /Contact Section -->
</x-user>
