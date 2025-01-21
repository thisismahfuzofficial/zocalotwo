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

            <p><span class="description-title">Product Cart</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <table class="table">
                <tr class="align-middle">
                    <th class="col-md-1 text-center">Product</th>
                    <th class="col-2 text-center">Price</th>
                    <th class="col-2 text-center">Quantity</th>
                    <th class="col-2 text-end">Total</th>
                </tr>
                @foreach (Cart::getContent() as $item)
                    <tr class="align-middle ">
                        <td class="text-center">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $product->image ?? '' }}" class="img-fluid " alt="">
                                <a href="{{ url('/cart-destroy/' . $item->id) }}" class="btn btn-sm btn-dark fw-bold position-absolute top-0 end-0 me-1 mt-1">
                                    <i class="bi bi-x"></i>
                                </a>
                            </div>
                            <h3>Product name</h3>

                        </td>
                        <td class="text-center">
                            <div class="text-success"> $ {{ number_format($item->price, 2) }}</div>
                        </td>
                        <td class="text-center">
                            <form id="update-cart-form-{{ $item->id }}" method="post">
                                <div class="cart-product-quantity d-flex justify-content-center">
                                    <div class="cart-plus-minus d-flex ms-5 ps-5" style="border: 0px !important;">
                                        <div class="btnWidth">
                                            <!-- Decrease button -->
                                            <button type="button"
                                                class="dec decrease-btn qtybutton bg-transparent fw-bold fs-5"
                                                style="border: 0px !important;"
                                                onclick="updateQuantity('{{ $item->id }}', -1);">-</button>
                                        </div>

                                        <div class="btnWidth w-25">
                                            <!-- Quantity input -->
                                            <input type="text" value="{{ $item->quantity }}" name="quantity"
                                                class="cart-plus-minus-box quantityMobil2 w-75 text-center"
                                                id="product_quantity_{{ $item->id }}" min="1" placeholder="0"
                                                data-price="{{ $item->price }}" data-name="{{ $item->name }}"
                                                readonly>
                                        </div>

                                        <div class="btnWidth">
                                            <!-- Increase button -->
                                            <button type="button"
                                                class="inc increase-btn qtybutton bg-transparent fw-bold fs-5"
                                                style="border: 0px !important;"
                                                onclick="updateQuantity('{{ $item->id }}', 1);">+</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>

                        <td class="text-end">
                            <div class="text-success">$ {{ number_format($item->price * $item->quantity, 2) }} </div>
                        </td>

                    </tr>
                @endforeach
            </table>
            <div class="text-end">
                <a href="{{route('restaurant.checkout')}}" class="btn btn-danger ">Check Out</a>
            </div>
        </div>

    </section><!-- /Contact Section -->

    @push('js')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        <script>
            function updateQuantity(productId, change) {
                let quantityInput = document.getElementById(`product_quantity_${productId}`);
                let currentQuantity = parseInt(quantityInput.value);

                let newQuantity = currentQuantity + change;
                if (newQuantity < 1) return;
                quantityInput.value = newQuantity;

                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: newQuantity,
                    },
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        </script>
    @endpush
</x-main>
