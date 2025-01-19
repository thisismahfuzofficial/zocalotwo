<?php

namespace App\Http\Controllers;


use App\Mail\OrderConfirmationMail;
use App\Mail\PurchasesMailForShopOwner;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Generic;
use App\Models\Order;
use App\Models\Priscription;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Settings;

class ApiController extends Controller
{


    public function pos(Request $request)
    {
        $products = Product::when(Settings::option('manageStock') == 1, function ($query) {
            return $query->has('batches');
        })->mostSold()
            ->when($request->categoriesInput, function ($query) use ($request) {
                $categories = is_array($request->categoriesInput) ? $request->categoriesInput : explode(',', $request->categoriesInput);
                $query->whereIn('category_id', $categories);
            })
            ->when($request->suppliersInput, function ($query) use ($request) {
                $suppliers = is_array($request->suppliersInput) ? $request->suppliersInput : explode(',', $request->suppliersInput);
                $query->whereIn('supplier_id', $suppliers);
            })
            ->when($request->genericsInput, function ($query) use ($request) {
                $generics = is_array($request->genericsInput) ? $request->genericsInput : explode(',', $request->genericsInput);
                $query->whereIn('generic_id', $generics);
            })

            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->search%")
                    ->orWhere('sku', 'LIKE', "%$request->search%")
                    ->where(function ($query) use ($request) {
                        $query->whereHas('generic', function ($query) use ($request) {
                            $query->where('name', 'LIKE', "%$request->search%");
                        })
                            ->orWhereHas('supplier', function ($query) use ($request) {
                                $query->where('name', 'LIKE', "%$request->search%");
                            })
                            ->orWhereHas('category', function ($query) use ($request) {
                                $query->where('name', 'LIKE', "%$request->search%");
                            });
                    })->orderByRaw("CASE WHEN name = '$request->search' THEN 1 ELSE 2 END");
            })
            ->paginate(24);
        return response()->json($products);
    }
    public function products(Request $request)
    {
        $request->validate(['q' => 'required']);

        $query = Product::where('name', 'LIKE', '%' . $request->input('q') . '%');

        if (Settings::option('manageStock') == 1) {
            $query->has('batches');
        }

        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'text' => $product->name . ' ' . $product->strength . ' ' . $product->category->name
            ];
        });

        return response()->json($products);
    }
    public function customers(Request $request)
    {
        $customers = User::where('name', 'LIKE', '%' . $request->input('q') . '%')->orWhere('phone', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($customer) {
            return [
                'id' => $customer->id,
                'text' => $customer->phone . ' (' . $customer->name . ')' . ' (' . $customer->address . ')',
            ];
        })->toArray();


        return response()->json($customers);
    }

    public function singleCustomer(Request $request)
    {
        $request->validate(['id' => 'required']);
        $customer = User::where('id', $request->id)->firstOrFail();
        return response()->json($customer);
    }
    public function suppliers(Request $request)
    {
        return Supplier::where('name', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($supplier) {
            return [
                'id' => $supplier->id,
                'text' => $supplier->name
            ];
        });
    }
    public function generics(Request $request)
    {
        return Generic::where('name', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($generic) {

            return [
                'id' => $generic->id,
                'text' => $generic->name
            ];
        });
    }
    public function categories(Request $request)
    {
        return Category::where('name', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($category) {

            return [
                'id' => $category->id,
                'text' => $category->name
            ];
        });
    }
    public function orderCreate(Request $request)
    {
        $emailTo = Settings::option('email');
        $data = [];
        foreach ($request->cartInfo['products'] as $id => $product) {
            $data[$id] = [
                'product_id' => $product['id'], // Assuming 'id' is the correct key for the product_id
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'profit' => 0,
            ];
        }

        if ($request->cartInfo['discount'] > $request->cartInfo['sub_total'] * .12) {
            $discount = $request->cartInfo['sub_total'] * .10;
        } else {
            $discount = $request->cartInfo['discount'];
        }
        $subTotal = $request->cartInfo['sub_total'];
        $total = $subTotal - ($discount ?? 0);

        $paid = $request->paymentInfo['received_amount'] - $request->paymentInfo['change_amount'];
        $due = $total - $paid;

        $orderData = [
            'sub_total' => $request->cartInfo['sub_total'],
            'discount' => $discount,
            'total' => $total,
            'payment_method' => $request->paymentInfo['type'],
            'paid' => $paid,
            'due' => $due,
            'notes' => $request->paymentInfo['notes'],
            'status' => $request->paymentInfo['status'],
            'profit' => 0,
        ];

        if (isset($request->paymentInfo['customer_id'])) {
            $orderData['customer_id'] = $request->paymentInfo['customer_id'];
        } else {
            if ($due > 0) {
                $errorMessage = "Walk in customers cannot keep due.";
                return response()->json(['error' => $errorMessage], 400);
            }
        }

        $order = Order::create($orderData);

        $order->products()->sync($data);
        $profit = 0;
        foreach ($order->products as $product) {
            $profit += ($product->pivot->price - $product->trade_price) * $product->pivot->quantity;
            $product->sold_unit = $product->sold_unit + $product->pivot->quantity;
            $product->save();
        }

        $profit -= $order->discount;

        $order->profit = $profit;
        $order->save();

        try {
            Mail::to($emailTo)->send(new PurchasesMailForShopOwner($order));
            if (isset($request->cartInfo['order_from'])) {
                $order->order_from = $request->cartInfo['order_from'];
                $order->delivered = 0;
                $order->save();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email.']);
        }
        if ($order->customer_id && $order->customer->email) {
            $customerEmailTo = $order->customer->email;

            try {
                Mail::to($customerEmailTo)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to send email to customer.']);
            }
        }
        return response()->json(['success' => 'Order created successfully ' . $order->id]);
    }
    public function customerCreate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'digits:11', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['nullable', 'string', 'email'],
            'address' => ['required', 'string'],
        ]);
        $data = $request->only('name', 'email', 'phone', 'address', 'discount');
        $data['role_id'] = 2;
        User::create($data);
        return response()->json([
            $message = 'Customer created successfully'
        ]);
    }

    public function prescription(Request $request)
    {
        $prescription = Priscription::with('products', 'customer')->find($request->prescription);

        return $prescription;
    }
    public function reports(Request $request)
    {
        $orders = Order::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('restaurant_id', auth()->user()->restaurant_id);
        })->filterByDate()->get();
        $due_orders = Order::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('restaurant_id', auth()->user()->restaurant_id);
        })->filterByDate()->where('due', '>', 0)->get();
        $customers = User::where('role_id', 2)->with(['orders' => function ($query) {
            $query->when(auth()->user()->role_id == 3, function ($query) {
                $query->where('restaurant_id', auth()->user()->restaurant_id);
            });
        }])->get();
        $categories = Category::get();
        $top_customers = User::where('role_id', 2)->with(['orders' => function ($query) {
            $query->when(auth()->user()->role_id == 3, function ($query) {
                $query->where('restaurant_id', auth()->user()->restaurant_id);
            })->filterByDate();
        }])
            ->get()
            ->sortByDesc(function ($customer) {
                return $customer->orders->when(auth()->user()->role_id == 3, function ($query) {
                    $query->where('restaurant_id', auth()->user()->restaurant_id);
                })->sum('total');
            })
            ->take(10);

        $top_products = Product::with(['orders' => function ($query) {
            $query->filterByDate('orders.created_at');
        }])
            ->get()
            ->sortByDesc(function ($product) {
                return $product->orders->sum('pivot.price');
            })
            ->take(10);




        $mapCustomer = function ($customer) {
            return [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'total_order_amount' => $customer->orders->sum('total'),
            ];
        };

        $mapProduct = function ($product) {
            return [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_strenght' => $product->strenght,
                'product_category' => $product->category->name,
                'total_price' => $product->orders->sum('pivot.price'),
            ];
        };



        return response()->json([
            'total_orders' => $orders->count(),
            'total_amount' => $orders->sum('total'),
            'due_orders' => $due_orders->count(),
            'due_total' => $due_orders->sum('due'),
            'total_revenue' => $orders->sum('profit'),
            'total_customers' => $customers->count(),
            'total_generics' => 0,
            'total_categories' => $categories->count(),
            'total_suppliers' => [],
            'top_customers' => $top_customers->map($mapCustomer)->values(),
            'top_selling_products' => $top_products->map($mapProduct)->values(),
            'top_suppliers' => [],
            'top_due_customers' => [],
        ]);
    }
}
