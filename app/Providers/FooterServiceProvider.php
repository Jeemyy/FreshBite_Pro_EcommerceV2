<?php

namespace App\Providers;

use App\Models\Testimonial;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FooterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $testimonials = Testimonial::all();
        View::share('testimonials', $testimonials);
    }
}
