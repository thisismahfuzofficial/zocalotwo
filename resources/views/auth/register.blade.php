
<x-main>
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            {{-- <h2>Contact</h2> --}}
            <p><span class="description-title">Register</span></p>
            <div class="mt-3 text-center">
                <div>Already have an account ? <a href="{{ route('login') }}" class="fst-italic text-danger "><u>Login
                            Here</u></a></div>
            </div>
        </div><!-- End Section Title -->

        <div class="container " data-aos="fade-up" data-aos-delay="100">
            <div class="col-md-6 mx-auto">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="role" value="2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                    id="floatingInput" placeholder="name" name="name" value="{{ old('name') }}"
                                    required autocomplete="name" autofocus>
                                <label for="floatingInput">First Name</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control  @error('last_name') is-invalid @enderror"
                                    id="floatingInput" placeholder="name" name="last_name"
                                    value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                <label for="floatingInput">last Name</label>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control  @error('email') is-invalid @enderror"
                            id="floatingInput" placeholder="name@example.com" name="email" value="{{ old('email') }}"
                            required autocomplete="email">
                        <label for="floatingInput">Email address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingInput" placeholder="" name="password" required autocomplete="new-password">
                        <label for="floatingInput">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingInput" placeholder="" name="password_confirmation" required autocomplete="new-password">
                        <label for="floatingInput">Confirm Password</label>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger">Register</button>
                    </div>


                </form>
            </div>



        </div>

    </section><!-- /Contact Section -->
</x-main>
