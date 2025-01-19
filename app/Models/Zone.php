<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class)->withPivot('zone_id', 'zone_name', 'restaurant_id');
    }

    public function ZoneRestaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_zone', 'zone_id', 'restaurant_id')
            ->withPivot('zone_name');
    }
}
