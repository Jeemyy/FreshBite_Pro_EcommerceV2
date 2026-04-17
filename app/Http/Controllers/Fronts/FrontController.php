<?php

namespace App\Http\Controllers\Fronts;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function about(){
        $abouts = About::all();
        return view('fronts.about', get_defined_vars());
    }
    public function news(){
        $news = News::all();
        return view('fronts.news', get_defined_vars());
    }
    public function contact(){
        return view('fronts.contact');
    }
    public function shop(){
        $categories = Category::all();
        $products = Product::all();
        return view('fronts.shop', get_defined_vars());
    }
    public function cart(){
        return view('fronts.cart');
    }
}
