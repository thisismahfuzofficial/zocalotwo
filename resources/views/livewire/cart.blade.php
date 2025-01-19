@php
    $firstItem = Cart::getContent()->first();
    $restaurant = $firstItem ? App\Models\Restaurant::find($firstItem->attributes->restaurent) : null;
@endphp
<div>
    @push('css')
        <style>
            .sushibtn {
                padding: 4px 3px !important;
                border: 1px solid var(--accent-color) !important;
                border-radius: 0px;
                color: #ffffff;
            }

            .sushibtn {
                padding: 4px 3px !important;
                border: 1px solid var(--accent-color) !important;
                border-radius: 0px;
                background-color: var(--accent-color);
                color: #ffffff;
            }

            .cart-plus-minus {
                display: flex;
            }

            .cart-product-remove-mobil {
                display: none !important;
            }

            @media (min-width: 360px) and (max-width: 740px) {
                .cart-plus-minus {
                    border: 0px !important;
                    width: 100% !important;
                    display: flex;
                }

                .btnWidth {
                    width: 33%;
                }

                .cart-product-info h4 a {
                    font-size: 12px !important;

                }

                .cart-product-remove {
                    display: none !important;
                }

                .quantityMobil {
                    width: 55px;
                }

                .cart-product-subtotal {
                    width: 76px !important;
                }

                .cart-plus-minus-box {
                    width: 100% !important;
                }

                .taxMobil {
                    width: 50px;
                }
                .cart-product-remove-mobil {
                display: block !important;
            }
            }

            @media (min-width: 768px) and (max-width: 1024px) {
                .cart-plus-minus {
                    border: 0px !important;
                    width: 70% !important;
                    display: flex;
                }

                .btnWidth {
                    width: 33%;
                }
            }

            @media (min-width: 540px) and (max-width: 720px) {
                .cart-product-remove-mobil {
                    display: block !important;
                }
            }
            @media (min-width: 412px) and (max-width: 914px) {
                .cart-product-remove-mobil {
                    display: block !important;
                }
            }
        </style>
    @endpush
    <section id="about" class="cart_section pb-5 bg-transparent">
        <div class="container section-title aos-init aos-animate pb-2 mt-4" data-aos="fade-up">
            <div class="">
                <a href="{{ route('restaurant.menu', ['slug' => $restaurant->slug]) }}" role="button"
                    class="btn sushibtn p-md-3 goback"> <i class="bi bi-chevron-left"></i> {{ __('sentence.menu') }}</a>
            </div>

            {{-- <h2>{{ __('sentence.cart') }}</h2> --}}
            <p style="color: #ffffff"></p>
        </div>
        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="cart_table  table-responsive">

                            <tbody class="table_body">
                                @forelse (Cart::getContent() as $item)
                                    @if (isset($item->attributes['product']))
                                        <tr>
                                            @if (isset($item->attributes['restaurent']))
                                                @php
                                                    $restuarant = App\Models\Restaurant::find(
                                                        $item->attributes['restaurent'],
                                                    );
                                                @endphp
                                                <td class="cart-product-image">
                                                    @php
                                                        $product = $item->attributes['product'];

                                                    @endphp
                                                    <a
                                                        href="{{ route('single.restaurant', ['restaurant' => $restuarant->slug, 'product' => $item->attributes['product']->id]) }}">
                                                        <img src="{{ $product->image ?? '' }}" alt="">
                                                    </a>

                                                </td>

                                                <td class="cart-product-info text-center">
                                                    <h4><a class="fw-lighter fs-4 text-uppercase mobilFontSize"
                                                            href="{{ route('single.restaurant', ['restaurant' => $restuarant->slug, 'product' => $item->attributes['product']->id]) }}"
                                                            style="color: #ffffff !important;">{{ $product->category->name }}
                                                            - {{ $item->name }}</a>
                                                        @if (isset($item->attributes['options']))
                                                            <p class="fw-light mt-2 fs-6">
                                                                {{ $item->attributes['options'] }}</p>
                                                        @endif
                                                    </h4>
                                                </td>
                                            @endif

                                            <td
                                                class="cart-product-quantity quantityMobil d-flex justify-content-center mt-3">
                                                <form id="update-cart-form-{{ $item->id }}" method="post">
                                                    <div class="cart-product-quantity d-flex justify-content-center">
                                                        <div class="cart-plus-minus" style="border: 0px !important;">
                                                            <div class="btnWidth">
                                                                <button class="dec decrease-btn qtybutton"
                                                                    style="border: 0px !important;"
                                                                    onclick="event.preventDefault(); updateQuantity('{{ $item->id }}', -1);">-</button>
                                                            </div>

                                                            <div class="btnWidth">
                                                                <input type="text" value="{{ $item->quantity }}"
                                                                    name="quantity"
                                                                    class="cart-plus-minus-box quantityMobil2"
                                                                    id="product_quantity_{{ $item->id }}"
                                                                    min="1" placeholder="0"
                                                                    data-price="{{ $item->price }}"
                                                                    data-name="{{ $item->name }}" readonly>
                                                            </div>

                                                            <div class="btnWidth">
                                                                <button class="inc increase-btn qtybutton"
                                                                    style="border: 0px !important;"
                                                                    onclick="event.preventDefault(); updateQuantity('{{ $item->id }}', 1);">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-center taxMobil">
                                                @if (isset($item->attributes['product']))
                                                    Tax:
                                                    <span>{{ Settings::itemTax($item->price, $item->attributes['tax'], $item->quantity) }}
                                                        Є</span>
                                                @endif
                                            </td>
                                            <td class="cart-product-subtotal text-center">
                                                {{ number_format($item->price * $item->quantity, 2) }} €

                                                <a class="cart-product-remove text-center d-block mt-2"
                                                    style="color: #ff883e !important;"
                                                    href="{{ url('/cart-destroy/' . $item->id) }}">{{ __('sentence.delete') }}
                                                </a>
                                                <a class="cart-product-remove-mobil text-center d-block mt-2"
                                                    style="color: #ff883e !important;"
                                                    href="{{ url('/cart-destroy/' . $item->id) }}"><i
                                                        class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @if (Cart::isEmpty())
        <a href="{{ route('restaurant.home') }}" class="checkout_btn">{{ __('sentence.gohome') }}</a>
    @else
        <section id="" class="extra_section pt-1 bg-transparent">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-md-12">
                        <div class="row text-center p-2">
                            @foreach ($extras as $extra)
                                <div class="col-md-2 col-sm-6 col-4 d-md-flex align-items-center subcart2 mt-3">
                                    <x-cart.extra :extra="$extra" :restuarant="$restuarant" :extraBucket="$extraBucket"
                                        :prices="$extraPrice" />
                                </div>
                            @endforeach
                            <p class="text-start mt-4" style="font-size: smaller; color: #ff883e;">WASABI / GINGEMBRE
                                sont toujours inclus avec les rolls. Si vous n'en souhaitez pas, merci de le préciser
                                dans la section << Informations supplémentaires>> de la page suivante</p>
                        </div>

                    </div>
                </div>


            </div>
        </section>
    @endif
</div>
@push('js')
    <script>
        function updateQuantity(productId, change) {
            // Get the current quantity
            let quantityInput = document.getElementById(`product_quantity_${productId}`);
            let currentQuantity = parseInt(quantityInput.value);

            // Calculate the new quantity
            let newQuantity = currentQuantity + change;
            if (newQuantity < 1) return; // Ensure the quantity doesn't go below 1

            // Update the quantity input field with the new value
            quantityInput.value = newQuantity;

            // Send an AJAX request to update the cart
            $.ajax({
                url: "{{ route('cart.update') }}", // Replace with your route
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    quantity: newQuantity,
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    // Handle the error
                }
            });
        }
    </script>
@endpush
