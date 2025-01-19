<?php

namespace App\Traits;

use App\Models\Product;
use Carbon\Carbon;
trait HasFilter
{

    public function scopeFilter($query)
    {
        return $query->when(request()->has('filter'), function ($q) {
            foreach (request()->filter as $key => $value) {
                if ($value) {

                    $q->where($key, $value);
                }
            }
        })->when(request()->has('search'), function ($q) {
            if (@request()->search['query']) {
                if (@explode('.', request()->search['column'])[1]) {
                    $q->whereHas(explode('.', request()->search['column'])[0], function ($q) {
                        $q->where(explode('.', request()->search['column'])[1], 'LIKE', '%' . request()->search['query'] . '%');
                    });
                } else {
                    $q->where(request()->search['column'], 'LIKE', '%' . request()->search['query'] . '%');
                }
            }
        })->when(request()->has('order'), function ($q) {
            foreach (request()->order as $key => $value) {
                if ($value) {
                    $q->orderBy($key, $value);
                }
            }
        })->when(request()->has('date'), function ($q) {
            foreach (request()->date as $column => $dates) {

                // if ($dates['from'] && $dates['to']) {
                //     $q->whereBetween($column, [$dates['from'], $dates['to']]);
                // }
                if ($dates['from'] && $dates['to']) {
                    $from = Carbon::parse($dates['from'])->startOfDay();
                    $to = Carbon::parse($dates['to'])->endOfDay();
                    
                    $q->whereBetween($column, [$from, $to]);
                }
            }
        })
            ->when(request('restaurant') !== null, function ($q) {
                $q->whereHas('products', function ($query) {
                    $query->where('restaurant_id', request()->get('restaurant'));
                });
            });
    }
    public function scopeFilterByDate($query, $column = 'created_at')
    {
        return $query->when(
            request()->filled('start_date') && request()->filled('end_date'),
            function ($q) use ($column) {
                $from = Carbon::parse(request()->start_date)->startOfDay();
                $to = Carbon::parse(request()->end_date)->endOfDay();
                $q->whereBetween($column, [$from, $to]);
            }
        );
    }

}
