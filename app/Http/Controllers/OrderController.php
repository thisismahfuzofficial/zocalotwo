<?php

namespace App\Http\Controllers;

use App\Mail\DuePaidMail;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Transaction;
use App\Report\Earnings;
use App\Services\Payment;
use App\Services\PrinterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\DistanceService;
use Cart;
use Settings;

class OrderController extends Controller
{

    protected $distanceService;

    public function __construct(DistanceService $distanceService)
    {
        $this->distanceService = $distanceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Order::latest()->search();

        if ($user->role_id == 3) {
            $query->where('restaurant_id', $user->restaurant_id);
        }

        $allOrderCount = $query->get();

        $orders = $query->paginate(20)->withQueryString();

        $paidOrderCount = $query->where('status', 'PAID')->get();
        $unpaidOrderCount = $query->where('status', 'UNPAID')->get();
        $dueOrderCount = $query->where('status', 'DUE')->get();

        $restaurants = Restaurant::all();

        $data = [
            'total' => [
                'count' => $allOrderCount->count(),
                'sum' => $allOrderCount->sum('total')
            ],
            'paid' => [
                'count' => $paidOrderCount->count(),
                'sum' => $paidOrderCount->sum('total')
            ],
            'unpaid' => [
                'count' => $unpaidOrderCount->count(),
                'sum' => $unpaidOrderCount->sum('total')
            ],
            'due' => [
                'count' => $dueOrderCount->count(),
                'sum' => $dueOrderCount->sum('total')
            ]
        ];

        $restaurantsAll = Restaurant::latest()->pluck('name', 'id')->toArray();

        return view('pages.orders.list', compact('orders', 'data', 'restaurants', 'restaurantsAll'));
    }

    public function getChartData()
    {
        $eranings = Earnings::range(now()->subDays(15), now()->startOfDay())->graph();

        return response()->json(data: ['data' => $eranings]);
    }
    public function expedy_print(Order $order)
    {
        (new PrinterService($order))->sendToPrinter();
        return back()->with('success', 'Request Send to printer');
    }
    public function getChartDataMonth()
    {
        $earnings = collect(Earnings::range(now()->subMonths(12), to: now())->graph('Month'))->groupBy('month')->map(fn($earning) => $earning->first());





        if (count($earnings) > 0) {
            $months = [
                'October' => 9,
                'November' => 10,
                'December' => 11,
                'January' => 0,
                'February' => 1,
                'March' => 2,
                'April' => 3,
                'May' => 4,
                'June' => 5,
                'July' => 6,
                'August' => 7,
                'September' => 8,
            ];
            $currentMonth = date('n');

            $months = array_merge(array_slice($months, $currentMonth), array_slice($months, 0, $currentMonth));

            $data = [
                'sales' => [],
                'profit' => [],
            ];


            foreach ($months as $month) {

                $data['sales'][$month] = $earnings[array_search($month,$months)]['sales'] ?? 0;
                $data['profit'][$month] = $earnings[array_search($month,$months)]['total_profit'] ?? 0;
            }
        } else {
            $data = ['sales' => [], 'profit' => []];
        }
         ksort($data['sales']);
         ksort($data['profit']);


        return response()->json(['data' => $data]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (Cart::getTotalQuantity() == 0) {
            return redirect(url('/'));
        }
        $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
        ]);


        DB::beginTransaction();

        $firstItem = Cart::getContent()->last();
        $restaurant = $firstItem ? Restaurant::find($firstItem->attributes->restaurent) : null;
        $shipping = $request->only(['f_name', 'l_name', 'email', 'address', 'phone']);
        $infoRestaurant = session('info_restaurant');
        $orderType = $infoRestaurant['order_type'];
        // dd($restaurant);
        // $extra_charge = Settings::setting('extra.charge');

        $order = Order::create([
            'customer_id' => auth()->check() ? auth()->id() : null,
            'shipping_info' => json_encode($shipping),
            'sub_total' => Cart::getSubTotal(),
            'total' => Cart::getTotal(),
            // 'tax' => Settings::totalTax(),
            'comment' => $request->input('commment'),
            'time_option' => $request->delivery_time,
            'payment_method' => $request->input('payment_method'),
            'delivery_option' =>  $orderType,
            'restaurant_id' => $restaurant->id,
        ]);

        // $extra = [];
        // foreach (Cart::getContent() as $item) {
        //     if (isset($item->attributes['options'])) {
        //         $options = $item->attributes['options'];
        //     } else {
        //         $options = null;
        //     }

        //     if (isset($item->attributes['product'])) {
        //         $order->products()->attach($item->attributes['product']->id, [
        //             'quantity' => $item->quantity,
        //             'price' => $item->price,
        //             'options' => $options,
        //             'tax_amount' => Settings::itemTax($item->price, $item->attributes['tax'], $item->quantity),
        //             'tax_percentage' => $item->attributes['tax']
        //         ]);
        //     }

        //     if (isset($item->attributes['extra'])) {
        //         $extra[] = [
        //             'id' => $item->id,
        //             'name' => $item->name,
        //             'price' => $item->price,
        //             'quantity' => $item->quantity,
        //             'tax_amount' => Settings::itemTax($item->price, $item->attributes['tax'], $item->quantity),
        //             'tax_percentage' => $item->attributes['tax']
        //         ];
        //     }
        // }
        // if (!empty($extra)) {
        //     $order->update([
        //         'extra' => json_encode($extra),
        //     ]);
        // }

        DB::commit();

        session()->forget('info_restaurant');
        Cart::clear();


        return Payment::make($order);
    }






    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
    public function invoice(Order $order)
    {
        return view('pages.orders.invoice', compact('order'));
    }
    public function errorpage()
    {
        return view('pages.errorPage.404');
    }
    public function duepay(Request $request)
    {
        $amount = $request->amount;
        $order = Order::find($request->order_id);
        if ($order->due >= $request->amount) {
            Transaction::create([
                'order_id' => $order->id,
                'amount' => $request->amount,
            ]);
            $order->update([
                'paid' => $order->paid + $request->amount,
                'due' => $order->due - $request->amount,
            ]);
            if ($order->due == 0) {
                $order->update([
                    'status' => 'PAID',
                ]);
            }
            if ($order->customer_id && $order->customer->email) {
                $customerEmailTo = $order->customer->email;

                try {
                    Mail::to($customerEmailTo)->send(new DuePaidMail($order, $amount));
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to send email to customer.']);
                }
            }
            // dd($order);
            return back()->with('success', 'Transaction create successfully');
        } else {
            return back()->withErrors('Transaction amount grater, then order due');
        }
    }
    public function mark_pay(Request $request)
    {
        // dd($request->orders);
        if ($request->orders == !null) {
            foreach ($request->orders as $item) {
                $order = Order::findOrFail($item);
                $order->update([
                    'status' => 'PAID',
                    'payment_status' => 'PAID',
                ]);
            }
            return back()->with('success', 'Mark as paid successfuly complete');
        } else {
            return back()->withErrors('Please at least one item select');
        }
    }

    public function mark_refund(Order $order)
    {
        // dd($order);
        $order->update([
            'status' => 'REFUND',
            'payment_status' => 'failed',
        ]);
        return back()->with('success', 'REFUND successfuly complete');
    }
    public function mark_delivered(Order $order)
    {
        $order->update([
            'delivered' => 1,
            'status' => 'PAID',
            'payment_status' => 'PAID',
        ]);
        return back()->with('success', 'Order marked as delivered successfully');
    }
}
