<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Mail\CustomerReport;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Report\Earnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        $orders = Order::search();
        $totalCustomar = User::where('role_id', 2)->count();
        $totalAmount = clone $orders;
        $totalOrder = clone $orders;
        $topCustomersQuery = clone $orders;
        $topSellingOrder = clone $orders;

        $totalAmount = $totalAmount->sum('total');

        $totalOrder = $totalOrder->count();

        $topCustomers = $topCustomersQuery->select('customer_id', DB::raw('SUM(total) as total_spent'))
            ->groupBy('customer_id')
            ->orderByDesc(DB::raw('SUM(total)'))
            ->take(10)
            ->with('customer')
            ->get();

        $topSellingProducts = $topSellingOrder->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('order_product.product_id', 'products.name', 'products.price', 'categories.name as category_name', DB::raw('SUM(order_product.quantity) as total_quantity'))
            ->groupBy('order_product.product_id', 'products.name', 'products.price', 'categories.name')
            ->orderBy('total_quantity', 'desc') 
            ->limit(10)
            ->get();
        $restaurants = Restaurant::latest()->pluck('name', 'id')->toArray();

        return view('pages.report.index', compact('totalAmount', 'totalOrder', 'totalCustomar', 'topCustomers', 'topSellingProducts','restaurants'));
    }

    public function export(Request $request)
    {
        return Excel::download(new OrdersExport(), 'orders.xlsx');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function send_report(User $customer)
    {
        if ($customer->email) {
            Mail::to($customer->email)->send(new CustomerReport($customer));
            return back()->with('success', 'Email sent successfully');
        }
        return back();
    }
}
