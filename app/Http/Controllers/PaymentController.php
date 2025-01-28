<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Exception;
use Mail;

class PaymentController extends Controller
{
    // public function index()
    // {
    //     $amount = 50 * 100;
    //     $orderId = rand(111, 1111111);
    //     $merchantId = '083262709500018';
    //     $secretKey = 'iPPdH5CgxCQV05UiWF5tK4tsu1wcWwbHL2KZWiFCDY0';
    //     $keyVersion = 3;
    //     $normalRetrunUrl = url('/');
    //     $currencyCode = 978;

    //     $transactionReference = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

    //     $interfaceVersion = "HP_3.2";

    //     $data = 'amount=' . $amount . '|s10TransactionReference.s10TransactionId=' . $transactionReference . '|currencyCode=' . $currencyCode . '|merchantId=' . $merchantId . '|normalReturnUrl=' . $normalRetrunUrl . '|orderId=' . $orderId . '|keyVersion=' . $keyVersion;

    //     $seal = hash('sha256', mb_convert_encoding($data, 'UTF-8') . $secretKey);

    //    $response = Http::asForm()->post('https://sherlocks-payment-webinit.secure.lcl.fr/paymentInit', [
    //         'DATA' => $data,
    //         'SEAL' => $seal,
    //         'interfaceVersion' => $interfaceVersion,
    //     ]);
    //     return $response->body();
    // }
    // public function email() {
    //     $order = Order::find(164);
    //     return new OrderConfirmationMail($order);
    // }


    public function showPaymentGateway(Request $request, Order $order)
    {
        return view("user.payment", compact('order'));
    }

    public function completePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_id' => 'required',
        ]);
        $shipping = json_decode($order->shipping_info ?? '', true);

        // $stripe = setting('site.stripe_secret_key');
        $stripe = env('STRIPE_SECRET_KEY');

        $amount = intval($order->total * 100);
        // dd($amount);
        try {
            \Stripe\stripe::setApiKey($stripe);
            $response = \Stripe\Charge::create([
                "amount" => $amount,
                "currency" => 'USD',
                "source" => $request->payment_id,
                "receipt_email" => $shipping['email']?? '',
                "description" => "Zocalotwo",
                "shipping" => [
                    "name" => $shipping['f_name'] . $shipping['l_name'],
                    "address" => [
                        "city" => '',
                        "postal_code" => '',
                        "country" => 'US',
                        "line1" => $shipping['address'] ?? '',
                    ]
                ]
            ]);

            $order->update([
                'payment_status' => 'Paid',
                'transaction_id' => $request->payment_id,
                'payment_method' => 'stripe',
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            throw ValidationException::withMessages([
                'card' => ['An invalid request occurred.'],
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            throw ValidationException::withMessages([
                'card' => ['An invalid request occurred.'],
            ]);
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'card' => ['Another issue has arisen that may have nothing to do with Stripe.'],
            ]);
        }


        // Mail::send(new PaymentConfirmedMail($order));
        // $order_mail = Settings::setting('order.mail');
        $emails = array_filter([json_decode($order->shipping_info)->email, $order->restaurent->email]);
        // dd($emails);
        foreach ($emails as $email) {
            if (!empty($email)) {
                Mail::to($email)->send(new OrderConfirmationMail($order));
            }
        }

        return redirect()->route('thank_you')->with('success', 'Payment has been successfully completed.');
    }
}

