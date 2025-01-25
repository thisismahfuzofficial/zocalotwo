<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\RestaurantZone;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Settings;

class RestaurantController extends Controller
{
    public function viewRestaurants()
    {
        $restaurants = Restaurant::latest()->get();
        return view('pages.restaurants.all-restaurant', compact('restaurants'));
    }
    public function printRestaurants()
    {
        $restaurant = Restaurant::where('id', auth()->user()->restaurant_id)->first();
        return view('pages.restaurant_print.print', compact('restaurant'));
    }
    public function createRestaurant()
    {
        $areas = RestaurantZone::all();
        return view('pages.restaurants.create', compact('areas'));
    }
    public function storeRestaurant(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        $api_key = [
            'merchantId' => $request->merchantId,
            'secretKey' => $request->secretKey,
        ];

        $restaurant = new Restaurant;

        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->email = $request->email;
        $restaurant->number = $request->number;

        $restaurant->address = $request->address;

        $restaurant->api_key = json_encode($api_key);
        $restaurant->key_version = $request->key_version;
        $restaurant->sid = $request->sid;
        $restaurant->token = $request->token;
        $restaurant->printer_id = $request->printer_id;
        $restaurant->serial_number = $request->serial_number;
        $restaurant->delivery_option = $request->delivery_option;
        $restaurant->status = $request->status;
        $restaurant->vat_number = $request->vat_number;
        $restaurant->business_name = $request->business_name;
        $restaurant->license_number = $request->license_number;
        $restaurant->business_location = $request->business_location;
        $restaurant->restaurent_code = $request->restaurent_code;

        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;

        $restaurant->enable_printer = isset($request->enable_printer);
        $restaurant->enable_payment = isset($request->enable_payment);

        $restaurant->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if ($restaurant->image && Storage::exists($restaurant->image)) {
                Storage::delete($restaurant->image);
            }
            $restaurant->image = $request->file('image')->store('restaurant', 'public');
        }

        $restaurant->save();
        return redirect(route('admin.restaurants'))->with('success', 'Restaurant Created Successfully');
    }
    public function editRestaurant(Restaurant $restaurant)
    {
        return view('pages.restaurants.edit', compact('restaurant'));
    }

    public function updateRestaurant(Request $request, Restaurant $restaurant)
    {

        if ($request->has('image')) {
            $image = $request->file('image')->store('restaurant', 'public');
            Storage::delete($request->image);
        } else {
            $image = $restaurant->image;
        }
        $api_key = [
            'merchantId' => $request->merchantId,
            'secretKey' => $request->secretKey,
            'key_version' => $request->key_version,
        ];
        $printer = [
            'sid' => $request->sid,
            'token' => $request->token,
            'printer_id' => $request->printer_id,
            'serial_number' => $request->serial_number,
        ];

        $restaurant->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $image,
            'description' => $request->description,
            'email' => $request->email,
            'number' => $request->number,
            'address' => $request->address,
            'delivery_option' => $request->delivery_option,
            // 'status' => $request->status,
            'vat_number' => $request->vat_number,
            // 'restaurent_code' => $request->restaurent_code,
            // 'business_location' => $request->business_location,
            // 'license_number' => $request->license_number,
            // 'business_name' => $request->business_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            // 'api_key' => json_encode($api_key),
            // 'printer' => json_encode($printer),
            // 'enable_printer' => isset($request->enable_printer),
            'enable_payment' => isset($request->enable_payment),
        ]);
        $restaurant->save();

        return redirect(route('admin.restaurants'))->with('success', 'Restaurant Updated Successfully');
    }
    public function destroyRestaurant(Restaurant $restaurant)
    {
        if ($restaurant->image && Storage::exists($restaurant->image)) {
            Storage::delete($restaurant->image);
        }

        $restaurant->delete();
        return redirect(route('admin.restaurants'))->with('success', 'Restaurant deleted');
    }
    public function printRestaurantOrder(Request $request, Restaurant $restaurant)
    {
        $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('fromDate'))->startOfDay();
        $toDate = Carbon::createFromFormat('Y-m-d', $request->input('toDate'))->endOfDay();
        if (auth()->user()->role_id == 3) {
            $orders = Order::whereBetween('created_at', [$fromDate, $toDate])->where('status', '!=', 'REFUND')->Where('restaurant_id', auth()->user()->restaurant_id);
        } else {
            $orders = Order::whereBetween('created_at', [$fromDate, $toDate])->where('status', '!=', 'REFUND')->where('restaurant_id', $restaurant->id);
        }


        if (!(clone $orders)->count()) {
            return back()->withErrors(['message' => 'Aucune commande trouvée pour la plage de dates sélectionnée.']);
        }

        $takeAwayOrders = (clone $orders)->where('delivery_option', 'take_away');
        $homeDeliveryOrders = (clone $orders)->where('delivery_option', 'home_delivery');
        $onlinePaymentOrder = (clone $orders)->where('payment_method', 'Card')->where('status', 'PAID');
        $codOrder = (clone $orders)->whereNotIn('payment_method', ['Card']);

        $data = [
            'total' => $orders->count(),
            'takeAwayOrders' => $takeAwayOrders->count(),
            'homeDeliveryOrders' => $homeDeliveryOrders->count(),
            'onlinePaymentOrder' => $onlinePaymentOrder->count(),
            'onlinePaymentOrder' => $onlinePaymentOrder->count(),
            'codOrder' => $codOrder->count(),
            'total_amount' => Settings::price($orders->sum(column: 'total') / 100),
            'total_tax' => Settings::price($orders->sum('tax')),
            'takeAwayOrders_amount' => Settings::price($takeAwayOrders->sum('total') / 100),
            'homeDeliveryOrders_amount' => Settings::price($homeDeliveryOrders->sum('total') / 100),
            'onlinePaymentOrder_amount' => Settings::price($onlinePaymentOrder->sum('total') / 100),
            'codOrder_amount' => Settings::price($codOrder->sum('total') / 100)
        ];


        $msg = '';

        $msg .= "<C><BOLD>{$restaurant->name}</BOLD></C>\n";
        // $msg .= "DU: {$request->fromDate} AU: {$request->toDate} \n";
        $msg .= "DU: {$fromDate->format('d-m-Y')} AU: {$toDate->format('d-m-Y')} \n";
        $msg .= "Nb total commandes: {$data['total']}\n";
        $msg .= "Montant total commandes: {$data['total_amount']}\n";
        $msg .= "Taxe totale: {$data['total_tax']}\n";
        $msg .= "Nb a emporter: {$data['takeAwayOrders']}\n";
        $msg .= "Montant à emporter: {$data['takeAwayOrders_amount']}\n";
        $msg .= "Nb livraison: {$data['homeDeliveryOrders']}\n";
        $msg .= "Montant livraison: {$data['homeDeliveryOrders_amount']}\n";
        $msg .= "--------------------------------\n";

        // Products
        $msg .= "Commandes:\n";


        $msg .= "-----------------------------------------" . "\n";
        $msg .= "#  | CODE |   HT   |   TVA   |   TTC   |  " . "\n";
        $msg .= "-----------------------------------------" . "\n";

        // $dataOrders = (clone $orders)->sum('total');

        $taxarr = (clone $orders)->get()->groupBy(function ($order) {
            return $order->getProducts()->first()->tax_percent ?? 5;
        })->map(function ($order) {
            return [
                'count' => $order->count(),
                'subtotal' => $order->sum(fn($o) => $o->sub_total) - $order->sum('tax'),
                'vat' => $order->sum('tax'),
                'extra_charge' => $order->count() * 0.95,
                'total' => $order->sum('total')
            ];
        });
        foreach ($taxarr as $key => $dataTwo) {
            $percentage = $key;
            $tax = Settings::price($dataTwo['vat']);
            $subtotal = (float) Settings::price($dataTwo['subtotal']);
            $extra_charge = (float) Settings::price($dataTwo['extra_charge']);
            $sumSubtotal = Settings::price($subtotal + $extra_charge);
            $total = Settings::price($dataTwo['total']);

            $msg .= "{$dataTwo['count']}|$percentage %  |$tax |$sumSubtotal | $total |\n";
        }

        $msg .= "----------------------------------------------\n";


        // Totals
        $msg .= "Paiement:\n";

        $msg .= "Nb PEL : {$data['onlinePaymentOrder']}\n";
        $msg .= "Montant PEL: {$data['onlinePaymentOrder_amount']}\n";
        $msg .= "Nb RESTO: {$data['codOrder']}\n";
        $msg .= "Montant RESTO: {$data['codOrder_amount']}\n";

        $msg .= "<CUT/>";
        $response = Http::withHeaders([
            'Authorization' => $restaurant->getPrinterCreds('sid') . ':' . $restaurant->getPrinterCreds('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://www.expedy.fr/api/v2/printers/' . $restaurant->getPrinterCreds('printer_id') . '/print', [
            'printer_msg' =>  $msg,
            'origin' => url('/')
        ]);

        return back()->withSuccess(['message' => 'Successfully printed']);
    }

    public function printRestaurantOrderUser(Request $request, Restaurant $restaurant)
    {
        $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('fromDate'))->startOfDay();
        $toDate = Carbon::createFromFormat('Y-m-d', $request->input('toDate'))->endOfDay();
        if (auth()->user()->role_id == 3) {
            $orders = Order::whereBetween('created_at', [$fromDate, $toDate])->where('status', '!=', 'REFUND')->Where('restaurant_id', auth()->user()->restaurant_id);
        } else {
            $orders = Order::whereBetween('created_at', [$fromDate, $toDate])->where('status', '!=', 'REFUND')->where('restaurant_id', $restaurant->id);
        }
        // dd($orders->get());


        if (!(clone $orders)->count()) {
            return back()->withErrors(['message' => 'Aucune commande trouvée pour la plage de dates sélectionnée.']);
        }

        $msg = '';
        $msg .= "DU: {$fromDate->format('d-m-Y')} AU: {$toDate->format('d-m-Y')} \n";
        $msg .= "--------------------------------\n";
        $msg .= "Commandes:\n";


        $msg .= "-----------------------------------------" . "\n";
        $msg .= "       Nom       |   Status   | Total Price |" . "\n";
        $msg .= "-----------------------------------------" . "\n";

        foreach ($orders->get() as $order) {
            $name = $order->getShipping('f_name') . ' ' . $order->getShipping('l_name');
            $orderStatus =  $order->status;
            // $orderPaymentMethod =  $order->payment_method;
            $orderTotalPrice =  $order->total;

            $msg .= "$name |   $orderStatus   |  $orderTotalPrice | \n";
        }
        // dd($name );

        $msg .= "----------------------------------------------\n";

        // dd($msg);
        $msg .= "<CUT/>";
        $response = Http::withHeaders([
            'Authorization' => $restaurant->getPrinterCreds('sid') . ':' . $restaurant->getPrinterCreds('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://www.expedy.fr/api/v2/printers/' . $restaurant->getPrinterCreds('printer_id') . '/print', [
            'printer_msg' =>  $msg,
            'origin' => url('/')
        ]);

        return back()->withSuccess(['message' => 'Successfully printed']);
    }
}
