<?php

namespace App\Http\Controllers;





namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::filter()->latest()->paginate(30);
        return view('pages.languages.list', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => [
                'required',
                'string',
                'max:225',
                'unique:languages,key'
            ],
            'french' => [
                'required'
            ],
        ]);
        
        // dd($request->all()); 
        $data = [
            'key' => $request->key,
            'english' => $request->english,
            'french' =>  $request->french,
        ];
        Language::create($data);

        return redirect('/admin/languages')->with('message', 'Language Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        return view('pages.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([
            'key' => [
                'required',
                'string',
                'max:225',
            ],
            'french' => [
                'required'
            ],
        ]);

        $language->update([
            'key' => $request->key,
            'french' => $request->french,
            'english' => $request->english,
        ]);
        return back()->with('message', 'Language updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Storage::delete($category->image);
        $category->delete();
        return redirect('/admin/categories')->with('message', 'Category Delete successFull !');
    }
    public function toggle(Category $category)
    {
        $data = Category::find($category->id);


        if ($data->featured == 'unchecked') {
            $data->update(['featured' => 'checked']);
        } else {
            $data->update(['featured' => 'unchecked']);
        }
        return redirect()->back();
    }
}
