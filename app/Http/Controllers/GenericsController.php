<?php

namespace App\Http\Controllers;

use App\Models\Generic;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class GenericsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd(Generic::filter());
        $generics = Generic::latest()->filter()->paginate(24)->withQueryString();
        return view('pages.generics.list', compact('generics'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.generics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Generic::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return redirect('generics')->with('success', 'Generics Added Success!');
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
    public function edit(Generic $generic)
    {
        return view('pages.generics.edit', compact('generic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Generic $generic)
    {
        $generic->update([
            'name' => $request->name,
            'url' => $request->url,
            'description' => $request->description
        ]);
        return redirect('generics')->with('success', 'Generics Edit Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Generic $generic)
    {
        $generic->delete();
        return redirect('generics')->with('success', 'Generic Delete Success!');
    }
}
