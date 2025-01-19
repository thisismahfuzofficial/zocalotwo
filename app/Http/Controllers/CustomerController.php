<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd(User::where('role_id', 2)->withSum('orders', 'due')->get());
        // $customers = User::withSum('orders', 'due')
        //     ->when($request->due_customer == 1, function ($query) {
        //         $query->whereHas('orders', function ($query) {
        //             $query->where('due', '>', 0);
        //         });
        //     })
        //     ->latest()
        //     ->filter()
        //     ->paginate(24)
        //     ->withQueryString();
        $customers = User::latest()->filter()->paginate(24);
       

        return view('pages.customers.list', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = new User();
        $roles = Role::all();
        $restaurants  = Restaurant::all();
        return view('pages.customers.create', compact('customers', 'restaurants', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string'],
            // 'phone' => ['nullable', 'string', 'digits:11', 'unique:users,phone'],
            'email' => ['nullable', 'email'],
            // 'address' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            // 'discount' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            // 'gender' => $request->gender,
            'role_id' =>$request->role_id ?? 2,
            // 'discount' => $request->discount ?? 0,
            'password' => $request->password ? Hash::make($request->password) : Hash::make('password'),
            'restaurant_id' => $request->restaurant_id,
        ]);
        // dd($request->password);
        // if ($request->password) {
        //     $user->update([
        //         'password' => bcrypt($request->password),
        //     ]);
        // }
        return redirect()->route('customers.index')->with('success', 'Customers Added Success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        if (request()->form && request()->to) {
            $orders = $customer->orders->whereBetween('created_at', [request()->form, request()->to]);
        } else {
            $orders = $customer->orders;
        }
        // dd($customer);
        $transactions = Transaction::where('user_id', $customer->id)->latest()->get();
        // dd($customer);
        return view('pages.customers.invoice', compact('customer', 'orders', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        $roles = Role::all();
        $restaurants  = Restaurant::all();
        return view('pages.customers.edit', compact('customer','roles', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        
        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string', Rule::unique('users')->ignore($customer->id)],
            'email' => ['nullable', 'string'],
            
        ]);
        $customer->update([
            'name' => $request->name,
            'role_id' =>$request->role_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'restaurant_id' => $request->restaurant_id,
        ]);

        if ($request->password) {
            $customer->update([
                'password' => bcrypt($request->password),
            ]);
        }
        return back()->with('success', 'Customer Edit Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer Delete Success!');
    }

    public function deposite_full($customer, Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);
        $orders = Order::where('customer_id', $customer)->where('due', '>', 0)->orderBy('due', 'desc')->get();
        if (!$orders) {
            return back()->withErrors('This customer does not have any due orders');
        }
        Transaction::create([
            'user_id' => $customer,
            'amount' => $request->amount
        ]);
        $amountRemaining = $request->amount;

        foreach ($orders as $order) {
            $due = $order->due;
            if ($amountRemaining >= $order->due) {

                $order->paid = $order->paid + $order->due;
                $order->due = 0;
                $order->status = 'PAID';
                $order->save();
                $amountRemaining -= $due;
            } else {
                if ($amountRemaining > 0) {
                    $order->paid = $order->paid + $amountRemaining;
                    $order->due = $order->due - $amountRemaining;
                    $order->status = 'DUE';
                    $order->save();
                    $amountRemaining = 0;
                }
            }
        }
        return back()->with('success', 'Deposite success!');
    }
    public function dashboardForCustomer()
    {
        $user = auth()->user();
        return view('pages.customers.infoDeleteDashboard', compact('user'));
    }
    public function customerInfoDelete()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Set email and phone to null
        $user->email = null;
        $user->phone = null;
        $user->save();

        // Revoke all of the user's tokens
        $user->tokens()->delete();

        // Optionally, you can logout the user
        Auth::logout();

        // Redirect the user to a confirmation page or wherever you need
        return redirect()->route('login')->with('success', 'Your account has been deleted successfully. You have been logged out from all devices.');
    }

    public function customerDelete()
    {
        return view('pages.customers.infoDeleteCustomer');
    }

    public function exportUsers()
{
    return Excel::download(new UsersExport, 'customers.xlsx');
}
}
