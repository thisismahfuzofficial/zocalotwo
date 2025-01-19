<x-user>
    <br><br><br>
    <!-- Contact Section -->
    <section id="contact" class="contact section bg-transparent">

        <!-- Section Title -->
        <!-- Section Title -->
        <div class="container content mb-5  text-center" data-aos="fade-up">
            <h2 class="text-colour">{{__('sentence.loginwithus')}}</h2>
            <div class="d-flex gap-3 justify-content-center">
                <p class="fst-italic"> {{__('sentence.donthaveaaccount')}} </p>
                <a href="{{ route('register') }}">{{__('sentence.register')}} </a>
            </div>

        </div><!-- End Section Title -->


        <div class="container d-flex justify-content-center align-items-center " style="min-height: 40vh;"
            data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 w-100 justify-content-center ">
                <div class="col-lg-6 ">
                    <form action="{{ route('login') }}" method="post" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="200">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="{{__('sentence.youremail')}} "
                                    required="">
                            </div>
                            <div class="col-md-12">
                                <input type="password" name="password" class="form-control" placeholder="{{__('sentence.password')}} "
                                    required="">
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit">{{__('sentence.login')}} </button>
                            </div>
                        </div>
                    </form>
                </div><!-- End Contact Form -->
            </div>
        </div>

        <div class="mt-4" data-aos="fade-up" data-aos-delay="100">

            <div class="d-flex gap-3 justify-content-center">
                <p class="fst-italic">{{__('sentence.forgetpassword')}} </p>
                <a href="{{ route('password.request') }}">{{__('sentence.clickhere')}} </a>
            </div>
        </div>
    </section><!-- /Contact Section -->
</x-user>
