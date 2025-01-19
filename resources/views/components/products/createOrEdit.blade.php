<form action="{{ route('products.save', ['product' => $product]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8 mb-4">

                <div class="card">
                    <div class="card-body">
                        <h6 class="dash_head">Product Details</h6>

                        <div class="row row-cols-2">
                            <x-form.input name="name" wire:model="name" label="Title *" value="{{ $product?->name }}"
                                autofocus required />
                            <x-form.input name="strength" wire:model="strength" label="Strength"
                                value="{{ $product?->strength }}" />

                        </div>


                        <div class="row row-cols-1 tox-editor-container" wire:ignore>


                        </div>

                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row row-cols-2">

                            <x-form.input id="unit" name="unit" wire:model="unit" label="Unit"
                                value="{{ $product?->unit }}" />
                            <x-form.input id="price" name="price" wire:model="price" label="Unit Price (Tk) *"
                                value="{{ $product?->price }}" required />
                            <x-form.input id="trade_price" name="trade_price" wire:model="trade_price"
                                value="{{ $product?->trade_price }}" label="TP + Vat " />



                            <x-form.input name="strip_price" wire:model="strip_price" label="Strip Price (Tk)"
                                value="{{ $product?->strip_price }}" />


                            <x-form.input name="box_price" wire:model="box_price" label="Box Price (Tk)"
                                value="{{ $product?->box_price }}" />
                            {{-- @if ($product?->sku)
                                <x-form.input name="sku" wire:model="sku" label="Sku *"
                                    value="{{ $product?->sku }}" readonly />
                            @endif --}}

                            <x-form.input name="box_size" wire:model="box_size" label="Box Pattern"
                                value="{{ $product?->box_size }}" />


                        </div>

                    </div>
                </div>

                <div class="card mt-4">

                    <div class="card-body">
                        <div class="row row-cols-2">
                            <x-form.input name="status" wire:model="status" value="{{ $product?->status }}"
                                type="select" label="Status" :options="[0 => 'False', 1 => 'True']" />
                            <x-form.input name="featured" wire:model="featured" value="{{ $product?->featured }}"
                                type="select" label="Featured" :options="[0 => 'False', 1 => 'True']" />
                            <x-form.input name="is_bonus" wire:model="is_bonus" value="{{ $product?->is_bonus }}"
                                type="select" label="Product Variation" :options="['Rate Product' => 'Rate Product', 'Bonus Product' => 'Bonus Product']" />


                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="row row-cols-1">
                            <x-form.input name="image" wire:model="image" value="{{ $product?->description }}"
                                type="file" label="Drag image to upload" style="padding:50px;" />

                            @if ($product?->image)
                                <img src="{{ $product?->image_url }}"
                                    style="height: 200px; width:200px;object-fit:cover" alt="">
                            @endif



                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body products-generic-card">
                        <div class="row row-cols-2">
                            <x-form.input name="category" wire:model="category" value="{{ $product?->category?->id }}"
                                type="select" label="Category" :options="$categories" />
                            <x-form.input name="generic" wire:model="generic" value="{{ $product?->generic?->id }}"
                                type="select" label="Generic" :options="$generics" />
                            <x-form.input name="supplier" value="{{ $product?->supplier?->id }}" type="select"
                                label="Supplier" :options="$suppliers" />

                            <x-form.input name="type" wire:model="type" value="{{ $product->type ?? '' }}"
                                type="select" label="type" :options="[
                                    'Medicine' => 'Medicine',
                                    'Baby Care' => 'Baby Care',
                                    'Condom' => 'Condom',
                                    'Women Care' => 'Women Care',
                                    'Device' => 'Device',
                                ]" />
                        </div>
                        <button class="btn btn-success" type="submit" style="float: right">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>

                </div>



            </div>




        </div>
</form>
