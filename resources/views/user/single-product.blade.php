<x-user>
    @push('css')
        <style>
            :root {
                --primary-color: #e4d4bf;
                --sec-color: #ff883e;
            }

            #option-select:focus {
                box-shadow: none !important;
                outline: none !important;
            }

            .selectpicker {
                border: 1px solid var(--accent-color);
                background-color: color-mix(var(--background-color), transparent 50%);
                border-radius: 0;
            }

            .selectpicker:focus {
                border: 1px solid var(--accent-color) !important;
            }

            .sushibtn {
                color: var(--primary-color);
                background-color: transparent;
                border: 1px solid var(--accent-color);
                padding: 10px 20px 10px 20px;
                font-size: 18px;
            }

            .sushibtn:hover {
                color: var(--primary-color);
                background-color: var(--accent-color);
                padding: 10px 20px 10px 20px;
                font-size: 18px;
            }

            .sidept {
                background-color: transparent;
                height: 100%;
            }

            .pbtn {
                background-color: transparent;
                padding: 5px;
                border-radius: 0px;
                color: #fff;
            }

            .decrease-btn {
                border: none;
            }

            .increase-btn {
                border: none;
            }

            input[type='text'] {
                width: 50px;
                height: 100%;
                padding-left: 20px;
                border: none;
                background-color: transparent;
                color: #fff;
            }

            .singlePrice {
                color: var(--sec-color);
                font-size: 2rem;
            }

            .bottomTitle {
                font-size: 0.8rem !important;
            }

            @media (min-width: 360px) and (max-width: 740px) {
                .singlePrice {
                    color: var(--sec-color);
                    font-size: 2rem;
                    text-align: center;
                }

                #product-price {
                    text-align: center;
                }

                .submitBtn {
                    text-align: center;
                }

                .bottomTitle {
                    font-size: 12px !important;
                }
            }

            @media (min-width: 820px) and (max-width: 1180px) {
                .mobil {
                    display: flow !important;
                }

                #product-price {
                    width: 100%;
                }

                .bottomTitle {
                    font-size: 12px !important;
                }
            }

            .BackBtn {
                color: var(--primary-color);
                background-color: transparent;
                border: 1px solid var(--accent-color);
                padding: 4px 8px !important;
                border-radius: 0px;
            }

            .BackBtn:hover {
                color: var(--primary-color);
                padding: 4px 8px !important;
                background-color: var(--accent-color);
            }
        </style>
    @endpush
    <br>
    <br>
    <!-- product  Section -->
    <section id="about" class="about section bg-transparent pb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4 ms-3">
                        <button onclick="history.back()"
                            class="btn BackBtn p-md-3 goback"> <i
                                class="bi bi-chevron-left"></i>{{ __('sentence.menu') }}</button>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-5 d-flex" style="justify-content: center;">
                            <div class="" style="width: 250px; height: 250px;">
                                <div style="position: relative;">
                                    <img style="width: 250px; height: 250px; object-fit: cover;"
                                        src="{{ $product->image ? $product->image : asset('niko/image/restaurant.jpg') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <h2 class="mb-3 singlePrice fs-3 mt-3">{{ $product->name }}
                            </h2>
                            <form action="{{ route('cart.store') }}" method="post" id="cart-form">
                                @csrf
                                <div class="d-md-flex mobil">
                                    <h2 class="col-md-2" id="product-price">{{ Settings::price($product->price) }}</h2>

                                    @if ($productOption->count() !== 0)
                                        <div class="col-md-6">
                                            <select class="form-select selectpicker  mb-3 text-colour" name="option_id"
                                                id="option-select" required>
                                                @foreach ($productOption as $option)
                                                    <option value="{{ $option->id }}"
                                                        data-price="{{ $option->option_price }}">
                                                        {{ $option->option_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>

                                <div class="submitBtn">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="restaurent_id" value="{{ $restaurant->id }}">
                                    <input type="hidden" name="options" value="" id="options">
                                    @if ($product->status == 1)
                                        <button type="submit" class="sushibtn mt-3" id="add-to-cart-btn"
                                            style="">{{ __('sentence.addtocart') }}</button>
                                    @else
                                        <button disabled class="sushibtn mt-3"
                                            style="">{{ __('sentence.out_of_stock') }}</button>
                                    @endif

                                </div>
                            </form>
                            <div class="row mt-5">
                                <div class="col-md-6 col-sm-6 col-6 pe-0">
                                    <p class="text-center txtmob">{{ __('sentence.composition') }}</p>
                                    <hr class="" style="opacity: 1.25;">
                                    @if ($product->flavor_status == 1)
                                        @php
                                            $maxTotal = $product->flavor_total;
                                            $flavors = json_decode($product->flavors, true);
                                        @endphp
                                        <p class="text-center text-md-start">{{ __('sentence.select_your_item') }}
                                            {{ $maxTotal }} {{ __('sentence.the_flavors') }}
                                        </p>
                                        @foreach ($flavors as $flavor)
                                            <div class="flavor-item d-flex text-center">
                                                <label class="w-50 mb-2"
                                                    for="flavor_{{ $flavor['id'] }}">{{ $flavor['name'] }}</label>
                                                <div class="quantity-controls d-flex w-50 mb-2">
                                                    <button type="button"
                                                        class="decrease-btn border-0 bg-transparent text-light ms-4"
                                                        data-flavor="{{ $flavor['id'] }}">-</button>
                                                    <input type="text" name="flavors[{{ $flavor['id'] }}]"
                                                        id="flavor_{{ $flavor['id'] }}" value="0" min="0"
                                                        class="flavor-quantity-input w-25 border-0 bg-transparent text-light text-center"
                                                        readonly>
                                                    <button type="button"
                                                        class="increase-btn border-0 bg-transparent text-light ps-0"
                                                        data-flavor="{{ $flavor['id'] }}">+</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center border-end pe-2">{!! $product->composition ?? '' !!}</p>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-6 col-6 ps-0">
                                    <p class="text-center txtmob">{{ __('sentence.allergenes') }}</p>
                                    <hr class="" style="opacity: 1.25;">
                                    <p class="text-center txtmob">{!! $product->allergenes !!}</p>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12">
                                    <p class="text-left bottomTitle">{{ $product->text }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //Please select a total of 4 items for the 32 pieces product or 3 items for the 24 pieces product --}}
    </section>

    @push('js')
        <script>
            document.getElementById('option-select').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');

                if (price) {
                    document.getElementById('product-price').textContent = parseFloat(price).toFixed(2) + '€';
                } else {
                    // Fallback to the original product price if no option is selected
                    document.getElementById('product-price').textContent = '{{ number_format($product->price, 2) }}€';
                }
            });
        </script>

        @if ($product->flavor_status == 1)
            <script>
                const maxQuantity = "{{ $maxTotal }}";


                document.querySelectorAll('.increase-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const flavorId = this.getAttribute('data-flavor');
                        const inputField = document.getElementById('flavor_' + flavorId);
                        const currentTotal = getTotalQuantity();
                        if (currentTotal < maxQuantity) {
                            inputField.value = parseInt(inputField.value) + 1;
                        } else {
                            alert("{{ __('sentence.you_cannot_select_more_than') }} " + maxQuantity + " {{ __('sentence.items') }}");
                        }
                    });
                });

                document.querySelectorAll('.decrease-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const flavorId = this.getAttribute('data-flavor');
                        const inputField = document.getElementById('flavor_' + flavorId);
                        const currentValue = parseInt(inputField.value);
                        if (currentValue > 0) {
                            inputField.value = currentValue - 1;
                        }
                    });
                });

                function getTotalQuantity() {
                    let total = 0;
                    document.querySelectorAll('.flavor-quantity-input').forEach(input => {
                        total += parseInt(input.value);
                    });
                    return total;
                }
            </script>
            <script>
                document.getElementById('add-to-cart-btn').addEventListener('click', function(e) {
                    e.preventDefault();
                    var options = {};
                    document.querySelectorAll('[id^="flavor_"]').forEach(function(input) {
                        var flavorId = input.getAttribute('id').replace('flavor_',
                            '');
                        var flavorName = document.querySelector('label[for="flavor_' + flavorId + '"]')
                            .innerText;
                        options[flavorName] = input.value;
                    });
                    var totalQuantity = Object.values(options).reduce(function(sum, quantity) {
                        return sum + parseInt(quantity);
                    }, 0);

                    if (totalQuantity == maxQuantity) {
                        console.log(options);
                        var options = Object.entries(options).map(function([flavor, quantity]) {
                            return flavor + ' ' + quantity;
                        }).join(', ');
                        document.getElementById('options').value = options;
                        document.getElementById('cart-form').submit();

                    } else {
                        alert(
                            "{{ __('sentence.message') }}"
                        );
                    }
                });
            </script>
        @endif
    @endpush
</x-user>
