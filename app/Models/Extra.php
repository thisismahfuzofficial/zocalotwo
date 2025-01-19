<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Extra extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tax(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
}
