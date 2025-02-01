@extends('layouts.orderMail')
@section('content')
 
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 27px;">
        <tbody>
            <tr>
                <td>
                    <div class="title title-2 text-center">
                        <h2 style="font-size: 20px; font-weight: 700; margin: 24px 0 0;">Thank You for Your Order!</h2>
                        <p
                            style="font-size: 14px; margin: 5px; line-height: 1.5; color: #939393; font-weight: 500; width: 70%;">
                            NEW ORDER {{ $order->restaurent->name ?? '' }}
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 27px;">
        <tbody>
            <tr>
                <td>
                    <div class="title title-2 text-start">
                        <h2 style="font-size: 20px; font-weight: 700; margin: 24px 0 0; margin-bottom: 15px;">Customer
                            Information</h2>
                        <strong style="font-size: 14px; font-weight: normal; color: #333333; margin-left: 30px;">
                            <span style="font-size: 14px; font-weight: 500;">Name:</span>
                            {{ $order->getShipping('f_name') }} {{ $order->getShipping('l_name') }}
                        </strong><br>

                        <strong
                            style="font-size: 14px; line-height: 24px; font-weight: normal; color: #333333; margin-left: 30px;">
                            <span style="font-size: 14px; font-weight: 500;">Email Address:</span>
                            {{ $order->getShipping('email') }}
                        </strong><br>

                        <strong
                            style="font-size: 14px; line-height: 24px; font-weight: normal; color: #333333; margin-left: 30px;">
                            <span style="font-size: 14px; font-weight: 500;">Phone Number:</span>
                            {{ $order->getShipping('phone') }}
                        </strong><br>

                        <strong
                            style="font-size: 14px; line-height: 24px; font-weight: normal; color: #333333; margin-left: 30px;">
                            <span style="font-size: 14px; font-weight: 500;">Delivery Address:</span>
                            {{ $order->getShipping('address') }}, {{ $order->getShipping('city') }},
                            {{ $order->getShipping('post_code') }}
                        </strong><br>

                        <strong
                            style="font-size: 14px; line-height: 24px; font-weight: normal; color: #333333; margin-left: 30px;">
                            <span style="font-size: 14px; font-weight: 500;">Comments:</span>
                            {{ $order->comment }}
                        </strong><br>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>



    <table class="shipping-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="padding: 0 27px;">
        <thead>
            <tr>
                <th
                    style="font-size: 17px;font-weight: 700;padding-bottom: 8px;border-bottom: 1px solid rgba(217, 217, 217, 0.5);text-align: left; margin-top: 18px;">
                    Order Details</th>
            </tr>
        </thead>
        <tbody>
            <tr
                style="column-count: 1; column-rule-style: dashed; column-rule-color: rgba(82, 82, 108, 0.7); column-gap: 0; column-rule-width: 0; ">
                <td style="width: 100%;" align="center">
                    <table class="product-table" align="center" border="0" cellpadding="0" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Name</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: center;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr style="border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    <td style=" padding: 28px 0; text-align:left;">
                                        <strong>{{ $product->category->name }}</strong> - {{ $product->name }} <br> <span></span>
                                    </td>
                                    <td style="padding: 28px 0; text-align: center;">{{ $product->pivot->quantity }}</td>
                                    <td style="padding: 28px 0; text-align: center;">
                                        {{ Settings::price($product->pivot->price * $product->pivot->quantity) }}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr
                style="column-count: 1; column-rule-style: dashed; column-rule-color: rgba(82, 82, 108, 0.7); column-gap: 0; column-rule-width: 0;">
                <td style="width: 100%;" align="center">
                    <table class="delivery-table" align="center" border="0" cellpadding="0" cellspacing="0"
                        width="100%" style="background-color: #F7F7F7; padding: 14px;">
                        <tbody>
                            <tr>
                                <td style="font-weight: 700; font-size: 17px; padding-bottom: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);"
                                    colspan="2">Summary</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Delivery Option</td>

                                @if ($order->delivery_option == 'home_delivery')
                                    <td
                                        style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                        Home Delivery</td>
                                @endif
                                @if ($order->delivery_option == 'take_away')
                                    <td
                                        style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                        Take Away</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td style="text-align: right;">
                                    {{ $order->payment_method == 'Card' ? 'Online Card' : 'Cash / Meal Tickets' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Delivery Time</td>
                                <td style="text-align: right;">{{ $order->time_option }}</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td style="text-align: right;">{{ Settings::price($order->sub_total) }}</td>
                            </tr>
                            
                            <tr>
                                <td style="font-weight: 600;">Total</td>
                                <td style="text-align: right; font-weight: 600;">{{ Settings::price($order->total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
