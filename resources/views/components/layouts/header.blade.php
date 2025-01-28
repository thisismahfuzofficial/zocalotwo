@push('styles')
    <style>
        .custom-cart {
            font-size: 0.75rem;
            padding: 0.2em 0.4em;
            border-radius: 50%;
        }
    </style>
@endpush

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="{{ route('restaurant.home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{ asset('assets/images/logo.webp') }}" alt="">
        </a>
        <nav id="navmenu" class="navmenu ">

            <ul>
                <li><a href="{{ route('restaurant.home') }}" class="active">Home<br></a></li>
                <li><a href="{{ route('user.restaurants') }}">Restaurants</a></li>
                <li><a href="{{ route('page.chef') }}">Our Chefs</a></li>
                <li><a href="#">Catering</a></li>
                <li><a href="{{route('restaurant.contact')}}">Contact</a></li>

                <a class="btn-getstarted d-block" href="{{ route('page.order-online') }}">Order Online</a>
                @auth

                    <li class="d-none d-md-block"><a href="{{ route('user.dashboard') }}"><i
                                class="bi bi-person-circle fs-5"></i></a></li>
                @else
                    <li class="d-none d-md-block"><a href="{{ route('login') }}"><i
                                class="bi bi-person-circle fs-5"></i></a></li>
                @endauth

                <li class="d-none d-md-block">
                    <a class="position-relative d-inline-block"
                        href="{{ Cart::getTotalQuantity() > 0 ? route('restaurant.cart') : route('page.order-online') }}"
                        style="text-decoration: none;">
                        <i class="bi bi-bag fs-5 bg-light"></i>
                        <span
                            class="fw-bold custom-cart position-absolute top-0 start-100 translate-middle badge bg-danger">
                            {{ Cart::getTotalQuantity() }}
                        </span>
                    </a>
                </li>


                <li class="d-block d-md-none"><a href="#">Cart : <span class="badge bg-danger">0</span></a></li>
                <li class="d-block d-md-none"><a href="#">Profile</a></li>

            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list "></i>

        </nav>

    </div>
</header>
