<?php

namespace App\Http\Controllers\Fronts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function about(){
        return view('fronts.about');
    }
    public function pages(){
        return view('fronts.pages');
    }
    public function news(){
        return view('fronts.news');
    }
    public function contact(){
        return view('fronts.contact');
    }
    public function shop(){
        return view('fronts.shop');
    }
}
