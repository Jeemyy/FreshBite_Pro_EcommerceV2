<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Fronts\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Fronts\ContactUsController as FrontsContactUsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// ########### Fronts Routes
Route::name('fronts.')->group(function () {
    Route::get('/', [WelcomeController::class, '__invoke'])->name('index');
    Route::controller(FrontController::class)->group(function () {

        ## About ##
        Route::get('/about', [FrontController::class, 'about'])->name('about');

        ## News ##
        Route::get('/news', [FrontController::class, 'news'])->name('news');

        ## Contact ##
        Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
        Route::post('/contact', [FrontsContactUsController::class, 'store'])->name('contact.store');

        ## Shop ##
        Route::get('/shop', [FrontController::class, 'shop'])->name('shop');

        ## Cart ##
        Route::get('/cart', [FrontController::class, 'cart'])->name('cart');

        // Route::get('/login/fronts', function(){ return view("fronts.auth.register"); });
    });
});

require __DIR__ . '/auth.php';

// ########### Admin Routes
Route::name('admin.')->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', [AdminController::class, '__invoke'])->name('index')->middleware('admin');
    });

    // Categories
    Route::controller(CategoryController::class)->group(function () {
        Route::resource('categories', CategoryController::class)
            ->name('*', 'categories')
            ->except('show')
            ->middleware('admin');
    });

    // Products
    Route::controller(ProductController::class)->group(function () {
        Route::resource('products', ProductController::class)->name('*', 'products')->middleware('admin');
    });

    // About
    Route::controller(AboutController::class)->group(function () {
        Route::resource('abouts', AboutController::class)->name('*', 'abouts')->middleware('admin');
    });

    // Testimonials
    Route::controller(TestimonialController::class)->group(function () {
        Route::resource('testimonials', TestimonialController::class)
            ->name('*', 'testimonials')
            ->except(['show', 'edit', 'update'])
            ->middleware('admin');
    });

    // Contact Us
    Route::controller(ContactUsController::class)->group(function () {
        Route::resource('contacts', ContactUsController::class)
            ->name('*', 'contacts')
            ->except(['create', 'store', 'edit', 'update'])
            ->middleware('admin');
    });

    // Settings
    Route::controller(SettingController::class)->group(function () {
        Route::resource('settings', SettingController::class)
            ->name('*', 'settings')
            ->except(['show', 'create', 'store', 'destroy'])
            ->middleware('admin');
    });

    // Sales
    Route::controller(SaleController::class)->group(function () {
        Route::resource('sales', SaleController::class)
            ->name('*', 'sales')
            ->except(['show', 'create', 'store', 'destroy'])
            ->middleware('admin');
    });

    //
    Route::controller(NewsController::class)->group(function(){
        Route::resource('news', NewsController::class)->name('*', 'news')->middleware('admin');
    });
    //
    // Route::controller(::class)->group(function(){
    //     Route::resource('', ::class)->name('*', '');
    // });
    require __DIR__ . '/authAdmin.php';
});



