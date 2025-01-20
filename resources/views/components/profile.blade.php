<x-main>
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title">
            <p><span class="description-title">
                @switch(Route::currentRouteName())
                    @case('user.dashboard') Profile @break
                    @case('user.dashboard.orderList') Order List @break
                    @default Dashboard
                @endswitch
            </span></p>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{route('user.dashboard')}}" class="info-item d-flex align-items-center aos-init aos-animate mb-3 py-2">
                        <div class="icon flex-shrink-0"> {{ substr(auth()->user()->name, 0, 1) }}</div>
                        <div>
                            <h3>{{ auth()->user()->name }}</h3>
                        </div>
                    </a>
                    <a href="{{route('user.dashboard.orderList')}}" class="info-item d-flex align-items-center aos-init aos-animate mb-3 py-2">
                        <i class=" icon bi bi-list-nested flex-shrink-0 "></i>
                        <div>
                            <h3>Order List</h3>
                        </div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                    </form>

                    <a href="#" class="info-item d-flex align-items-center aos-init aos-animate mb-3 py-2"
                        onclick="document.getElementById('logout-form').submit();">
                        <i class="icon bi bi-door-open flex-shrink-0"></i>
                        <div>
                            <h3>Logout</h3>
                        </div>
                    </a>

                </div>
                <div class="col-md-9">
                    {{$slot}}
                </div>
            </div>
        </div>
    </section>
</x-main>