<?php

use App\Facades\Settings\SettingsFacade;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpedyController;
use App\Http\Controllers\GenericsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\PriscriptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ScrapController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ZoneController;
use App\Mail\ContactFormMail;
use App\Mail\CustomerReport;
use App\Mail\DueClearReminder;
use App\Mail\DuePaidMail;
use App\Mail\MonthlyDueReport;
use App\Mail\OrderConfirmationMail;
use App\Mail\PurchasesMailForShopOwner;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\User;
use App\Models\Order;
use App\Models\Restaurant;
use App\Services\Payment;
use App\Services\PrinterService;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\ScrapController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/admin/dashboard', function () {
//     dd(auth()->user());
// });

Auth::routes();
// https://youtu.be/e3h0KVyypvk?si=Mz7GqdNLEv6doNE4
//user routes

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'userIndex')->name('restaurant.home');
    Route::get('/menu/{slug}', 'menu')->name('restaurant.menu');
    Route::get('/product/{restaurant}/{product}', 'singleProduct')->name('single.restaurant');
    Route::get('/restaurants', 'restaurant')->name('user.restaurants');
    Route::get('/check-out', 'userCheckOut')->name('restaurant.checkout');
    Route::get('/contact', 'contact')->name('restaurant.contact');
    Route::get('/cart', 'cart')->name('restaurant.cart');
    Route::post('/check-location', 'checkLocation')->name('check.location');
    Route::get('/thank-you', 'thank_you')->name('thank_you');
    Route::get('/pages/{page}', 'pageView')->name('pages.view');
    Route::get('/restaurant/recruitment/', 'recruitment')->name('restaurant.recruitment');
    Route::post('/contact/send', 'contactMail')->name('contact.mail');
    Route::post('/recrutment/send', 'recrutmentMail')->name('recrutment.mail');

    /// new pages
    Route::get('/order-online', 'OrderOnline')->name('page.order-online');
    Route::post('/order/data', 'OrderOnlineData')->name('page.order-online-data');
    Route::get('/order/restaurants', 'OrderRestaurants')->name('order.restaurants');


    Route::get('/orders/payment/{order}', [PaymentController::class, 'showPaymentGateway'])->name('user.orders.payment.index');
    Route::post('/orders/payment/complete/{order}', [PaymentController::class, 'completePayment'])->name('user.orders.payment.complete');

    // Route::get('/contact', 'contact')->name('contact');
    // Route::get('/cart', 'cart')->name('cart');
    // Route::get('/check-out', 'checkOut')->name('checkout');

});

//cart routes
Route::post('/add-cart', [CartController::class, 'add'])->name('cart.store');
Route::post('/add-extra', [CartController::class, 'addExtra'])->name('extra.store');
Route::post('/buynow', [CartController::class, 'buynow'])->name('cart.buynow');
Route::post('/add-update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/update-variation', [CartController::class, 'updateVaritaiton'])->name('cart.variation');
Route::get('/cart-destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/extras', [CartController::class, 'extras'])->name('extras');
Route::get('/invoice/{order}', [PageController::class, 'invoice'])->name('invoice');

Route::post('/store-in-session', [PageController::class, 'storeInSession'])->name('store-in-session');

Route::get('/zones', [ZoneController::class, 'fetchZones']);
Route::post('/save-location', [PageController::class, 'saveLocation'])->name('save.location');
Route::post('/location-store', [PageController::class, 'store'])->name('location.store');
Route::patch('/time-update', [PageController::class, 'updateTime'])->name('time_update');


Route::get('/get-google-maps-api-key', function () {
    return response()->json(config('services.google_maps.api_key'));
});
// Route::get('/test', function () {
//     return view('test');
// });

// Route::get('/testProduct', function () {
//     $order = Order::latest()->first();
//     $printing = (new PrinterService($order))->sendToPrinter();
//     dd($printing);
//     dd($order->restaurent->getPaymentCreds('secretKey'));
//     return Payment::make($order);
// });

//order routes
Route::post('/order-update', [OrderController::class, 'store'])->name('order_store');

//pos backend routes

Route::get('snapshop/customer/delete', [CustomerController::class, 'customerDelete'])->name('customer.delete');
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/snapshop/customer/Dashaboard', [CustomerController::class, 'dashboardForCustomer'])->name('customer.dashboard');
    Route::post('/customer/Dashaboard', [CustomerController::class, 'customerInfoDelete'])->name('customer.infoDelete');
});



Route::middleware(['auth', 'role:1,3'])->group(function () {
    Route::get('/get-chart-data', [OrderController::class, 'getChartData']);
    Route::get('/get-chart-data-month', [OrderController::class, 'getChartDataMonth']);
});
Route::middleware(['auth', 'role:1'])->group(function () {

    Route::group(
        [
            'as' => 'products.',
            'prefix' => 'products',
            'controller' => ProductController::class
        ],
        function () {
            Route::get('edit/{product}', 'edit')->name('edit');
            // Route::get('create', 'create')->name('create');
            Route::get('create-or-edit/{product?}', 'createOrEdit')->name('createOrEdit');
            Route::post('duplicate', 'duplicateProduct')->name('duplicate');
            Route::post('save/{product?}', 'save')->name('save');
            // Route::get('list', 'index')->name('index');
            Route::delete('delete/{product}', 'destroy')->name('delete');
        }
    );

    Route::resource('generics', GenericsController::class);

    Route::post('deposite-full/{user}', [CustomerController::class, 'deposite_full'])->name('deposite.full');
    // Route::get('/invoice/{customer}', [CustomerController::class, 'invoice'])->name('invoice');
    // Route::get('/point-of-sale', [POSController::class, 'index'])->name('pos');
    // Route::view('react-component', 'react-component');

    Route::resource('purchase', PurchaseController::class)->names('purchase');
    Route::resource('units', UnitController::class)->names('units');
    Route::resource('suppliers', SupplierController::class)->parameters(['suppliers' => 'supplier'])->names('suppliers');



    // Route::resource('settings', SettingController::class);
    // Route::resource('priscription', PriscriptionController::class);

    Route::post('change-password', [SettingController::class, 'changePassword'])->name('settings.change-password');



    Route::post('/customer/store', [POSController::class, 'customerStore'])->name('customer.store');
    Route::get('purchase/invoice/{purchase}', [PurchaseController::class, 'invoice'])->name('purchase.invoice');

    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('send-reports/{customer}', [ReportsController::class, 'send_report'])->name('reports.send');
    // Route::get('scrap', [ScrapController::class, 'scrap'])->name('scrap');
    Route::get('/test-email', function () {
        $customers = User::where('role_id', 2)->where(function ($query) {
            $query->whereNull('last_reminder_date')
                ->orWhere('last_reminder_date', '<=', now()->subDays(30));
        })
            ->whereHas('orders', function ($query) {
                $query->where('due', '>', 0);
            })
            ->whereNotNull('email')
            ->take(10)
            ->get();
        foreach ($customers as $customer) {

            $orders = $customer->orders()->where('due', '>', 0)->get();
            if ($customer->email) {
                return (new DueClearReminder($orders, $customer));
                $customer->update(['last_reminder_date' => now()]);
            }
        }
    });
});
Route::post('payment/{restaurant:slug}/callback', function (Restaurant $restaurant, Request $request) {
    // Extract and validate response data

    $data = $request->input('Data');
    $seal = $request->input('Seal');
    return Payment::confirm(restaurant: $restaurant, data: $data, seal: $seal);
})->name('payment.callback');


Route::get('/test', function () {
    $order = Order::latest()->first();
    return Payment::make($order);
});



// Route::get('/test2', function () {
//     $products = Product::all();
//     foreach ($products as $product) {
//         $product->price = $product->price * 100;
//         $product->save();
//     }
// });
require('sushi_old.php');
require('admin.php');
require('user.php');

Route::get('test-payment', [PaymentController::class, 'index']);
Route::get('test-email', [PaymentController::class, 'email']);
Route::get('test-printer', [ExpedyController::class, 'sendToPrinter']);

Route::post('api/reports', action: [ApiController::class, 'reports'])->middleware(['auth', 'role:1,3']);
