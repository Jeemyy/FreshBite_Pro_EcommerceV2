<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::all();

        return view('admin.testimonials.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonialRequest $request)
    {
        $testimonial = new Testimonial;
        $data = $request->validated();
        // dd($data);
        $testimonial->title = $data['title'];

        if ($request->hasFile('image')) {
            $image = $request->image;
            $imageName = time().'-'.$image->getClientOriginalName();
            $path = $image->storeAs('testimonials', $imageName, 'public');
            $testimonial->image = $path;
        }

        $testimonial->save();

        return to_route('admin.testimonials.index')->with('success', 'testimonial Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return to_route('admin.testimonials.index')
            ->with('success', 'testimonial Deleted Successfully');
    }
}
