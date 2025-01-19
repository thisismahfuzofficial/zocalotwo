@dd($product)
<x-layout>
    <div class="container mt-3">
        <div class="row justify-content-center">
                <div class="card" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="rounded" src="{{ $product->image }}"
                                alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex ">
                                    <h5>Product name:</h5>
                                    <p>{{$product->name}}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>

</x-layout>