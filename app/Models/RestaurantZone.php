<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantZone extends Model
{
    use HasFactory;
    protected $table = 'restaurant_zone';

    protected $guarded = [];

    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }
}
