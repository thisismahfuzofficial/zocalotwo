<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Mail\RecruitmentMail;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Restaurant;
use App\Models\Slider;
use App\Models\SliderImage;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Attachment;
use App\Models\TimeSchedule;
use Cart;
use Carbon\Carbon;
use Darryldecode\Cart\Cart as CartCart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function userIndex()
    {
        $restaurants = Restaurant::latest()->take(6)->get();

        $zones = Zone::with('restaurants')->get();
        $sliders = Slider::all();
        return view('user.home', compact('restaurants', 'zones', 'sliders'));
    }

    private function getTimeRanges($restaurantId, $dayOfWeek)
    {

        $timeRanges = [
            4 => [
                Carbon::FRIDAY => [['start' => '15:00', 'end' => '18:00']], // Friday:  3:00 PM - 6:00 PM
                'default' => [['start' => '11:00', 'end' => '23:00']], // Saturday to Thursday: 11:00 AM - 11:00 PM
            ],
            5 => [
                Carbon::FRIDAY => [['start' => '18:00', 'end' => '23:00']], // Friday: 6:00 PM - 11:00 PM
                'default' => [ // Split into morning and evening
                    ['start' => '11:00', 'end' => '15:00'], // 11:00 AM - 3:00 PM
                    ['start' => '18:00', 'end' => '23:00'], // 6:00 PM - 11:00 PM
                ],
            ],
            6 => [
                Carbon::FRIDAY => [['start' => '18:00', 'end' => '23:00']], // Friday: 6:00 PM - 11:00 PM
                'default' => [ // Split into morning and evening
                    ['start' => '11:00', 'end' => '15:00'], // 11:00 AM - 3:00 PM
                    ['start' => '18:00', 'end' => '23:00'], // 6:00 PM - 11:00 PM
                ],
            ],
        ];

        // Return time ranges based on restaurant and day, or a default schedule
        return $timeRanges[$restaurantId][$dayOfWeek] ?? $timeRanges[$restaurantId]['default'] ?? [['start' => '11:00', 'end' => '23:00']];
    }

    private function generateTimeSlots($startTime, $endTime, $currentTime, &$timeSlots)
    {
        // Generate slots for all time ranges irrespective of current time range
        for ($time = $startTime; $time->lte($endTime); $time->addMinutes(45)) {
            $endSlot = $time->copy()->addMinutes(30);
            if ($time->gte($currentTime) || $endSlot->gt($currentTime)) {
                $timeSlots[] = $time->format('H:i') . ' - ' . $endSlot->format('H:i');
            }
        }
    }


    public function menu($slug)
    {
        // Cache the restaurant and categories to avoid hitting the database multiple times
        Cache::flush();
        $cacheKey = 'restaurant_menu_' . $slug;
        $menuData = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($slug) {
            $restaurant = Restaurant::where('slug', $slug)->first();
            if (!$restaurant) {
                abort(404); // Handle the case where the restaurant is not found
            }

            $categories = Category::whereNull('parent_id')
                ->orderBy('sequency', 'asc')
                ->with('childs', 'products')
                ->get();
            $subCategories = Category::whereNotNull('parent_id')->get();

            return compact('restaurant', 'categories', 'subCategories');
        });

        $restaurant = $menuData['restaurant'];
        $categories = $menuData['categories'];
        $subCategories = $menuData['subCategories'];

        // Cache the time slots
        $restaurantId = $restaurant->id;
        $currentTime = Carbon::now('Europe/Paris')->startOfMinute();
        $dayOfWeek = $currentTime->dayOfWeek;

        $timeSlotsCacheKey = 'restaurant_time_slots_' . $restaurantId . '_' . $dayOfWeek;
        $timeSlots = Cache::remember($timeSlotsCacheKey, now()->addMinutes(60), function () use ($restaurantId, $dayOfWeek, $currentTime) {
            $timeSlots = [];
            $timeRanges = $this->getTimeRanges($restaurantId, $dayOfWeek);

            foreach ((array) $timeRanges as $range) {
                $startTime = Carbon::createFromTimeString($range['start'], 'Europe/Paris');
                $endTime = Carbon::createFromTimeString($range['end'], 'Europe/Paris');
                $this->generateTimeSlots($startTime, $endTime, $currentTime, $timeSlots);
            }
            return $timeSlots;
        });
        // dd(getTimeRanges());
        return view('user.menu', compact('categories', 'subCategories', 'restaurant', 'timeSlots'));
    }
    public function userCheckout()
    {
        if(Cart::getTotalQuantity() == 0){
            return redirect(url('/'));
        }
        $restaurant = Restaurant::find(session()->get('restaurent_id'));

        $restaurantId = $restaurant->id;
        $currentTime = Carbon::now('Europe/Paris')->startOfMinute();
        $dayOfWeek = $currentTime->dayOfWeek;

        $timeSlots = [];
        $timeRanges = $this->getTimeRanges($restaurantId, $dayOfWeek);

        foreach ((array) $timeRanges as $range) {

            $startTime = Carbon::createFromTimeString($range['start'], 'Europe/Paris');
            $endTime = Carbon::createFromTimeString($range['end'], 'Europe/Paris');
            $this->generateTimeSlots($startTime, $endTime, $currentTime, $timeSlots);
        }

        return view('user.checkout', compact('timeSlots'));
    }

    public function singleProduct($restaurant, Product $product)
    {
        $restaurant = Restaurant::where('slug', $restaurant)->first();
        $productOption = ProductOption::where('product_id', $product->id)->get();

        return view('user.single-product', compact('product', 'restaurant', 'productOption'));
    }
    public function restaurant()
    {
        $restaurants = Restaurant::all();
        return view('user.restaurant', compact('restaurants'));
    }
    public function contact()
    {
        $time_schedules = TimeSchedule::all();
        return view('user.contact', compact('time_schedules'));
    }
    public function userLogin()
    {
        return view('user.auth.login');
    }
    public function userRegister()
    {
        return view('user.auth.register');
    }
    public function thank_you()
    {
        return view('thank_you');
    }

    public function cart()
    {
        // dd(Cart::getContent());

        if (Cart::getContent()->count() == 0) {

            return redirect()->route('user.restaurants')->withErrors('hello');
        } else {
            $extras = Extra::latest()->where('type', 'cart')->get();
            $relatedProductsQuery = Product::whereHas('category', function ($q) {
                return $q->where('featured', 'checked');
            })->get();
            $relatedProducts = $relatedProductsQuery->sortBy('count')->reverse()->groupBy('category_id')->map(function ($product) {

                $categoryName = $product->first()->category->name;

                return [
                    'category_name' => $categoryName,
                    'products' => $product,
                ];
            });




            return view('user.cart', compact('extras', 'relatedProducts'));
        }
    }
    public function checkLocation(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        // dd($latitude);
        $radius = 5;


        $zone = Restaurant::select('*')
            ->selectRaw('
            ( 6371 * acos(
                cos( radians(?) ) * cos( radians(JSON_UNQUOTE(JSON_EXTRACT(address, "$.latitude")) ) )
                * cos( radians(JSON_UNQUOTE(JSON_EXTRACT(address, "$.longitude"))) - radians(?) )
                + sin( radians(?) ) * sin( radians(JSON_UNQUOTE(JSON_EXTRACT(address, "$.latitude"))) )
            )
            ) AS distance', [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->first();


        if ($zone) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('restaurant.menu', ['slug' => $zone->slug]),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No restaurants found in this zone.',
            ]);
        }
    }
    public function adminPages()
    {
        $pages = Page::all();
        return view('pages.pages.pageslist', compact('pages'));
    }
    public function pagesCreate()
    {
        return view('pages.pages.create');
    }
    public function pagesStore(Request $request)
    {
        $page = new Page;
        $page->title = $request->title;
        $page->slug = Str::slug($request->title);
        $page->body = $request->body;
        $page->save();
        return redirect(route('admin.pages'))->with('success', 'page added successfully');
    }
    public function destroyPage(Page $page)
    {
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted');
    }
    public function pagesEdit(Page $page)
    {
        return view('pages.pages.edit', compact('page'));
    }
    public function pagesUpdate(Request $request, Page $page)
    {
        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
        ]);
        $page->save();
        return redirect(route('admin.pages'))->with('success', 'Pages Updated Successfully');
    }
    public function pageView($page)
    {
        $data = Page::where('slug', $page)->first();

        return view('pages.pages.page', compact('data'));
    }
    public function contactMail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => $request->subject,
        ];
        Mail::to('contact@gmail.com')->send(new ContactFormMail($data));

        return back()->with('success', 'Thank you for contacting us!');
    }

    public function invoice(Order $order)
    {
        return view('user-dashboard.invoice', compact('order'));
    }
    public function recruitment()
    {
        return view('user.recruitment');
    }

    public function recrutmentMail(Request $request)
    {
        // Validate the request, including the PDF file
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'city' => 'required|string',
            'terget_position' => 'required|string',
            'cv_file' => 'required', // Validate the file as a PDF with a max size of 2MB
        ]);
        $pdf = $request->file('cv_file');
        $path = $pdf->storeAs('pdfs', $pdf->getClientOriginalName());

        // Prepare the data for the email
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'city' => $request->city,
            'terget_position' => $request->terget_position,
            'cv_file' => $path,
        ];


        // Send the email with the attached file
        Mail::to('recrutement-centralsushi@hotmail.com')->send(new RecruitmentMail($data));

        return back()->with('success',"{{ __('sentence.thank_you_for_contacting_us') }}");
    }

    public function storeInSession(Request $request)
    {
        // Store the received data in the session
        if ($request->has('longitude')) {
            Session::put('longitude', $request->input('longitude'));
        }
        
        if ($request->has('latitude')) {
            Session::put('latitude', $request->input('latitude'));
        }
        
        if ($request->has('method')) {
            Session::put('method', $request->input('method'));
        }
        
        if ($request->has('restaurant')) {
            Session::put('restaurant', $request->input('restaurant'));
        }
        
        if ($request->has('address')) {
            Session::put('address', $request->input('address'));
        }
        if ($request->has('city')) {
            Session::put('city', $request->input('city'));
        }
        if ($request->has('postalCode')) {
            Session::put('postalCode', $request->input('postalCode'));
        }
        
        $restaurant = Restaurant::find($request->input('restaurant'));
        return response()->json(['success' => true, 'restaurant'=>$restaurant]);
    }


    public function updateTime(Request $request)
    {
        $validated = $request->validate([
            'TimeOption' => 'required',
        ]);

        $selectedTime = $validated['TimeOption'];
        if (Session::has('delivery_time')) {
            Session::forget('delivery_time');
        }
        Session::put('delivery_time', [$selectedTime]);
        return redirect()->back();
    }
}
