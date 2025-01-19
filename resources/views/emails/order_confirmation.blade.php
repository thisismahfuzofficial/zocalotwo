@extends('layouts.orderMail')
@section('content')
    @php
        $extras = json_decode($order->extra, true) ?? [];
        $customer = json_decode($order->shipping_info, true);
        $extra_charge = Settings::setting('extra.charge');
        // $status = $order->where('id', $order)->where('status', $order)->firstOrFail();
    @endphp
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 27px;">
        <tbody>
            <tr>
                <td>
                    <div class="title title-2 text-center">
                        <h2 style="font-size: 20px;font-weight: 700;margin: 24px 0 0;">Merci pour votre commande !</h2>
                        <p style="font-size: 14px;margin: 5px;line-height: 1.5;color: #939393;font-weight: 500;width: 70%;">
                            NOUVELLE COMMANDE {{ $order->restaurent->name ?? '' }}</p>
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
                        <h2 style="font-size: 20px;font-weight: 700;margin: 24px 0 0; margin-bottom: 15px;">Informations du
                            client</h2>
                        <strong style="font-size:14px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">Nom :</span> {{ $order->getShipping('f_name') }}
                            {{ $order->getShipping('l_name') }}</strong><br>
                        <strong
                            style="font-size:14px; line-height:24px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">Adresse mail :</span>
                            {{ $order->getShipping('email') }}</strong><br>
                        <strong
                            style="font-size:14px; line-height:24px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">Numéro de téléphone
                                :</span>{{ $order->getShipping('phone') }}</strong><br>
                        <strong
                            style="font-size:14px; line-height:24px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">Adresse de livraison :</span>
                            {{ $order->getShipping('address') }}
                            ,{{ $order->getShipping('city') }} ,{{ $order->getShipping('post_code') }}</strong><br>
                        <strong
                            style="font-size:14px; line-height:24px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">Commentaires :</span>
                            {{ $order->comment }}</strong><br>
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
                    Détails de la commande</th>
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
                                <th style="text-align: left;">Nom</th>
                                <th style="text-align: center;">Quantité</th>
                                <th style="text-align: center;">Prix</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($order->products as $product)
                                <tr style="border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    <td style=" padding: 28px 0; text-align:left;">
                                        <strong>{{ $product->category->name }}</strong> - {{ $product->name }} <br> <span>
                                            ({{ $product->pivot->options ?? '' }})
                                        </span>
                                    </td>
                                    <td style="padding: 28px 0; text-align: center;">{{ $product->pivot->quantity }}</td>
                                    <td style="padding: 28px 0; text-align: center;">
                                        {{ Settings::price($product->pivot->price * $product->pivot->quantity) }}</td>
                                </tr>
                            @endforeach
                            @foreach ($extras as $extra)
                                <tr style="border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    <td style="padding: 28px 0; text-align:lrft;">{{ $extra['name'] ?? '' }}</td>
                                    <td style="text-align: center;">{{ $extra['quantity'] ?? '' }}</td>
                                    <td style="text-align: center;">{{ Settings::price($extra['price'] * $extra['quantity'] ?? '') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            {{-- @dd($status) --}}
            <tr
                style="column-count: 1; column-rule-style: dashed; column-rule-color: rgba(82, 82, 108, 0.7); column-gap: 0; column-rule-width: 0;">


                <td style="width: 100%;" align="center">
                    <table class="dilivery-table" align="center" border="0" cellpadding="0" cellspacing="0"
                        width="100%" style="background-color: #F7F7F7; padding: 14px;">
                        <tbody>
                            <tr>
                                <td style="font-weight: 700; font-size: 17px; padding-bottom: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);"
                                    colspan="2">Résumé</td>
                            </tr>

                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Option de livraison</td>

                                @if ($order->delivery_option == 'home_delivery')
                                    <td
                                        style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                        Livraison à domicile</td>
                                @endif
                                @if ($order->delivery_option == 'take_away')
                                    <td
                                        style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                        À emporter</td>
                                @endif
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Mode de paiement</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ $order->payment_method == 'Card' ? 'CB en ligne' : 'Espèces / Tickets restaurant' }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Heure de livraison</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ $order->time_option }}</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">

                                    Taxe Totale</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ $order->tax }}</td>
                            </tr>

                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Sous-total</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($order->sub_total) }}</td>
                            </tr>

                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Frais de gestion</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($extra_charge) }}</td>
                            </tr>

                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Total</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($order->total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 27px;">
        <tbody>
            <tr>
                <td>
                    <div class="title title-2 text-start">
                        <h2 style="font-size: 20px;font-weight: 700;margin: 24px 0 0; margin-bottom: 15px;">
                            {{ $order->restaurent->name }}</h2>
                        <strong style="font-size:14px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">{{ $order->restaurent->business_name }}</span></strong><br>
                        <strong style="font-size:14px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">{{ $order->restaurent->license_number }}</span></strong><br>
                        <strong style="font-size:14px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">{{ $order->restaurent->business_location }}</span></strong><br>
                        <strong style="font-size:14px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">{{ $order->restaurent->restaurent_code }}</span></strong><br>
                        <strong style="font-size:14px; font-weight:normal;color:#333333; margin-left: 30px;"><span
                                style="font-size: 14px; font-weight:500;">{{ $order->restaurent->vat_number }}</span></strong><br>

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
