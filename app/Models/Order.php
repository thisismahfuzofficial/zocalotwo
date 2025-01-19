<?php

namespace App\Models;

use App\Models\Traits\HasLog;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Settings;

class Order extends Model
{
    use HasFactory;
    use HasFilter, HasLog;

    protected $guarded = [];
    protected $casts = [
        'shipping_info' => 'array',
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->withDefault();
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price', 'profit', 'restaurant_id', 'options');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function total(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function discount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function paid(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function due(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function profit(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function restaurent()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function getShipping($key = null)
    {
        $shipping = json_decode($this->shipping_info, true);
        if ($key) {
            return @$shipping[$key] ?: '';
        }
        return $shipping;
    }
    public function delivery()
    {
        if ($this->take_away) {
            return 'Take Away';
        } elseif ($this->home_delivery) {
            return 'Home Helivery';
        } else {
            return 'Null';
        }
    }
    public function getProducts()
    {


        $products = $this->products->map(fn($product) => (object) [
            'name' => $product->name,
            'quantity' => $product->pivot->quantity,
            'price' => (float) $product->pivot->price,
            'options' => $product->pivot->options ? explode(', ', $product->pivot->options) : null,
            'category' => $product->category,
            'tax_percent' => (string) @$product->tax ?? 10,
            'total' => $product->pivot->price *  $product->pivot->quantity,
            'tax' => Settings::itemTax($product->pivot->price, $product->tax, $product->pivot->quantity),

        ]);

        $extras = collect(value: json_decode($this->extra, true))
            ->map(fn($extra) => (object) [
                'name' => $extra['name'],
                'quantity' => $extra['quantity'],
                'price' => $extra['price'],
                'options' => null,
                'tax_percent' => (string) $extra['tax_percentage'] ?? 10,
                'total' => $extra['price'] *  $extra['quantity'],
                'tax' => Settings::itemTax($extra['price'], $extra['tax_percentage'], $extra['quantity']),
            ]);
        if ($products->count() == 0) return $extras;
        if ($extras->count() == 0) return $products;
        return $products->merge($extras);
    }


    public function scopeSearch($query)
    {
        //    dd($query);
        $query->when(
            request()->status !== null,
            function ($q) {
                switch (request()->status) {
                    case 'today':
                        $q->whereDate('orders.created_at', today());
                        break;
                    case 'yesterday':
                        $q->whereDate('orders.created_at', today()->subDay());
                        break;
                    case 'this_week':
                        $q->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'last_7_days':
                        $q->whereBetween('orders.created_at', [now()->subDays(7), now()]);
                        break;
                    case 'this_month':
                        $q->whereBetween('orders.created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                        break;
                    case 'last_month':
                        $q->whereBetween('orders.created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                        break;
                    case 'last_6_months':
                        $q->whereBetween('orders.created_at', [now()->subMonths(6), now()]);
                        break;
                    case 'this_year':
                        $q->whereYear('orders.created_at', now()->year);
                        break;
                    case 'last_year':
                        $q->whereYear('orders.created_at', now()->subYear()->year);
                        break;
                }
            }
        );

        $query->when(
            request()->restaurant !== null,
            function ($q) {

                $q->where('orders.restaurant_id', request()->restaurant);
            }
        );

        $query->when(request()->status !== null, function ($q) {
            $q->where('orders.status', request()->status);
        });

        $query->when(request()->payment_method !== null, function ($q) {
            $q->where('orders.payment_method', request()->payment_method);
        });

        $query->when(request()->delivery_option !== null, function ($q) {
            $q->where('orders.delivery_option', request()->delivery_option);
        });

        $query->when(
            request()->from_date !== null,
            fn($q) => $q->whereDate('orders.created_at', '>=', request()->from_date)
        );

        $query->when(
            request()->to_date !== null,
            fn($q) => $q->whereDate('orders.created_at', '<=', request()->to_date)
        );

        $query->when(request()->orderSearch !== null, function ($q) {
            $search = request()->orderSearch;
            $q->where(function ($query) use ($search) {
                $query->where('orders.shipping_info->name', 'like', "%{$search}%")
                    ->orWhere('orders.shipping_info->l_name', 'like', "%{$search}%")
                    ->orWhere('orders.shipping_info->email', 'like', "%{$search}%")
                    ->orWhere('orders.shipping_info->phone', 'like', "%{$search}%")
                    ->orWhere('orders.shipping_info->city', 'like', "%{$search}%")
                    ->orWhere('orders.shipping_info->address', 'like', "%{$search}%");
            });
        });

        $query->when(request()->orderSearch !== null, function ($q) {
            $search = request()->orderSearch;
            $q->orWhere('orders.customer_id', $search)
                ->orWhereHas('customer', function ($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('l_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        });

        return $query;
    }
}
