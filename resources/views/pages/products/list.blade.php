<x-layout>
    <style>
        .btn-outline-dark:hover {
            color: #fff !important;
            background-color: #212529;
            border-color: #212529;
        }
    </style>

    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
                <div class="d-flex justify-content-between mt-1 mb-3">
                    <div style="float"class="mt-2">
                        <a href="{{ route('create.product') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                            {{ __('sentence.addnewproduct') }}</a>
                    </div>
                </div>
            <table class="table">
                <thead>
                    <tr>

                        <th scope="col">#</th>
                        <th scope="col">{{ __('sentence.image') }}</th>
                        <th scope="col">{{ __('sentence.sequency') }}</th>
                        <th scope="col">{{__('sentence.productname')}}</th>
                        <th scope="col">{{ __('sentence.price') }}</th>
                        <th scope="col">{{ __('sentence.tax') }}</th>
                        {{-- <th scope="col">status</th> --}}
                        <th>{{ __('sentence.sku') }}</th>
                        <th scope="col">{{ __('sentence.category') }}</th>
                        <th scope="col" class="text-center">{{ __('sentence.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                       
                        <tr>


                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                <img class="" height="100" width="100" src="{{ $product->image }}"
                                alt="">
                            </td>
                            <th scope="row">{{ $product->sequency }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ Settings::price($product->price) }}</td>
                            <td>{{ number_format($product->tax, 2) }} %</td>
                            <td>{{ $product->SKU }}</td>
                            <td>
                                @if ($product->category)
                                    {{ $product->category->name }}
                                @else
                                    <span class="badge bg-danger">{{ __('sentence.notfound') }}</span>
                                @endif
                            </td>

                            <td class="text-center">

                                <a class="btn btn-sm btn-primary" href="{{ route('edit.product', $product) }}"><i
                                        class="fa fa-edit"></i></a>
                                <x-actions.delete :action="route('delete.product', $product)" />
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
            <tfoot>
                <tr>
                    <td>
                        {{ $products->links('pagination::bootstrap-5') }}
                    </td>
                </tr>
            </tfoot>
        </div>

    </div>
    <x-filter :url="route('products.index')">
        <div class="row">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="['name' => 'Name','SKU' => 'SKU']" />
            </div>
            <div class="col-md-8">
                <x-form.input type="text" name="search[query]" :value="@request()->search['query']" label="Search" />
            </div>
        </div>
        <x-form.input type="select" name="filter[category_id]" label="Category" :value="@request()->filter['category_id']" :options="$categories"
            :show_empty_options="true" />

       

    </x-filter>

    @push('script')
        <script>
            $(document).ready(function() {
                $('#generic-input').select2();
            });

            function duplicateProduct(productId) {

                var csrf_token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ route('products.duplicate') }}",
                    method: "POST",
                    data: {
                        productId: productId,
                        _token: csrf_token

                    },
                    success: function(response) {
                        window.location.href = "{{ route('products.createOrEdit', '') }}/" + response.newProductId;
                    },
                    error: function(error) {
                        alert('Error duplicating product!');
                    }
                });
            }
        </script>
    @endpush
</x-layout>

