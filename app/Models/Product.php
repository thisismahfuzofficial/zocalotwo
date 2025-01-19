<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    use HasFilter;

    protected $guarded = [];
    protected $with = ['category', 'options'];

    public function imageUrl(): Attribute
    {
        return Attribute::make(get: function ($value) {
            if (isset($this->attributes['image']) && $this->attributes['image'] && Storage::exists($this->attributes['image'])) {
                return Storage::url($this->attributes['image']);
            } elseif (isset($this->category->image) && $this->category->image && Storage::exists($this->category->image)) {
                return Storage::url($this->category->image);
            } else {
                return asset('images/new/no-image.jpg');
            }
        });
    }

    public function image(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->image_url);
    }
    // public function imageUrl(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $this->attributes['image'] ? asset('uploads/' . $this->attributes['image']) : $this->avatar()
    //     );
    // }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    // public function supplier()
    // {
    //     return $this->belongsTo(Supplier::class);
    // }
    // public function generic()
    // {
    //     return $this->belongsTo(Generic::class);
    // }


    // public function batches()
    // {
    //     return $this->belongsToMany(Purchase::class, 'purchase_product')->withPivot(
    //         'manufacture_date',
    //         'batch_name',
    //         'expiry_date',
    //         'purchased_unit',
    //         'purchase_quantity',
    //         'remaining_quantity',
    //         'supplier_rate',
    //         'total'
    //     )->withTimestamps()->wherePivot('expiry_date', '>', now());
    // }

    public function hasQuantity()
    {

        return true;
    }

    public function scopeMostSold($query)
    {
        return $query->orderBy('sold_unit', 'desc');
    }
    public function tradePrice(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }


    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }

    public function boxPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value ? round(floatval($value), 2) / 100 : null;
            },
            set: function ($value) {
                return floatval($value) * 100;
            }
        );
    }

    public function stripPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value ? round(floatval($value), 2) / 100 : null;
            },
            set: function ($value) {
                return floatval($value) * 100;
            }
        );
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot(['quantity', 'price']);
    }
    public function options()
    {
        return $this->hasMany(ProductOption::class, 'product_id');
    }

    // public function scopeFilter($query)
    // {
    //     // dd( request('search'));
    //     return $query
    //         ->when(
    //             request()->has('search'),
    //             function ($q) {
    //                 return  $q->where('name', 'like', '%' . request('search') . '%');
    //             }
    //         );
    // }
    // In your Product.php model file

    public function tax(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function taxAmount($price)
    {
        // $price = $this->price;
        $tax = $this->tax / 100;
        $priceWithTax = $price * (1 + $tax);
        $taxAmount = $priceWithTax - $price;

        return $taxAmount;
    }
}
