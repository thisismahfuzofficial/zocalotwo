<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ZoneController extends Controller
{
    public function fetchZones()
    {
        $zones = [];
     
        $results = DB::table('restaurant_zone as z')
            ->leftJoin('zones as c', 'z.zone_id', '=', 'c.zone_id')
            ->orderBy('z.zone_id')
            ->orderBy('c.id')
            ->get(['z.zone_id', 'z.zone_name', 'z.restaurant_id', 'c.lat', 'c.lng']);
        $currentZoneId = null;
        foreach ($results as $row) {
            $zoneId = $row->zone_id;
            if ($currentZoneId !== $zoneId) {
                $currentZoneId = $zoneId;
                $zones[$zoneId] = [
                    "id" => $zoneId,
                    "name" => $row->zone_name,
                    "restaurant_id" => $row->restaurant_id,
                    "coordinates" => []
                ];
            }
            if ($row->lat && $row->lng) {
                $zones[$zoneId]["coordinates"][] = ["lat" => floatval($row->lat), "lng" => floatval($row->lng)];
            }
        }
        return response()->json(array_values($zones));
    }
}