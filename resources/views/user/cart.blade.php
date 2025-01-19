<x-user>
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


        {{-- <script>
            function checkLoginStatus() {
                @if (auth()->check())
                    return true; // Allow form submission
                @else
                    alert('Please log in to proceed to checkout.');
                    return false; // Prevent form submission
                @endif
            }
        </script> --}}
    @endpush

</x-user>
