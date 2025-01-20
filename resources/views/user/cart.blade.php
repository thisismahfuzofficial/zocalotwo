{{-- <x-user>
    @php
        $firstItem = Cart::getContent()->first();
        $restaurant = $firstItem ? App\Models\Restaurant::find($firstItem->attributes->restaurent) : null;
        // $zone = $restaurant ? $restaurant->zones->get() : null;
    @endphp
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
        <style>
            .cart_submit {
                background-color: var(--accent-color);
                border: none;
                color: var(--heading-color);
                border-radius: 4px;
                font-size: small;
            }

            .nav-tabs .nav-link {
                margin-bottom: 0 !important;
                border: 0px !important;
                border-top-left-radius: 0 !important;
                border-top-right-radius: 0 !important;
            }
            
        </style>
        @livewireStyles
    @endpush

    <livewire:cart />
    <x-cart.slider :relatedProducts="$relatedProducts"/>

    @push('js')
        @livewireScripts
        <script>
            // function changeQuantity(change, id, price, name) {
            //     const quantityInput = document.getElementById(`extra_quantity_${id}`);
            //     const currentQuantity = Math.max(0, parseInt(quantityInput.value) + change);

            //     quantityInput.value = currentQuantity;
            //     document.getElementById(`price_${id}`).value = `${(currentQuantity * price).toFixed(2)}€`;

            //     // Update hidden form fields
            //     document.getElementById(`form_quantity_${id}`).value = currentQuantity;
            //     // document.getElementById(`form_price_${id}`).value = currentQuantity * price;

            //     // Enable or disable the "Add Cart" button based on the quantity
            //     const addButton = document.getElementById(`add_cart_button_${id}`);
            //     addButton.disabled = currentQuantity === 0;
            // }
        </script>


      
    @endpush

</x-user> --}}
<x-main>
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            {{-- <h2>Contact</h2> --}}
            <p><span class="description-title">Product Cart</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <table class="table">
                <tr class="align-middle">
                    <th class="col-md-1 text-center">Product</th>
                    <th class="col-2 text-center">Price</th>
                    <th class="col-2 text-center">Quantity</th>
                    <th class="col-2 text-center">Total</th>
                </tr>
                <tr class="align-middle ">
                    <td class="text-center">
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('assets/img/menu/menu-item-4.png') }}" class="img-fluid " alt="">
                            <button class="btn btn-sm btn-dark fw-bold position-absolute top-0 end-0 me-1 mt-1">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <h3>Product name</h3>

                    </td>
                    <td class="text-center">
                        <div class="text-success">$10.00</div>
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control">
                    </td>
                    <td class="text-center">
                        <div class="text-success">$10.00</div>
                    </td>

                </tr>
                <tr class="align-middle ">
                    <td class="text-center">
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('assets/img/menu/menu-item-5.png') }}" class="img-fluid " alt="">
                            <button class="btn btn-sm btn-dark fw-bold position-absolute top-0 end-0 me-1 mt-1">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <h3>Product name</h3>
                    </td>
                    <td class="text-center">
                        <div class="text-success">$10.00</div>
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control">
                    </td>
                    <td class="text-center">
                        <div class="text-success">$10.00</div>
                    </td>

                </tr>
                <tr class="align-middle ">
                    <td class="text-center">
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('assets/img/menu/menu-item-6.png') }}" class="img-fluid " alt="">
                            <button class="btn btn-sm btn-dark fw-bold position-absolute top-0 end-0 me-1 mt-1">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <h3>Product name</h3>
                    </td>
                    <td class="text-center">
                        <div class="text-success">$10.00</div>
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control">
                    </td>
                    <td class="text-center">
                        <div class="text-success">$10.00</div>
                    </td>


                </tr>
            </table>
            <div class="text-end">
                <a href="" class="btn btn-danger ">Check Out</a>
            </div>
        </div>

    </section><!-- /Contact Section -->

</x-main>
