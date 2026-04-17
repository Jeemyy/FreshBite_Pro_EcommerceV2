<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        $sales = Sale::all();
        $news = News::all();
        return view('index', get_defined_vars());
    }
}
