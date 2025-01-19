<?php $restaurantNames = App\Models\Restaurant::latest()->get(); ?>
<style>
    .cartIcon {
        width: 30px;
    }
</style>
<header id="header" class="header fixed-top">
    <div class="branding d-flex align-items-cente">

        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="{{ route('restaurant.home') }}" class="logo d-flex align-items-center me-auto me-xl-0">

                <img src="{{ Settings::setting('site.logo') ? Storage::url(Settings::setting('site.logo')) : asset('logo/mainLogo.png') }}"
                    alt="" class="img-fluid">

            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li class="mobilNav"><a href="{{ route('restaurant.home') }}"
                            class="active">{{ __('sentence.home') }}<br></a></li>
                    <li><a href="{{ Settings::setting('pdf.file') }}" target="_blank">{{ __('sentence.themap') }}</a>
                    </li>
                    <li class="dropdown"><a
                            href="{{ route('user.restaurants') }}"><span>{{ __('sentence.restaurants') }}</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            @foreach ($restaurantNames as $restaurant)
                                @if ($restaurant->status == '1')
                                    <li><a
                                            href="{{ route('restaurant.menu', $restaurant->slug) }}">{{ $restaurant->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <li><a href="{{ route('restaurant.recruitment') }}">{{ __('sentence.recruitment') }}</a></li>
                    <li><a href="{{ route('restaurant.contact') }}">{{ __('sentence.contact') }}</a></li>

                    <li class="d-xl-none">
                        @if (auth()->check())
                            <a href="{{ route('user.dashboard') }}"
                                style="color: var(--accent-color)">{{ __('sentence.dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}"
                                style="color: var(--accent-color)">{{ __('sentence.login') }}</a>
                        @endif
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <div class="d-xl-flex d-none">

                <a class="fs-4 " href="{{ route('restaurant.cart') }}">
                    <img class="cartIcon" src="{{ asset('icon/cart.png') }}" alt="">
                    <span class="fw-bold custom-cart  ">{{ Cart::getTotalQuantity() }}</span></a>
                @if (auth()->check())
                    <a class="d-xl-block" href="{{ route('user.dashboard') }}">
                        <img class="cartIcon" src="{{ asset('icon/user.png') }}" alt="">
                    </a>
                @else
                    <a class="" href="{{ route('login') }}" style="margin: 0 20px;">
                        <img class="cartIcon" src="{{ asset('icon/user.png') }}" alt="">
                    </a>
                @endif
            </div>
            <div class="d-xl-none ">

                <a class="fs-4 " href="{{ route('restaurant.cart') }}">
                    <img class="cartIcon" src="{{ asset('icon/cart.png') }}" alt="">
                    <span class="fw-bold custom-cart  ">{{ Cart::getTotalQuantity() }}</span>
                </a>


                @if (auth()->check())
                    <a class="d-xl-block" href="{{ route('user.dashboard') }}">
                        <img class="cartIcon" src="{{ asset('icon/user.png') }}" alt="">
                    </a>
                @else
                    <a class="" href="{{ route('login') }}">
                        <img class="cartIcon" src="{{ asset('icon/user.png') }}" alt="">
                    </a>
                @endif

            </div>
        </div>

    </div>

</header>
