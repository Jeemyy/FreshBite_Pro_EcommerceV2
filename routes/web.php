<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Fronts\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// ########### Fronts Routes
Route::name('fronts.')->group(function () {
    Route::get('/', [WelcomeController::class, '__invoke'])->name('index');
    Route::controller(FrontController::class)->group(function () {

        ## About ##
        Route::get('/about', [FrontController::class, 'about'])->name('about');

        ## Pages ##
        Route::get('/pages', [FrontController::class, 'pages'])->name('pages');

        ## News ##
        Route::get('/news', [FrontController::class, 'news'])->name('news');

        ## Contact ##
        Route::get('/contact', [FrontController::class, 'contact'])->name('contact');

        ## Shop ##
        Route::get('/shop', [FrontController::class, 'shop'])->name('shop');
    });
});

// ########### Admin Routes
Route::name('admin.')->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', [AdminController::class, '__invoke'])->name('index');
    });

    // Categories
    Route::controller(CategoryController::class)->group(function () {
        Route::resource('categories', CategoryController::class)
        ->name('*', 'categories')
        ->except('show');
    });

    // Products
    Route::controller(ProductController::class)->group(function () {
        Route::resource('products', ProductController::class)->name('*', 'products');
    });

    // About
    Route::controller(AboutController::class)->group(function () {
        Route::resource('abouts', AboutController::class)->name('*', 'abouts');
    });

    // Testimonials
    Route::controller(TestimonialController::class)->group(function () {
        Route::resource('testimonials', TestimonialController::class)
        ->name('*', 'testimonials')
        ->except(['show', 'edit', 'update']);
    });

    // Contact Us
    Route::controller(ContactUsController::class)->group(function () {
        Route::resource('contacts', ContactUsController::class)
        ->name('*', 'contacts')
        ->except(['create', 'store', 'edit', 'update']);
    });

    //
    // Route::controller(::class)->group(function(){
    //     Route::resource('', ::class)->name('*', '');
    // });
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
