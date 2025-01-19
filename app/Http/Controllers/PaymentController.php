<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        $amount = 50 * 100;
        $orderId = rand(111, 1111111);
        $merchantId = '083262709500018';
        $secretKey = 'iPPdH5CgxCQV05UiWF5tK4tsu1wcWwbHL2KZWiFCDY0';
        $keyVersion = 3;
        $normalRetrunUrl = url('/');
        $currencyCode = 978;

        $transactionReference = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $interfaceVersion = "HP_3.2";

        $data = 'amount=' . $amount . '|s10TransactionReference.s10TransactionId=' . $transactionReference . '|currencyCode=' . $currencyCode . '|merchantId=' . $merchantId . '|normalReturnUrl=' . $normalRetrunUrl . '|orderId=' . $orderId . '|keyVersion=' . $keyVersion;

        $seal = hash('sha256', mb_convert_encoding($data, 'UTF-8') . $secretKey);

       $response = Http::asForm()->post('https://sherlocks-payment-webinit.secure.lcl.fr/paymentInit', [
            'DATA' => $data,
            'SEAL' => $seal,
            'interfaceVersion' => $interfaceVersion,
        ]);
        return $response->body();
    }
    public function email() {
        $order = Order::find(164);
        return new OrderConfirmationMail($order);
    }
}