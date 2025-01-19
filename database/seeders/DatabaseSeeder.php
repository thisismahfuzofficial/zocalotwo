<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Constant\Dataset;
use App\Models\Category;
use App\Models\Generic;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $role = Role::firstOrNew(['name' => 'admin']);

        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Admin',
            ])->save();
        }
        $role = Role::firstOrNew(['name' => 'user']);

        if (!$role->exists) {
            $role->fill([
                'display_name' => 'User',
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'restaurant']);

        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Restaurant',
            ])->save();
        }
        
        $this->call(SettingTableSeeder::class);
    }
}
