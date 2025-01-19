<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\TimeSchedule;
use Illuminate\Http\Request;

class TimeScheduleController extends Controller
{
    public function index()
    {
        $time_schedules = TimeSchedule::latest()->get();
        return view('pages.TimeSchedule.list', compact('time_schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restaurants = Restaurant::latest()->get();
        return view('pages.TimeSchedule.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'restaurant' => 'required|exists:restaurants,id',
        ]);

        TimeSchedule::create([
            'restaurant_id' => $request->input('restaurant'),
            'time_schedule' => $request->input('time_schedule'),
        ]);

        return redirect()->back()->with('success', 'Time schedule saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeSchedule $time_schedule)
    {
        $restaurants = Restaurant::latest()->get();
        return view('pages.TimeSchedule.edit', compact('time_schedule','restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeSchedule $time_schedule)
    {
         // Validate the request
         $request->validate([
            'restaurant' => 'required|exists:restaurants,id',
            'time_schedule' => 'required',
        ]);

        $time_schedule->update([
            'restaurant_id' => $request->input('restaurant'),
            'time_schedule' => $request->input('time_schedule'),
        ]);

        return redirect('admin/time-schedules')->with('success', 'Time schedule updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeSchedule $time_schedule)
    {
        $time_schedule->delete();
        return redirect('admin/time-schedules')->with('success', 'Time schedule Delete Success!');
    }
}
