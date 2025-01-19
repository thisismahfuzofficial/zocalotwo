<?php

namespace App\Report;

use App\Models\Order;

class Earnings
{
    public $from;
    public $to;

    /**
     * __construct
     *
     * @param  string $from
     * @param  string $to
     * @return void
     */
    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Static method to create an instance with date range.
     *
     * @param string $from
     * @param string $to
     * @return self
     */
    public static function range(string $from, string $to)
    {
        return new self($from, $to);
    }

    /**
     * Get profit and sales data grouped by day, month, or year.
     *
     * @param string $interval
     * @return array
     * @throws \InvalidArgumentException
     */
    public function graph(string $interval = 'Day')
    {
        $query = Order::whereBetween('created_at', [$this->from, $this->to]);

        // Role-based filtering for restaurant users
        if (auth()->user()->role_id == 3) {
            $query->where('restaurant_id', auth()->user()->restaurant_id);
        }

        switch ($interval) {
            case 'Day':
                $query->selectRaw('DATE_FORMAT(created_at,"%d %M") as date, SUM(profit)/100 as total_profit, SUM(total)/100 as sales')
                    ->orderBy('date', 'asc')
                    ->groupBy('date');
                break;

            case 'Month':
                $query->selectRaw('DATE_FORMAT(created_at, "%M") as month, SUM(profit)/100 as total_profit, SUM(total)/100 as sales')
                    ->groupBy('month')
                    ->orderByRaw('MIN(created_at) ASC');
                break;

            case 'Year':
                $query->selectRaw('YEAR(created_at) as year, SUM(profit)/100 as total_profit, SUM(total)/100 as sales')
                    ->orderBy('year', 'asc')
                    ->groupBy('year');
                break;

            default:
                throw new \InvalidArgumentException('Invalid interval provided. Supported intervals are: Day, Month, Year.');
        }

        return $query->get()->toArray();
    }

    /**
     * Get the total earnings (profit) for the specified date range.
     *
     * @return float
     */
    public function totalEarning()
    {
        return Order::whereBetween('created_at', [$this->from, $this->to])
            ->when(auth()->user()->role_id == 3, function ($query) {
                return $query->where('restaurant_id', auth()->user()->restaurant_id);
            })
            ->sum('profit') / 100;
    }

    /**
     * Get the total sales for the specified date range.
     *
     * @return float
     */
    public function totalSale()
    {
        return Order::whereBetween('created_at', [$this->from, $this->to])
            ->when(auth()->user()->role_id == 3, function ($query) {
                return $query->where('restaurant_id', auth()->user()->restaurant_id);
            })
            ->sum('total') / 100;
    }
}
