<div class="" data-aos="fade-up" data-aos-delay="200">
    <div class="card mb-3" style="background: transparent; border:none">
        <div class="card-body">
            <div class="text-center product-hover">
                <a href="{{ route('single.restaurant', ['restaurant' => $restaurant->slug, 'product' => $product]) }}">
                    <img class="img-fluid slideImage"
                        src="{{ $product->image ? $product->image : asset('niko/assets/img/menu/lobster-bisque.jpg') }}">
                </a>

                <h4 class="" style="">
                    <a href="{{ route('single.restaurant', ['restaurant' => $restaurant->slug, 'product' => $product]) }}"
                        style="color: #ff883e !important; !important; font-size: 15px !important; font-weight: 300 !important;">{{ $product->name }}</a>
                </h4>
                <div class="d-flex gap-3 justify-content-center">
                    <div class="price-container">
                        <h5 class=" price" style="font-size: 14px !important; color: #e4d4bf !important;">
                            {{ Settings::price($product->price) }}
                        </h5>


                        @if ($product->options->count() || $product->flavor_status == 1)
                            <a href="{{ route('single.restaurant', ['restaurant' => $restaurant->slug, 'product' => $product]) }}"
                                class=" text-colour add-button btn"
                                style="background:#e5d5bf !important; color:#000 !important; font-size: 10px;">
                                <i class="bi bi-plus"></i>{{ __('sentence.possibilities') }}
                            </a>
                        @else
                            <form action="{{ route('cart.store') }}" method="post" class="add-button">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="restaurent_id" value="{{ $restaurant->id }}">
                                @if ($product->status == 1)
                                    <button type="submit" class="text-colour btn"
                                        style="background:#e5d5bf !important; color: #000 !important; font-size: 10px !important; ">
                                        <i class="bi bi-plus"></i>{{ __('sentence.add') }}</button>
                                @else
                                    <button disabled class="text-colour btn"
                                        style="background:#e5d5bf !important; color: #000 !important; font-size: 10px !important; ">
                                        <i class="bi bi-plus"></i>{{ __('sentence.out_of_stock') }}</button>
                                @endif
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
