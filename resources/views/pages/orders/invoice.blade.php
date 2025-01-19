@php
    $extras = json_decode($order->extra, true) ?? [];
    // $restaurant = App\Models\Restaurant::find($order->products()->first()->pivot->restaurant_id);

@endphp
{{-- @dd($extras) --}}
<x-layout>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <button onclick="printDiv('printableArea')" class="btn btn-success me-1 mb-2"><i
                        class="fa fa-print me-2"></i>{{ __('sentence.print') }}</button>
                <a href="{{auth()->user()->role_id == 3 ? route('resto_orders.expedy.print',$order) : route('orders.expedy.print',$order)}}" class="btn btn-success me-1 mb-2"><i
                        class="fa fa-print me-2"></i> {{ __('sentence.expedy_print') }}</a>
                <div class="card" id="printableArea">
                    <div class="card-body">

                        @if ($order->notes)
                            <div class="text-start">
                                <span class="text-danger fw-bolder fs-6">{{ __('sentence.note') }}: {{ $order->notes }}</span>
                            </div>
                        @endif
                        <hr class="mt-3 mb-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">{{ __('sentence.bill_to') }}:</h5>
                                    <h5 class="font-size-15 mb-2"> {{ $order->getShipping('f_name') }} {{ $order->getShipping('l_name') }}</h5>
                                    <p class="mb-1">{{ $order->getShipping('email') }} </p>
                                    <p class="mb-1">{{ $order->getShipping('phone') }} </p>
                                    <p class="mb-1">{{ $order->getShipping('address') }} </p>
                                    <p class="mb-1">{{ $order->getShipping('house') }}  {{ $order->getShipping('post_code') }} {{ $order->getShipping('city') }}</p>
                                    @if ($order->payment_status =='failed')
                                    <h4 class="text-danger">{{ __('sentence.cancelled_message') }}</h4>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">{{ __('sentence.invoice_no') }}:</h5>
                                        <p>#{{ $order->id }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">{{ __('sentence.restaurent_name') }}:</h5>
                                        <p>{{ $order->restaurent->name ?? '' }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">{{ __('sentence.delivery_time') }}:</h5>
                                        <p>{{ $order->time_option }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">{{ __('sentence.invoice_date') }}:</h5>
                                        <p>{{ $order->created_at->format('d-M-y') }}</p>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="py-2">
                            <h5 class="font-size-15">{{ __('sentence.order_summery') }}</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">#.</th>
                                            <th>{{ __('sentence.products') }}</th>
                                            <th>{{ __('sentence.quantity') }}</th>
                                            <th class="text-end">{{ __('sentence.price') }}</th>
                                            <th class="text-end" style="width: 120px;">{{ __('sentence.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($order->products as $product)
                                            <tr>
                                                <th scope="row">{{ $product->id }}</th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14 mb-1">
                                                            {{ $product->name }}
                                                        </h5>
                                                        <p class="text-muted mb-0">{{ __('sentence.categoty') }}: {{ $product->category->name }} 
                                                            @if ( $product->pivot->options )
                                                            {{ __('sentence.options') }}: {{ $product->pivot->options }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>{{ $product->pivot->quantity }}</td>

                                                <td class="text-end">{{ Settings::price($product->pivot->price) }}</td>
                                                <td class="text-end">
                                                    {{ Settings::price($product->pivot->price * $product->pivot->quantity) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($extras as $item)
                                            <tr>
                                                <th scope="row">{{ $item['id'] }}</th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14 mb-1">{{ $item['name'] }}
                                                        </h5>
                                                        {{-- <p class="text-muted mb-0">{{ $product->category->name }}</p> --}}
                                                    </div>
                                                </td>
                                                <td>{{ $item['quantity'] }}</td>

                                                <td class="text-end">{{ Settings::price($item['price']) }}</td>
                                                <td class="text-end">
                                                    {{ Settings::price($item['price'] * $item['quantity']) }}</td>
                                            </tr>
                                        @endforeach
                                        {{-- @dd(Settings::price($order->sub_total)) --}}
                                        <tr>
                                            <th scope="row" colspan="4" class="text-end">{{ __('sentence.sub_total') }}</th>
                                            <td class="text-end">{{ Settings::price($order->sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                {{ __('sentence.tax') }} :</th>
                                            <td class="border-0 text-end"> {{ Settings::price($order->tax) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                FRAIS DE GESTION:  :</th>
                                            <td class="border-0 text-end"> {{ Settings::price(0.95) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">{{ __('sentence.total') }}</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold">{{ Settings::price($order->total) }}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- @if ($order->transactions->count() > 0)
                                <h5 class="font-size-15 mt-3">Due payment transaction history</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->transactions as $transaction)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>
                                                    {{ Settings::price($transaction->amount) }}
                                                </td>
                                                <td>{{ $transaction->created_at->format('M d,Y') }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>

    @push('script')
        <script type="text/javascript">
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
</x-layout>
