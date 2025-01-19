<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Settings;

class PrinterService
{


    protected Order $order;
    protected Restaurant $restaurant;
    protected $config;
    protected $orderBody;
    protected $message = '';
    public $response;


    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->restaurant = $order->restaurent;
        $this->setConfig();
        $this->setOrderBody();
        $this->makeMessage();
    }


    protected function setConfig()
    {
        $this->config = [
            'print_on' => $this->restaurant->enable_printer ? true : false,
            'printer_size' => 80,
            'printer_uid' => $this->restaurant->getPrinterCreds('printer_id'),
            // 'printer_uid' => '4TMPLAFUYKH',
            'printer_uid_backup' => 'TEST_UID_BACKUP',
            'sms_num' => $this->restaurant->number,
            'print_nb' => 1,
            'multistore' => '1:TEST_UID',
            'time_shift' => 0,
            'logo_url' => Storage::url(Settings::setting('site.logo')),
            'title' => $this->restaurant->name,
            'company' => $this->restaurant->name,
            'company_id' => $this->restaurant->id,
            'adr1' => $this->restaurant->fullAddress(),
            'adr2' => $this->restaurant->fullAddress(),
            'zip' => $this->restaurant->fullAddress('post_code'),
            'city' => $this->restaurant->fullAddress('city'),
            'phone' => $this->restaurant->number,
            'email' => $this->restaurant->email,
            'sid' => $this->restaurant->getPrinterCreds('sid'),
            'token' => $this->restaurant->getPrinterCreds('token'),
            // 'sid' => '6638e275f8c972bef91bb4e3cd8134af3556c23d',
            // 'token' => '79bdb4e5e695e9a6dc0eee251a441f5211e225b9',
            'short_opts' => 1,
            'vat_number' => $this->restaurant->vat_number,
            'business_name' => $this->restaurant->business_name,
            'license_number' => $this->restaurant->license_number,
            'business_location' => $this->restaurant->business_location,
            'restaurent_code' => $this->restaurant->restaurent_code,
        ];
    }

    protected function setOrderBody()
    {

        $this->orderBody = (object) [
            'id' => $this->order->id,
            'created_at' => $this->order->created_at->format('d-m-Y H:i:s'),
            'payment_method_title' => ucwords($this->order->payment_method),
            'shipping_method_title' => $this->order->delivery_option == 'take_away' ? 'a emporter' : 'livraison a domicile',
            'delivery_date' => now()->format('d-m-Y'),
            'delivery_time' =>  $this->order->time_option,
            'shipping' => (object) [
                'first_name' => $this->order->getShipping('f_name'),
                'last_name' => $this->order->getShipping('l_name'),
                'email' => $this->order->getShipping('email'),
                'address_1' => $this->order->delivery_option != 'take_away' ? $this->order->getShipping('house') : '',
                'address_2' => $this->order->getShipping('address'),
                'postcode' => $this->order->getShipping('post_code'),
                'city' => $this->order->getShipping('city'),
                'phone' => $this->order->getShipping('phone'),
            ],
            'products' => (object) $this->order->getProducts()->toArray(),
            'tax' => $this->order->tax,
            'total' => $this->order->total,
            'comment' => $this->order->comment,
            'vendor_id' => $this->order->restaurant_id,
        ];
    }

    protected function makeMessage()
    {


        $msg = '';

        // Header
        $msg .= "<C><BOLD>{$this->config['title']}</BOLD></C>\n";

        $msg .= "--------------------------------\n";

        // Order Reference and Date
        $order_date_created = $this->orderBody->created_at;
        $msg .= "Commande: {$this->orderBody->id}\nDate: {$order_date_created}\n";

        // Payment Method
        $payment_method = $this->orderBody->payment_method_title == 'Card' ? 'PEL' : 'RESTO';
        $msg .= "Paiement: " . ucfirst($payment_method) . "\n";

        // Delivery Method and Time
        $msg .= "Mode Livraison: " . ($this->orderBody->shipping_method_title ?? 'N/A') . "\n";
        $msg .= "Date: " . ($this->orderBody->delivery_date ?? 'N/A') . "\n";
        $msg .= "Heure: " . ($this->orderBody->delivery_time ?? 'N/A') . "\n";
        $msg .= "Commentaires: {$this->orderBody->comment}\n";
        // Shipping Address
        $shipping = $this->orderBody->shipping;
        if ($shipping) {
            $msg .= "Adresse Livraison:\n";
            $msg .= "{$shipping->first_name} {$shipping->last_name}\n";
            $msg .= "{$shipping->email}\n";
            $msg .= "{$shipping->phone}\n";
            $msg .= $shipping->address_1 ?? "{$shipping->address_1}\n";
            if ($shipping->address_2) {
                $msg .= "{ $shipping->address_2}\n";
            }
            $msg .= $shipping->postcode ?? "{ $shipping->postcode} { $shipping->city}\n";
        }

        // Products
        $msg .= "Produits:\n";
        // dd($this->orderBody->products);
        foreach ($this->orderBody->products as $product) {
            $productName = $product->name;
            $category = isset($product->category) ? $product->category->name : '';
            $quantity = (int)$product->quantity;
            $price = Settings::price($product->price * $quantity) ;
            $tax = Settings::price($product->tax * $quantity);
            $base_price = Settings::price(($product->price - $product->tax) * $quantity);
        
            // Adjust spacing for better alignment
            $msg .= $quantity . " * " 
            . $category . " - " 
            . $productName . "  " 
            . $price . " \n";
        
            // Handle suboptions with proper indentation
            $suboptions = $product->options ?? [];
            foreach ($suboptions as $suboption) {
                $msg .= "{$suboption}\n";  // Indent suboptions
            }
        }


        $tax = $this->order->getProducts()->groupBy('tax_percent')->map(fn($order) => [
            'count'=> $order->count(),
            'subtotal' =>number_format( $order->sum('total'), 2),
            'vat' => number_format($order->sum('tax'), 2),
        ]);

        
        $i = 1;
        $msg .= "------------------------------------------------" . "\n";
        $msg .= "Code       |  HT         |   TVA       |   TTC" . "\n";
        foreach ($tax as $key => $data) {
            // dd($data['subtotal']);
            $count = $data['count'];
            $total = $data['subtotal'];
            
            $tax = number_format($data['vat'], 2);
            $subtotal = $total - $tax;
            $msg .= "($count) $key%   |   $subtotal Є    |   $tax Є    |   $total Є" . "\n";
        }

        $msg .= "------------------------------------------------" . "\n";
        $msg .= "TVA incluse: " . (Settings::price($this->orderBody->tax) ?? 'N/A') . "\n";
        $msg .= "Frais de gestion: " . (Settings::setting('extra.charge') ?? 'N/A'). " Є" . "\n";
        $msg .= "<BOLD> "."Total TTC:". Settings::price($this->orderBody->total) ."</BOLD> "."\n";


        $msg .= "<C>{$this->config['business_name']}\n";
        $msg .= "SIRET: {$this->config['license_number']}\n";
        if ($this->config['business_location']) {
            $msg .= "{$this->config['business_location']}\n";
        }
        if ($this->config['restaurent_code']) {
            $msg .= "{$this->config['restaurent_code']}\n";
        }
        if ($this->config['vat_number']) {
            $msg .= "{$this->config['vat_number']}\n";
        }
        if ($this->config['adr1']) {
            $msg .= "{$this->config['adr1']}\n";
        }
        $msg .= "Tel: {$this->config['phone']} | Email: {$this->config['email']}</C>";
        $msg .= "<CUT/>";
        $this->message = $msg;
    }






    public function sendToPrinter()
    {
        // return $this->message;
        if (!$this->config['print_on']) {
            return response()->json(['message' => 'Printing is disabled.'], 200);
        }
        $response = Http::withHeaders([
            'Authorization' => $this->config['sid'] . ':' . $this->config['token'],
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://www.expedy.fr/api/v2/printers/' . $this->config['printer_uid'] . '/print', [
            'printer_msg' =>  $this->message,
            'origin' => url('/')
        ]);
        $this->response = $response->body();
        return $this->response;
    }
}
