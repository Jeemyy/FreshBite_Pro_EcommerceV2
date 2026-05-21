<?php

namespace App\Providers;

use App\Models\Testimonial;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FooterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            $testimonials = Testimonial::all();
            View::share('testimonials', $testimonials);
        } catch (\Exception $e) {
            View::share('testimonials', collect());
        }
    }
}
