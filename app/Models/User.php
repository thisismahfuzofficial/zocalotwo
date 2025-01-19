<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\HasLog;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasFilter, HasLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id')->latest();
    }
    public function dueorders()
    {
        return $this->hasMany(Order::class, 'customer_id')->where('due', '>', 0);
    }
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
