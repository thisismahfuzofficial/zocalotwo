<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromQuery, WithHeadings, WithMapping
{

    public function query()
    {
        return Order::search();
    }
    public function map($order): array
    {
        return [
            $order->id,
            $order->sub_total,
            $order->total,
            $order->payment_method,
            $order->paid,
            $order->status,
            $order->delivery_option,
            $order->transaction_id,
            $order->transaction_body,
            $order->time_option,
            $order->restaurant->name,
            $order->payment_status,
            $order->tax,
            $order->customer?->name . $order->customer?->l_name,
            $order->customer?->email,
            $order->customer?->phone,
            $order->customer?->address,
            $order->customer?->city,
            $order->customer?->post_code,
            $order->customer?->house,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'Sub Total',
            'Total',
            'Payment method',
            'Paid',
            'Status',
            'Delivery option',
            'Transaction Id',
            'Transaction Body',
            'Time option',
            'Restaurant',
            'Payment status',
            'Tax',
            'Customar Name',
            'Customar Email',
            'Customar Phone',
            'Customar Address',
            'Customar Post Code',
            'Customar House',
        ];
    }
}
