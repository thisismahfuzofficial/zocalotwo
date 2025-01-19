<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'restaurant_zone', 'restaurant_id', 'zone_id')
            ->withPivot('zone_name');
    }

    public function address(): Attribute
    {

        return Attribute::make(

            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }

    public function fullAddress($key = null)
    {
        $address = $this->address;
        if ($key) {
            return $address[$key];
        }
        return $address['address'] . ',' . $address['city'] . ' ' . $address['post_code'];
    }
    // public function api_key(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn($value) => json_decode($value,true),
    //         set: fn($value) => json_encode($value),
    //     );
    // }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function getPaymentCreds($key = null)
    {
        $creds = json_decode($this->api_key, true);
        return  $key ? @$creds[$key] : $creds;
    }
    public function getPrinterCreds($key = null)
    {
        $creds = json_decode($this->printer, true);
        return  $key ? @$creds[$key] : $creds;
    }

    public function time_sidual(){

        return $this->hasMany(TimeSidual::class);
    }

    public function delivery()
    {
        if ($this->delivery_option == 'both') {
            return 'Both';
        } elseif ($this->delivery_option == 'take_away') {
            return 'Take Away';
        } elseif($this->delivery_option == 'home_delivery') {
            return 'Home Delivery';
        }
    }
}
