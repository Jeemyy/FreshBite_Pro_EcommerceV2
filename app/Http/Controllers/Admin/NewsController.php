<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return view('admin.news.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $new = new News();
        $data = $request->validated();
        // dd($data);
        $new->title = $data['title'];
        $new->published_at = now();
        $new->description = $data['description'];

        if ($request->hasFile('image')) {
            $image = $request->image;
            $imageName = time() . '-' . $image->getClientOriginalName();
            $path = $image->storeAs('news', $imageName, 'public');
            $new->image = $path;
        }

        $new->save();

        return to_route('admin.news.index')->with('success', 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        // dd($news);
        return view('admin.news.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }

            $data['image'] = $request->file('image')
                ->store('news', 'public');
        }

        $news->update($data);

        return to_route('admin.news.index')
            ->with('success', 'new Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return to_route('admin.news.index')
            ->with('success', 'news Deleted Successfully');
    }
}
