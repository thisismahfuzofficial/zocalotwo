<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\PrinterService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Settings;

class ExpedyController extends Controller
{


    public function sendToPrinter()
    {
        $order = Order::find(248);
        (new PrinterService($order))->sendToPrinter();
    }

    // public function sendToPrinter($orderId)
    // {
    //     // Fetch Expedy configurations
    //     $config = config('expedy');

    //     // Check if printing is enabled
    //     if (!$config['print_on']) {
    //         return response()->json(['message' => 'Printing is disabled.'], 200);
    //     }

    //     // Retrieve the order
    //     $order = Order::with('products', 'shipping')->find($orderId);

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found.'], 404);
    //     }

    //     // Initialize variables
    //     $this_host = request()->getHost();
    //     $line_width = $config['printer_size'] == 58 ? 30 : ($config['printer_size'] == 80 ? 48 : 30);
    //     $printer_uid = $config['printer_uid'];
    //     $printer_uid_backup = $config['printer_uid_backup'];
    //     $sms_num = $config['sms_num'];
    //     $print_nb = $config['print_nb'];
    //     $multistore = $config['multistore'];
    //     $time_shift = $config['time_shift'];

    //     // Construct the printer message
    //     $msg = '';

    //     // Logo
    //     if (!empty($config['logo_url'])) {
    //         $msg .= '<IMG>' . $config['logo_url'] . '</IMG>';
    //     }

    //     // Header
    //     $msg .= "<C><BOLD>{$config['title']}</BOLD></C>\n";
    //     $msg .= "{$config['company']}\n";
    //     $msg .= "{$config['company_id']}\n";
    //     $msg .= "{$config['adr1']}\n";
    //     $msg .= "{$config['adr2']}\n";
    //     $msg .= "{$config['zip']} {$config['city']}\n";
    //     $msg .= "Tel: {$config['phone']} | Email: {$config['email']}\n";
    //     $msg .= "--------------------------------\n";

    //     // Order Reference and Date
    //     $order_date_created = $order->created_at->format('Y-m-d H:i:s');
    //     $msg .= "Commande: {$order->id}\nDate: {$order_date_created}\n";

    //     // Payment Method
    //     $msg .= "Paiement: " . ucfirst($order->payment_method_title) . "\n";

    //     // Delivery Method and Time
    //     $msg .= "Mode Livraison: " . ($order->shipping_method_title ?? 'N/A') . "\n";
    //     $msg .= "Date: " . ($order->delivery_date ?? 'N/A') . "\n";
    //     $msg .= "Heure: " . ($order->delivery_time ?? 'N/A') . "\n";

    //     // Shipping Address
    //     $shipping = $order->shipping;
    //     if ($shipping) {
    //         $msg .= "Adresse Livraison:\n";
    //         $msg .= "{$shipping->first_name} {$shipping->last_name}\n";
    //         if ($shipping->company) {
    //             $msg .= "{$shipping->company}\n";
    //         }
    //         $msg .= "{$shipping->address_1}\n";
    //         if ($shipping->address_2) {
    //             $msg .= "{$shipping->address_2}\n";
    //         }
    //         $msg .= "{$shipping->postcode} {$shipping->city}\n";
    //     }

    //     // Products
    //     $msg .= "Produits:\n";
    //     foreach ($order->products as $product) {
    //         $productName = $product->name;
    //         $quantity = $product->pivot->quantity;
    //         $price = number_format($product->pivot->price, 2, '.', '') . '€';
    //         $msg .= "{$quantity} x {$productName} - {$price}\n";

    //         // Handle suboptions if any
    //         $suboptions = $product->pivot->meta['suboptions'] ?? [];
    //         foreach ($suboptions as $suboption) {
    //             $suboptionName = $config['short_opts'] == 1 ? $suboption['value'] : "{$suboption['name']} {$suboption['value']}";
    //             $suboptionPrice = $suboption['price'] > 0 ? " +{$suboption['price']}€" : '';
    //             $msg .= "   • {$suboptionName}{$suboptionPrice}\n";
    //         }
    //     }

    //     // Totals
    //     $msg .= "--------------------------------\n";
    //     $msg .= "Total: " . number_format($order->total, 2, '.', '') . "€\n";

    //     // Customer Note
    //     if (!empty($order->customer_note)) {
    //         $msg .= "\n<BOLD>NOTE CLIENT</BOLD>\n{$order->customer_note}\n";
    //     }

    //     // Store Address (if different)
    //     $msg .= "Magasin:\n{$config['adr1']}\n{$config['adr2']}\n{$config['zip']} {$config['city']}\n";

    //     // Cut the receipt
    //     $msg .= "<CUT/>";

    //     // Prepare data_params
    //     $data_params = [
    //         'printer_uid' => $printer_uid,
    //         'printer_msg' => $this->stripAccents(strtoupper($msg)),
    //     ];

    //     // Multi-store support
    //     if (!empty($multistore)) {
    //         $storeUid = $order->vendor_id ?? null;
    //         if ($storeUid) {
    //             $stores = explode('||', rtrim($multistore, '||'));
    //             foreach ($stores as $store) {
    //                 list($store_id, $store_printer_uid) = explode(':', $store);
    //                 if ($store_id == $storeUid) {
    //                     $data_params['printer_uid'] = $store_printer_uid;
    //                     break;
    //                 }
    //             }
    //         }
    //     }

    //     // Backup Printer
    //     if (!empty($printer_uid_backup)) {
    //         $data_params_backup = [
    //             'printer_uid' => $printer_uid_backup,
    //             'printer_msg' => $data_params['printer_msg'],
    //         ];
    //     }

    //     // Prepare the main API request data
    //     $data_request = [
    //         'sid' => $config['sid'],
    //         'token' => $config['token'],
    //         'origin' => $this_host,
    //         'params' => $data_params,
    //     ];

    //     try {
    //         // Send the HTTP POST request to the main printer
    //         $response = Http::post('https://www.expedy.fr/api/print', $data_request);

    //         if ($response->successful()) {
    //             Log::info("Print request successful for Order ID: {$orderId}");
    //         } else {
    //             Log::error("Print request failed for Order ID: {$orderId}. Status: {$response->status()}");
    //         }

    //         // Send to backup printer if available
    //         if (!empty($printer_uid_backup)) {
    //             $data_request_backup = [
    //                 'sid' => $config['sid'],
    //                 'token' => $config['token'],
    //                 'origin' => $this_host,
    //                 'params' => $data_params_backup,
    //             ];

    //             $response_backup = Http::post('https://www.expedy.fr/api/print', $data_request_backup);

    //             if ($response_backup->successful()) {
    //                 Log::info("Backup print request successful for Order ID: {$orderId}");
    //             } else {
    //                 Log::error("Backup print request failed for Order ID: {$orderId}. Status: {$response_backup->status()}");
    //             }
    //         }

    //         // Send SMS if configured
    //         if (!empty($sms_num)) {
    //             $sms_msg = "Nouvelle commande : {$order->id} (" . number_format($order->total, 2, '.', '') . " EUR) -> {$this_host}/admin/orders/{$order->id}";
    //             $sms_sender = 'EXPEDY';

    //             $data_params_sms = [
    //                 'sms_sender' => $sms_sender,
    //                 'sms_phone' => $sms_num,
    //                 'sms_msg' => $sms_msg,
    //             ];

    //             $data_request_sms = [
    //                 'sid' => $config['sid'],
    //                 'token' => $config['token'],
    //                 'origin' => $this_host,
    //                 'params' => $data_params_sms,
    //             ];

    //             $response_sms = Http::post('https://www.expedy.fr/api/sms', $data_request_sms);

    //             if ($response_sms->successful()) {
    //                 Log::info("SMS sent successfully for Order ID: {$orderId}");
    //             } else {
    //                 Log::error("SMS sending failed for Order ID: {$orderId}. Status: {$response_sms->status()}");
    //             }
    //         }

    //         return response()->json(['message' => 'Print request sent successfully.'], 200);
    //     } catch (\Exception $e) {
    //         Log::error("Exception occurred while sending print request for Order ID: {$orderId}. Error: {$e->getMessage()}");
    //         return response()->json(['message' => 'Failed to send print request.'], 500);
    //     }
    // }

    /**
     * Utility function to strip accents from a string.
     */
    private function stripAccents($string)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    }
}
