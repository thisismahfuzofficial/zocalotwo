<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

	public function add(Request $request)
	{
        $product = Product::find($request->product_id);
		$price = $product->price;

		Cart::add($product->id, $product->name, $price, $request->quantity, ['restaurent' => $request->restaurent_id]);

		return back();
	}


	public function update(Request $request)
	{
		Cart::update($request->product_id, array(
			'quantity' => array(
				'relative' => false,
				'value' => (int)$request->quantity
			),

		));
		return redirect()->back();
	}
	public function destroy($id)
	{

		if (Cart::getContent()->filter(fn($cart, $key) => is_numeric($key))->count() == 1) {


			Cart::clear();

			session()->forget(['current_location', 'delivery_time', 'restaurent_id', 'address', 'restaurant', 'method', 'longitude', 'latitude', 'city', 'postalCode']);

		} else {

			Cart::remove($id);
		}
		return back();
	}
	public function updateVaritaiton(Request $request)
	{

		$variation = json_encode($request->variable_attribute);
		$product = Product::where('parent_id', $request->product_id)->whereRaw("JSON_CONTAINS(variation, ?)", [$variation])->first();
		// dd($product);
		if (!$product) {
			return back()->with('error', 'Sorry! This variation no longer available');
		}
		Cart::update($request->product_id, array(
			'id' => $product->id,
		));

		return back()->with('success', 'Item has been Attribute add!');
	}

	// public function extras(request $request)  {
	// 	// dd( $request->restaurant_slug);
	// 	Session::put('extras',$request->extras);
	// 	Session::put('total',$request->total_price);
	// 	return redirect()->route('restaurant.checkout', ['restaurant' => $request->restaurant_slug]);
	// }


	public function addExtra(Request $request)
	{
		// dd($request);
		// Validate the incoming request data
		$request->validate([
			'product_id' => 'required|exists:extras,id',
			'quantity' => 'required|integer|min:1',
			'price' => 'required|numeric|min:0',
		]);

		// Retrieve the extra item
		$extra = Extra::find($request->product_id);
		// dd($product);

		if (!$extra) {
			return back()->withErrors('Product not found.');
		}

		// Add to cart with the quantity and price from the request
		$uniqueRandomNumber =  rand(1000, 9999);
		Cart::add(
			$extra->id . $uniqueRandomNumber,
			$extra->name,
			$request->price, // Use the price from the form
			$request->quantity, // Use the quantity from the form
			['restaurent' => $request->restaurent_id, 'extra' => $extra, 'tax' => $extra->tax, 'sdfsd' => 'sedfsdf']
		);

		return back();
	}
}
