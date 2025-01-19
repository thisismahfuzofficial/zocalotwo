<x-layout>
    {{-- <div id="reports-view"></div>
    @viteReactRefresh
    @vite('resources/js/app.js') --}}
    <div class="card border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <form method="GET" action="">
                        <div class="row">
                            
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3 form-focus">
                                    <label class="focus-label">Restaurant</label>
                                    <select name="restaurant" class="select form-control floating">
                                        <option value="">All Restaurant</option>
                                        @foreach ($restaurants as $key => $restaurant)
                                            <option value="{{ $key }}" {{ request('restaurant') == $key ? 'selected' : '' }}>
                                                {{ $restaurant }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3 form-focus">
                                    <label class="focus-label">From</label>
                                    <div class="cal-icon">
                                        <input name="from_date" class="form-control" type="date" value="{{ request()->from_date }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3 form-focus">
                                    <label class="focus-label">To</label>
                                    <div class="cal-icon">
                                        <input name="to_date" class="form-control" type="date" value="{{ request()->to_date }}">
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-6 col-md-2" style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-success w-100">Rechercher</button>
                                </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-2">
                    <form method="get" action="{{ route('orders.export') }}">
                        <div class="row">
                            <div class="col-sm-6 col-md-12" style="margin-top: 20px;">
                                <input type="hidden" name="status" value="{{ request()->status }}">
                                <input type="hidden" name="restaurant" value="{{ request()->restaurant }}">
                                <input type="hidden" name="from_date" value="{{ request()->from_date }}">
                                <input type="hidden" name="to_date" value="{{ request()->to_date }}">
                                <button type="submit" style="width: 100%;" class="btn btn-primary">Export to
                                    Excel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-around">
                                <h6 class="m-0">Montant total</h6>
                                <p class="m-0"><svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 24 24" aria-hidden="true" height="20" width="20"
                                        xmlns="http://www.w3.org/2000/svg" style="color: rgb(150, 145, 145);">
                                        <path fill-rule="evenodd"
                                            d="M16.72 7.72a.75.75 0 011.06 0l3.75 3.75a.75.75 0 010 1.06l-3.75 3.75a.75.75 0 11-1.06-1.06l2.47-2.47H3a.75.75 0 010-1.5h16.19l-2.47-2.47a.75.75 0 010-1.06z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </p>
                                <h6>{{ Settings::price($totalAmount / 100) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-around">
                                <h6 class="m-0">Total des commandes</h6>
                                <p class="m-0"><svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 24 24" aria-hidden="true" height="20" width="20"
                                        xmlns="http://www.w3.org/2000/svg" style="color: rgb(150, 145, 145);">
                                        <path fill-rule="evenodd"
                                            d="M16.72 7.72a.75.75 0 011.06 0l3.75 3.75a.75.75 0 010 1.06l-3.75 3.75a.75.75 0 11-1.06-1.06l2.47-2.47H3a.75.75 0 010-1.5h16.19l-2.47-2.47a.75.75 0 010-1.06z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </p>
                                <h6>{{ $totalOrder }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-around">
                                <h6 class="m-0">Clients totaux</h6>
                                <p class="m-0"><svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 24 24" aria-hidden="true" height="20" width="20"
                                        xmlns="http://www.w3.org/2000/svg" style="color: rgb(150, 145, 145);">
                                        <path fill-rule="evenodd"
                                            d="M16.72 7.72a.75.75 0 011.06 0l3.75 3.75a.75.75 0 010 1.06l-3.75 3.75a.75.75 0 11-1.06-1.06l2.47-2.47H3a.75.75 0 010-1.5h16.19l-2.47-2.47a.75.75 0 010-1.06z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </p>
                                <h6>{{ $totalCustomar }}</h6>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6>Meilleurs clients</h6>
                                <p class="pe-4">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 32 32" height="20" width="20"
                                        xmlns="http://www.w3.org/2000/svg" style="color: rgb(150, 145, 145);">
                                        <path
                                            d="M 15 4 L 15 24.0625 L 10.71875 19.78125 L 9.28125 21.1875 L 16 27.90625 L 22.71875 21.1875 L 21.28125 19.78125 L 17 24.0625 L 17 4 Z">
                                        </path>
                                    </svg>
                                </p>
                            </div>


                            @foreach ($topCustomers as $customer)
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="text-uppercase mb-2"
                                        style="font-size: 12px">{{ $customer->customer->name }}</a>
                                    <a href="#"
                                        class="mb-2">{{ Settings::price($customer->total_spent / 100) }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6>Produits les plus vendus</h6>
                                <p class="pe-4">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 32 32" height="20" width="20"
                                        xmlns="http://www.w3.org/2000/svg" style="color: rgb(150, 145, 145);">
                                        <path
                                            d="M 15 4 L 15 24.0625 L 10.71875 19.78125 L 9.28125 21.1875 L 16 27.90625 L 22.71875 21.1875 L 21.28125 19.78125 L 17 24.0625 L 17 4 Z">
                                        </path>
                                    </svg>
                                </p>
                            </div>
                            @foreach ($topSellingProducts as $Topproduct)
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="text-uppercase mb-2" style="font-size: 12px">
                                        {{ $Topproduct->name }} <br>
                                        <span class="mt-1"
                                            style="color: rgb(108, 117, 125); font-size: 10px; font-weight: 700;"
                                            class="text-uppercase">
                                            ({{ $Topproduct->category_name ?? 'No Category' }})
                                        </span>
                                    </a>
                                    @php
                                        $totalPrice = ($Topproduct->total_quantity * $Topproduct->price) / 100;
                                    @endphp
                                    <a href="#">{{ Settings::price($totalPrice) }}</a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('script')
    @endpush


</x-layout>
