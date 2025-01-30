{{-- @php
    $extras = json_decode($order->extra, true) ?? [];
    $restaurant = App\Models\Restaurant::find($order->products()->first()->pivot->restaurant_id);
@endphp --}}
{{-- @dd($extras) --}}
<x-main>
    @push('css')
        {{-- <style>
            .invoice {
                border-top: 1px solid #ba321c !important;
                border-bottom: 1px solid #ba321c !important;
            }

            .invoice tr th {
                background-color: #ba321c !important;
                color: var(--section-bg-1) !important;
            }
        </style> --}}
    @endpush
    <br><br><br>
    <div class="container mb-5 ">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class=" bg-transparent border border-danger" id="printarea">
                    <div class="card-body bg-transparent" style="padding: 0px">
                        {{-- @if ($order->notes)
                            <div class="text-start">

                                <span class="text-danger fw-bolder fs-6">Note: {{ $order->notes }}</span>
                            </div>
                        @endif --}}

                        <div class="row mt-3">
                            <div class="col-sm-6 ps-4">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Legal purpose for</h5>

                                    <h5 class="font-size-15 mb-2 text-colour">
                                        {{ $order->customer->name ?? 'Walk in customer' }}
                                        {{ $order->customer->l_name ?? '' }}
                                    </h5>
                                    {{-- <p class="mb-1">{{ $order->customer->address }}</p> --}}
                                    <p class="mb-1 text-colour">{{ $order->customer->email }}</p>
                                    {{-- <p   >{{ $order->customer->phone }}</p> --}}
                                    @if ($order->payment_status == 'failed')
                                        <h2 class="text-danger">{{ __('sentence.cancelled_message') }}</h2>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6 pe-4">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Order number*</h5>
                                        <p class="text-colour">#{{ $order->id }}</p>
                                    </div>
                                    <div class="mt-4">
                                        {{-- @dd($order->products) --}}
                                        <h5 class="font-size-15 mb-1">Restaurant Name</h5>
                                        <p class="text-colour">{{ $order->restaurent->name ?? '' }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Date</h5>
                                        <p class="text-colour">{{ $order->created_at->format('F j, Y, g:i a') }}</p>

                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Delivery time:</h5>
                                        <p class="text-colour">{{ $order->time_option }}</p>
                                    </div>


                                </div>
                            </div>

                        </div>


                        <div>
                            <h5 class="font-size-15 ps-3">Order overview</h5>

                            <div class="table-responsive border-top border-danger   ">
                                <table class="table align-middle table-nowrap table-centered mb-0 bg-transparent">
                                    <thead class="invoice">
                                        <tr>
                                            <th class="text-center col-2">Product Id</th>
                                            <th class="text-center">Flavors</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center ">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @dd($order->products ) --}}
                                        @foreach ($order->products as $product)
                                            <tr class="text-center">
                                                <th class="bg-transparent text-center text-danger  " scope="row">
                                                    {{ $product->id }}
                                                </th>
                                                <td class="bg-transparent text-center text-danger  ">
                                                    <div>
                                                        <h5 class="text-truncate text-danger font-size-14 mb-1">
                                                            {{ $product->name }}
                                                            {{ $product->strength }}
                                                        </h5>
                                                        <p class="text-danger  mb-0">{{ $product->category->name }}</p>
                                                    </div>
                                                </td>
                                                <td class="bg-transparent text-center text-danger ">
                                                    {{ $product->pivot->quantity }}
                                                </td>
                                                <td class="text-center bg-transparent text-center text-danger ">
                                                    {{ Settings::price($product->pivot->price) }}</td>
                                                <td class="text-center bg-transparent text-center text-danger ">
                                                    {{ Settings::price($product->pivot->price * $product->pivot->quantity) }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <th scope="row" colspan="4"
                                                class="text-end bg-transparent text-danger ">
                                                {{ __('sentence.sub_total') }}</th>
                                            <td class="text-center bg-transparent text-danger ">
                                                {{ Settings::price($order->sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4"
                                                class="border-0 text-end bg-transparent text-danger ">
                                                {{ __('sentence.total') }}</th>
                                            <td class="border-0 text-center bg-transparent text-danger ">
                                                <h4 class="m-0 fw-bold text-danger">
                                                    {{ Settings::price($order->total) }}</h4>
                                            </td>
                                        </tr>

                                        {{-- <tr class="bg-success">
                                            <th scope="row" colspan="4"
                                                class="border-0 text-end bg-transparent  ">
                                                Paid Ammount:</th>
                                            <td class="border-0 text-end bg-transparent  ">
                                                {{ Settings::price($order->paid) }}
                                            </td>
                                        </tr>
                                        <tr class="bg-warning">
                                            <th scope="row" colspan="4"
                                                class="border-0 text-end bg-transparent  ">
                                                Due Ammount :</th>
                                            <td class="border-0 text-end bg-transparent  ">
                                                {{ Settings::price($order->due) }}
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div><!-- end col -->
            </div>
        </div>

        @push('js')
            <script>
                function printDiv(divName) {
                    console.log(divName)
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;

                    window.print();

                    document.body.innerHTML = originalContents;
                }
            </script>
        @endpush
</x-main>
