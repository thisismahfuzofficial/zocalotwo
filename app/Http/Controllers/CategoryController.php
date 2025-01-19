<?php

namespace App\Http\Controllers;

use App\Models\Category;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::filter()->latest()->paginate(30);
        return view('pages.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('pages.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        // dd($request->all()); 
        $data = [
            'name' => $request->name,
            'sequency' => $request->sequency,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'description' => $request->description
        ];
        Cache::flush();
        Category::create($data);

        return redirect('/admin/categories')->with('message', 'Category Added Successfully');
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
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('pages.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        
        $slug = Str::slug($request->name);
        
        $existingSlugCount = Category::where('slug', $slug)
        ->where('id', '!=', $category->id)
        ->count();
        
        if ($existingSlugCount > 0) {
            $slug = $slug . '-' . ($existingSlugCount + 1);
        }
        Cache::flush();
        $category->update([
            'name' => $request->name,
            'sequency' => $request->sequency,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'description' => $request->description
        ]);
        return redirect('/admin/categories')->with('message', 'Category Edit SuccessFull');
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
