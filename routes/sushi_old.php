<?php

use App\Models\Category;
use App\Models\Extra;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Restaurant;
use App\Models\RestaurantZone;
use App\Models\Zone;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

Route::get('/old-db', function () {
    // $categories_old = DB::connection('mysql_old')->table('categories')->get()->map(function ($category) {
    //     return [
    //         'id' => $category->cat_id,
    //         'name' => $category->cat_name,
    //         'slug' => $category->slug,

    //     ];
    // });
    $options_old = DB::connection('mysql_old')->table('productoptions')->get()->map(function ($option) {
       
        return [
            'id' => $option->option_id,
            'product_id' => $option->prod_id,
            'option_name' => $option->option_name,
            'option_price' => $option->option_price,
        ];
    });
    
    // $sub_categories_old = DB::connection('mysql_old')->table('subcategories')->get()->map(function ($sub_category) {
    //     // dd($sub_category);
    //     return [
    //         'name' => $sub_category->subcat_name,
    //         'parent_id' => $sub_category->cat_id,
    //         'subcat_id' => $sub_category->subcat_id,
    //         'slug' => Str::slug($sub_category->subcat_name) . '-' . substr(Str::uuid()->toString(8), 0, 10),
    //     ];
    // });
    // $products_old = DB::connection('mysql_old')->table('products')->get()->map(function ($product) {
    //     return [
    //         'id' => $product->prod_id,
    //         'name' => $product->prod_name,
    //         'composition' => $product->composition,
    //         'allergenes' => $product->allergenes,
    //         'sku' => $product->SKU,
    //         'price' => $product->price,
    //         'description' => $product->text,
    //         'category_id' => $product->subcat_id,
    //         'slug' => Str::slug($product->prod_name) . '-' . substr(Str::uuid()->toString(8), 0, 10),
    //     ];
    // });
    // $resturent_old = DB::connection('mysql_old')->table('restaurents')->get()->map(function ($restaurent) {

    //     return [
    //         'name' => $restaurent->restaurent_name,
    //         'slug' => Str::slug($restaurent->restaurent_name),
    //     ];
    // });
    // $extras_old = DB::connection('mysql_old')->table('extras')->get()->map(function ($extra) {

    //     return [
    //         'name' => $extra->extra_name,
    //         'type' => $extra->extra_type,
    //     ];
    // });
    // $zones_old = DB::connection('mysql_old')->table('zone_coordinates')->get()->map(function ($zone) {
    //     return [
    //         'zone_id' => $zone->zone_id,
    //         'lat' => $zone->lat,
    //         'lng' => $zone->lng,
    //         'location' => $zone->location,
    //     ];
    // });

    // $restaurant_zone_old = DB::connection('mysql_old')->table('zones')->get()->map(function ($data) {
        
    //     return [
    //         'zone_id' => $data->zone_id,
    //         'zone_name' => $data->zone_name,
    //         'restaurant_id' => $data->rest_id,
    //     ];
    // });
    

    ProductOption::latest()->delete();
    // Product::latest()->delete();
    // Restaurant::latest()->delete();
    // Zone::latest()->delete();
    // RestaurantZone::latest()->delete();
    
    foreach ($options_old as $option) {
        ProductOption::create($option);
    }


    // foreach ($sub_categories_old as $subcategory) {
    //     Category::create($subcategory);
    // }
    //     foreach ($products_old as $product) {
    //         Product::create($product);
    //     }
    // foreach ($resturent_old as $resturent) {
    //     Restaurant::create($resturent);
    // }
    // // dd($zones_old);
    // foreach ($zones_old as $zone) {
    //     Zone::create($zone);
    // }
    // foreach ($restaurant_zone_old as $restaurant_zone) {
    //     RestaurantZone::create($restaurant_zone);
    // }
    
    
});
