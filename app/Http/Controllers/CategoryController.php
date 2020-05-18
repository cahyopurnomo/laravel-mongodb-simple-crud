<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // $categories = Category::all();
        // return $categories;
        $categories = Category::latest()->paginate(10);
        return view('categories.index',compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function create()
    {
        return view('categories.create');
    }
   
    public function store(Request $request)
    {
        request()->validate([
            'category' => 'required'
        ]);
        $slug=Str::slug($request->category);
        Category::create($request->all()+['slug'=>$slug]);

        return redirect()->route('categories.index')
                        ->with('success','Category created successfully');
    }
    
    public function edit(Category $category)
    {
        return view('categories.edit',compact('category'));
    }
   
    public function update(Request $request,Category $category)
    {
        request()->validate([
            'category' => 'required'
        ]);
        $slug=Str::slug($request->category);

        $category->update($request->all()+['slug'=>$slug]);
        return redirect()->route('categories.index')
                        ->with('success','Category updated successfully');
    }
    
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('categories.index')
                        ->with('success','Category deleted successfully');
    }
}