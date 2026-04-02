<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAboutRequest;
use App\Http\Requests\Admin\UpdateAboutRequest;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::all();
        return view('admin.abouts.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.abouts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAboutRequest $request)
    {
        $about = new About();
        $data = $request->validated();
        // dd($data);
        $about->title = $data['title'];
        $about->description = $data['description'];

        if ($request->hasFile('icon')) {
            $icon = $request->icon;
            $iconName = time() . '-' . $icon->getClientOriginalName();
            $path = $icon->storeAs('abouts', $iconName, 'public');
            $about->icon = $path;
        }

        $about->save();

        return to_route('admin.abouts.index')->with('success', 'About Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        return view('admin.abouts.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(About $about)
    {
        return view('admin.abouts.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutRequest $request, About $about)
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {

            if ($about->icon && Storage::disk('public')->exists($about->icon)) {
                Storage::disk('public')->delete($about->icon);
            }

            $data['icon'] = $request->file('icon')
                ->store('abouts', 'public');
        }

        $about->update($data);

        return to_route('admin.abouts.index')
            ->with('success', 'About Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        if ($about->icon && Storage::disk('public')->exists($about->icon)) {
            Storage::disk('public')->delete($about->icon);
        }

        $about->delete();

        return to_route('admin.abouts.index')
            ->with('success', 'About Deleted Successfully');
    }
}
