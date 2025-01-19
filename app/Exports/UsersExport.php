<?php

namespace App\Exports;


use App\Models\User;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return User::query()
            ->with('role') 
            ->select('name', 'l_name', 'phone', 'email', 'address', 'city', 'post_code', 'role_id');
    }

    public function map($customer): array
    {
        return [
            $customer->name,
            $customer->l_name,
            $customer->phone,
            $customer->email,
            $customer->address,
            $customer->city,
            $customer->post_code,
            ucwords($customer->role->name  ?? 'User'),
        ];
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Phone',
            'Email',
            'Address',
            'City',
            'Post Code',
            'Role',
        ];
    }
}
