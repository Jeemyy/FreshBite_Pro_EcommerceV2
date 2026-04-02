<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categorys.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $cat = new Category();
        $data = $request->validated();

        $cat->title = $data['title'];

        $image = $request->image;

        $imageName = time() . '-' . $image->getClientOriginalName();

        $path = $image->storeAs('categories', $imageName, 'public');

        $data['image'] = $path;

        Category::create($data);
        return to_route('admin.categories.index')->with('success', 'Category Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Category $category)
    // {
    //     return view('admin.category.show', get_defined_vars());
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categorys.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $category->title = $data['title'];

        $image = $request->image;

        if ($image == null) {
            $data['image'] = $category->image;
            $category->update($data);

            return to_route('admin.categories.index')->with('success', 'Category Updated Successfully');
        }
        $imageName = time() . '-' . $image->getClientOriginalName();

        $path = $image->storeAs('categories', $imageName, 'public');
        $data['image'] = $path;

        $category->update($data);

        return to_route('admin.categories.index')->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return to_route('admin.categories.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
