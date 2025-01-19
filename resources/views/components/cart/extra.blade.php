<h5 class="ft-16 p-2 seccolr text-uppercase">{{ $extra->name }}</h5>

    <div class="cart-product-quantity d-flex justify-content-center">
        <div class="cart-plus-minus" style="border: 0px !important;">
            <button class="dec decrease-btn qtybutton" style="border: 0px !important;" wire:click="removeExtra({{$extra->id}})" >
                -</button>
            <input type="text" style="font-weight: 300;" value="{{$extraBucket[$extra->id]['qty'] }}" name="quantity"
                class="cart-plus-minus-box"
                id="extra_quantity_{{ $extra->id }}" min="1"
                placeholder="0" data-price="{{ $extra->price }}"
                data-name="{{ $extra->name }}" readonly>

            <button class="inc increase-btn qtybutton" style="border: 0px !important;" wire:click="addExtra({{$extra->id}})">
                +</button>
        </div>
    </div>
    <div class="pricetag justify-content-center">
        <div class="centerinput" style="width: 100px">
            <p style="font-weight: 100;" class="mb-0">
                <input style="font-weight: 300;" name="" id="price_{{ $extra->id }}"
                    style="width: 100px" class="p-0 text-center" readonly
                    value="{{ number_format($prices[$extra->id]['total'], 2) }}">
            </p>
        </div>
    </div>
    <div class="mb-2">
        <input type="hidden" name="product_id" value="{{ $extra->id }}">
        <input type="hidden" name="price" id="{{ $extra->id }}"
            value="{{ $extra->price }}">
        <input type="hidden"
            name="restaurent_id">

    </div>
