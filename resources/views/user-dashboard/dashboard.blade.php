{{-- <x-user>
    @push('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
            .btn-invoice {
                padding: 4px 8px;
                padding-left: 10px;
                padding-right: 10px;
                border: 1px solid #ba321c;
                color: var(--section-bg-1);
            }

            .logout {
                background: transparent;
                color: #ba321c;
            }
        </style>
    @endpush
    <br><br>
    <section id="about" class="cart_section pb-5 bg-transparent">
        <div class="container section-title aos-init aos-animate mt-4" data-aos="fade-up">
            <h2 style="color: var(--accent-color); font-weight: 600; font-family: var(--heading-font">{{ __('sentence.welcome') }}</h2>
            <p style="color: var(--accent-color); margin: 0; font-size: 36px; font-weight: 600; font-family: var(--heading-font">
                {{ __('sentence.our_dashboard') }}</p>
        </div>
    </section>
    <!-- WISHLIST AREA START -->
    <div class="liton__wishlist-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- PRODUCT TAB AREA START -->
                    <div class="ltn__product-tab-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="ltn__tab-menu-list mb-50">
                                        <div class="nav">
                                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_1_1">{{ __('sentence.dashboard') }}
                                                <i class="bi bi-house-fill fs-4"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_2">{{ __('sentence.orders') }} <i class="bi bi-file-earmark-text-fill fs-4"></i></a>
                                           
                                            <a data-bs-toggle="tab" href="#liton_tab_1_5">{{ __('sentence.account_details') }}<i class="bi bi-person-circle fs-4"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_4">{{ __('sentence.password_update') }} <i class="bi bi-person-fill-lock fs-4"></i></a>
                                            <form action="{{ route('logout') }}" method="post" id="logout-form"
                                                class="php-email-form"
                                                style="height: 51px; display: flex;">
                                                @csrf
                                                <button type="submit" style="width: 100%; align-items: center;" class="logout d-flex justify-content-between me-3 ms-3"><div class="">{{ __('sentence.logout') }} </div> <div class=""><span><i class="bi bi-box-arrow-left fs-4"></i></span></div></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="liton_tab_1_1">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>{{ __('sentence.dashboad_short_description') }}</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_1_2">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="table-responsive">
                                                    @if ($orders->count() > 0)
                                                        <table class="table">
                                                            <thead class="order"
                                                                style="background-color: #ba321c !important;">
                                                                <tr style="border:1px solid #ba321c !important;">
                                                                    <th>{{ __('sentence.order_id') }}</th>
                                                                    <th>{{ __('sentence.date') }}</th>
                                                                    <th>{{ __('sentence.time') }}</th>
                                                                    <th>{{ __('sentence.total') }}</th>
                                                                    <th>{{ __('sentence.invoice') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="order"
                                                                style="border: 1px solid #ba321c !important;">
                                                                @foreach ($orders as $key => $order)
                                                                    <tr class="">
                                                                        <td class="">{{ $order->id }}</td>
                                                                        <td class="">{{ $order->created_at->format('d-M-Y') }}</td>
                                                                        <td class="">
                                                                            {{ $order->time_option}}
                                                                        </td>
                                                                        <td class="">{{ $order->total }}€</td>
                                                                        <td class="text-center">
                                                                            @if ($order->payment_status == 'failed')
                                                                               <span class="text-danger fw-bold">{{ __('sentence.order_cancelled') }}</span> <br>
                                                                               <small>({{ __('sentence.payment_failed') }})</small>
                                                                            @else
                                                                                <a href="{{ route('invoice', $order) }}"
                                                                                class="btn btn-invoice ">{{ __('sentence.invoice') }}</a>
                                                                            @endif
                                                                            
                                                                            <!-- Positioned to the right -->
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <div class="container " data-aos="fade-up" data-aos-delay="100">
                                                            <h2 class="text-colour text-center fst-italic">{{ __('sentence.please_place_order_to_viev_orders') }}</h2>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="liton_tab_1_5">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>{{ __('sentence.the_following_addresses_will_be_used_on_the_checkout_page_by_default') }}
                                                </p>
                                                <div class="ltn__form-box">
                                                    <form method="POST" action="{{ route('user.update.name') }}"
                                                        class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                                                        @csrf
                                                        <div class="row gy-4">

                                                            <div class="col-md-6">
                                                                <input type="text" name="name"
                                                                    class="form-control capitalize-first"
                                                                    placeholder="{{ __('sentence.your_first_name') }}" required
                                                                    value="{{ ucfirst(auth()->user()->name) }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="last_name"
                                                                    class="form-control capitalize-first"
                                                                    placeholder="{{ __('sentence.your_last_name') }}" required
                                                                    value="{{ ucfirst(auth()->user()->l_name) }}">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <input type="email" class="form-control"
                                                                    name="email" placeholder="{{ __('sentence.your_email') }}"
                                                                    required="" value="{{ auth()->user()->email }}"
                                                                    disabled>

                                                            </div>

                                                            <div class="col-md-6">
                                                                <input type="text" name="address"
                                                                    class="form-control" placeholder="{{ __('sentence.your_address') }}"
                                                                    value="{{ ucfirst(auth()->user()->address) }}"
                                                                    required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="city"
                                                                    class="form-control" placeholder="{{ __('sentence.your_city') }}"
                                                                    value="{{ ucfirst(auth()->user()->city) }}"
                                                                    required="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="post_code"
                                                                    class="form-control" placeholder="{{ __('sentence.your_post_code') }}"
                                                                    value="{{ ucfirst(auth()->user()->post_code) }}"
                                                                    required="">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <input type="number" id="number_type" name="phone"
                                                                    class="form-control"
                                                                    placeholder="{{ __('sentence.your_phone_number') }}"
                                                                    value="{{ ucfirst(auth()->user()->phone) }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="house"
                                                                    class="form-control" placeholder="{{ __('sentence.your_house') }}"
                                                                    value="{{ ucfirst(auth()->user()->house) }}"
                                                                    required="">
                                                            </div>


                                                            <div class="col-md-12 text-start">
                                                                <button id="update"
                                                                    type="submit">{{ __('sentence.update') }}</button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="liton_tab_1_4">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                 <div class="ltn__form-box">
                                                    <form method="POST" action="{{ route('user.update.password') }}"
                                                        class="php-email-form" data-aos="fade-up"
                                                        data-aos-delay="200">
                                                        @csrf
                                                        <div class="row gy-4">
                                                            <div class="col-md-12">
                                                                <input type="password" name="current_password"
                                                                    class="form-control"
                                                                    placeholder="{{ __('sentence.current_password') }}" required="">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <input type="password" name="password"
                                                                    class="form-control" placeholder="{{ __('sentence.password') }}"
                                                                    required="">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <input type="password" name="password_confirmation"
                                                                    class="form-control"
                                                                    placeholder="{{ __('sentence.confirm_password') }}" required="">
                                                            </div>

                                                            <div class="col-md-12 text-start">
                                                                <button id="update_pass"
                                                                    type="submit">{{ __('sentence.update') }}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PRODUCT TAB AREA END -->
                </div>
            </div>
        </div>
    </div>
</x-user> --}}
<x-profile>

    <form action="{{ route('user.update.name') }}" method="Post" class=" mt-0" data-aos="fade-up" data-aos-delay="200"
        style="background-color: var(--surface-color);
box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
padding: 30px;">
        @csrf
        <div class="row gy-4">
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="last_name" class="form-control" value="{{ auth()->user()->l_name }}"
                    required>
            </div>

            <div class="col-md-12">
                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" readonly>
            </div>
            <div class="col-md-12">
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="**********"
                        aria-label="Password" disabled>
                    <a class="btn btn-outline-danger rounded-0" id="button-addon2" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Update</a>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </div>
    </form>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Update Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('user.update.password') }}" method="POST">
                @csrf
                <div class="form-floating my-3">
                    <input type="password" class="form-control @error('currentPassword') is-invalid @enderror"
                        id="currentPassword" placeholder="Current Password" name="currentPassword" required>
                    <label for="currentPassword">Current Password</label>
                    @error('currentPassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating my-3">
                    <input type="password" class="form-control @error('newPassword') is-invalid @enderror"
                        id="newPassword" placeholder="New Password" name="newPassword" required>
                    <label for="newPassword">New Password</label>
                    @error('newPassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating my-3">
                    <input type="password" class="form-control @error('newPassword_confirmation') is-invalid @enderror"
                        id="newPassword_confirmation" placeholder="Confirm Password" name="newPassword_confirmation"
                        required>
                    <label for="newPassword_confirmation">Confirm Password</label>
                    @error('newPassword_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-outline-danger">Update Password</button>
            </form>


        </div>
    </div>
</x-profile>
