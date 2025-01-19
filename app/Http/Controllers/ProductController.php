<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $minutes = 5;
        $products = Product::latest()->filter()->paginate(16)->withQueryString();
        $categories = Cache::remember('categories', $minutes, function () {
            Cache::flush();
            return Category::whereNotNull('parent_id')->get()->pluck('name', 'id')->toArray();
        });
        return view('pages.products.list', compact('products', 'categories'));
    }


    public function createOrEdit(Request $request, Product $product = null)
    {
        $variations = $request->session()->get('variation_array') ?? [];

        // $generics = Generic::all()->pluck('name', 'id')->toArray();
        // $categories = Category::all()->pluck('name', 'id')->toArray();
        // $suppliers = Supplier::all()->pluck('name', 'id')->toArray();
        // $units = Unit::all()->pluck('name', 'id')->toArray();

        // return view(
        //     'pages.products.create',
        //     compact(
        //         'variations',
        //         'generics',
        //         'categories',
        //         'suppliers',
        //         'units',
        //         'product'
        //     )
        // );
    }
    public function save(Request $request, Product $product = null)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|max:1024',
            'unit' => 'nullable|string',
            'price' => 'required|min:1',
            'strip_price' => 'nullable|min:1',
            'box_price' => 'nullable|min:1',
            'status' => 'nullable',
            'featured' => 'nullable',
            'category' => 'nullable|exists:categories,id',
            'generic' => 'nullable|exists:generics,id',
            'supplier' => 'nullable|exists:suppliers,id',
            'description' => 'nullable',
            'trade_price' => 'nullable',
            'is_bonus' => 'nullable',
            'box_size' => 'nullable',
            'strength' => 'nullable',
            'type' => 'nullable',
        ]);

        if (!$product) {
            $product = new Product();
        }

        $product->name = $request->name;
        $product->unit = $request->unit;
        $product->price = $request->price;
        $product->strip_price = $request->strip_price;
        $product->box_price = $request->box_price;
        $product->status = $request->status;
        $product->featured = $request->featured;
        $product->category_id = $request->category;
        $product->generic_id = $request->generic;
        $product->supplier_id = $request->supplier;
        $product->description = $request->description;
        $product->trade_price = $request->price * 0.88;
        $product->is_bonus = $request->is_bonus;
        $product->box_size = $request->box_size;
        $product->strength = $request->strength;
        $product->type = $request->type;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $product->image = $request->file('image')->store('product');
        }

        $product->save();

        return redirect(route('products.createOrEdit', $product->id))->with('success', 'Product Created Successfully');
    }
    public function duplicateProduct(Request $request)
    {

        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $originalProduct = Product::findOrFail($request->productId);

        $newProduct = $originalProduct->replicate();
        $newProduct->name = $originalProduct->name . ' - Duplicate';
        $newProduct->save();

        flash()->addSuccess("{$originalProduct->name} has been duplicated!");
        return response()->json(['newProductId' => $newProduct->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted');
    }

    public function showProduct(Product $product)
    {
        // dd('hello');
        return view('pages.products.single', compact('product'));
    }
    public function createProduct()
    {

        $categories = Category::whereNotNull('parent_id')->get();
        return view('pages.products.create', compact('categories'));
    }
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'composition' => 'nullable|string',
            'allergenes' => 'nullable|string',
            'image' => 'nullable|image',
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'tax' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'category' => 'nullable|exists:categories,id',
            'description' => 'nullable',
        ]);  
        $product = new Product;

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->composition = $request->composition;
        $product->allergenes = $request->allergenes;
        $product->price = $request->price;
        $product->tax = $request->tax;
        $product->sequency = $request->sequence;
        // $product->status = $request->status;
        // $product->featured = $request->featured;
        $product->category_id = $request->category;
        $product->text = $request->description;
        $product->SKU = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $product->category_id = $request->category;
        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $product->image = $request->file('image')->store('uploads', 'public');
        }
        Cache::flush();
        
        $product->save();

        
        if ($request->option) {
           
            $request->validate([
                'option.*.price' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/']
            ]);

            foreach ($request->option as $option) {
                $product_option = new ProductOption;
                $product_option->product_id = $product->id;
                $product_option->option_name = $option['name'];
                $product_option->option_price = $option['price'];

                $product_option->save();
            }
        }


        return redirect(route('products.index'))->with('success', 'Product Created Successfully');
    }
    public function editProduct(Product $product)
    {
        $categories = Category::whereNotNull('parent_id')->get();
        $product_options = ProductOption::where('product_id', $product->id)->get();
        return view('pages.products.edit', compact('product', 'categories', 'product_options'));
    }
    public function updateProduct(Request $request, Product $product)
    {
        Cache::flush();
        // dd($request);
        $validated = $request->validate([
            'name' => 'required|string',
            'composition' => 'required|string',
            'allergenes' => 'required|string',
            'image' => 'nullable|image',
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'tax' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'sequence' => 'required|integer',
            'category' => 'nullable|exists:categories,id',
            'description' => 'nullable',
        ]);
        // $flavors = [
        //     ['id' => 1, 'name' => 'Cerise'],
        //     ['id' => 2, 'name' => 'Mangue'],
        //     ['id' => 3, 'name' => 'Vanille'],
        //     ['id' => 4, 'name' => 'Chocolat'],
        // ];
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->composition = $request->composition;
        $product->allergenes = $request->allergenes;
        $product->price = $request->price;
        $product->tax = $request->tax;
        $product->sequency = $request->sequence;
        $product->status = $request->status;
        // $product->flavors = json_encode($flavors);
        // $product->status = $request->status;
        // $product->featured = $request->featured;
        $product->category_id = $request->category;
        $product->text = $request->description;
        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $product->image = $request->file('image')->store('uploads', 'public');
        }
        $product->save();

        
        if ($request->option) {
           
            $request->validate([
                'option.*.price' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/']
            ]);
           
            foreach ($request->option as $option) {
                ProductOption::updateOrCreate(
                    ['id' => $option['id']], // Search criteria
                    [
                        'product_id' => $product->id, // Fields to update or create
                        'option_name' => $option['name'],
                        'option_price' => $option['price'],
                    ]
                );
            }

        }

        return back()->with('success', 'Product Updated Successfully');
    }
    public function deleteProduct(Product $product)
    {
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product_options = ProductOption::where('product_id', $product->id)->get();

        if (count($product_options) > 0) {
            foreach ($product_options as $option) {

                $option->delete();
            }
        }



        $product->delete();


        return redirect()->route('products.index')->with('success', 'Product deleted');
    }
    public function deleteOption(ProductOption $productOption){
        $productOption->delete();
        return redirect()->back()->with('success', 'Option deleted');
    }
}
