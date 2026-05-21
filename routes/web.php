<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentManagerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Fronts\CartController;
use App\Http\Controllers\Fronts\CheckoutController;
use App\Http\Controllers\Fronts\ContactUsController as FrontsContactUsController;
use App\Http\Controllers\Fronts\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// ########### Fronts Routes
Route::name('fronts.')->group(function () {
    Route::get('/', [WelcomeController::class, '__invoke'])->name('index');
    Route::controller(FrontController::class)->group(function () {

        // # About ##
        Route::get('/about', [FrontController::class, 'about'])->name('about');

        // # News ##
        Route::get('/news', [FrontController::class, 'news'])->name('news');

        // # Contact ##
        Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
        Route::post('/contact', [FrontsContactUsController::class, 'store'])->name('contact.store');

        // # Shop ##
        Route::get('/shop', [FrontController::class, 'shop'])->name('shop');

        // # Cart ##
        Route::name('cart.')->middleware('auth')->group(function () {
            Route::get('/cart', [FrontController::class, 'cart'])->name('index');
            Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
            Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
            Route::get('/order-success', function () {
                return view('fronts.order-success');
            })->name('success');
        });
        Route::middleware('auth')->name('cart.')->group(function () {
            Route::resource('', CartController::class)
                ->except(['index', 'show', 'edit']);
        });

        // # Single Product ##
        Route::get('/shop/{product}', [FrontController::class, 'singleProduct'])->name('single-product');

        // # Single News ##
        Route::get('/news/{news}', [FrontController::class, 'singleNews'])->name('single-news');
    });
});

// ########### User Dashboard (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ########### Admin Routes
Route::name('admin.')->prefix('admin')->group(function () {

    require __DIR__.'/authAdmin.php';

    // Admin Dashboard
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, '__invoke'])->name('index');

        // Categories
        Route::resource('categories', CategoryController::class)
            ->name('*', 'categories')
            ->except('show')
            ->middleware('permission:view-categories');

        // Products
        Route::resource('products', ProductController::class)
            ->name('*', 'products')
            ->middleware('permission:view-products');

        // About
        Route::resource('abouts', AboutController::class)
            ->name('*', 'abouts');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class)
            ->name('*', 'testimonials')
            ->except(['show', 'edit', 'update']);

        // Contact Us
        Route::resource('contacts', ContactUsController::class)
            ->name('*', 'contacts')
            ->except(['create', 'store', 'edit', 'update']);

        // Settings
        Route::resource('settings', SettingController::class)
            ->name('*', 'settings')
            ->except(['show', 'create', 'store', 'destroy']);

        // Sales
        Route::resource('sales', SaleController::class)
            ->name('*', 'sales')
            ->except(['show', 'create', 'store', 'destroy']);

        // News
        Route::resource('news', NewsController::class)
            ->name('*', 'news');

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index')->middleware('permission:view-orders');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show')->middleware('permission:view-orders');
            Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('status')->middleware('permission:update-order-status');
            Route::post('/{order}/assign-delivery', [OrderController::class, 'assignDelivery'])->name('assign-delivery')->middleware('permission:assign-deliveries');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy')->middleware('permission:delete-orders');
        });

        // Payments
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentManagerController::class, 'index'])->name('index')->middleware('permission:view-payments');
            Route::get('/{payment}', [PaymentManagerController::class, 'show'])->name('show')->middleware('permission:view-payments');
            Route::post('/{payment}/approve', [PaymentManagerController::class, 'approve'])->name('approve')->middleware('permission:approve-payments');
            Route::post('/{payment}/fail', [PaymentManagerController::class, 'markFailed'])->name('fail')->middleware('permission:approve-payments');
            Route::post('/{payment}/refund', [PaymentManagerController::class, 'refund'])->name('refund')->middleware('permission:refund-payments');
        });

        // Invoices
        Route::resource('invoices', InvoiceController::class)
            ->name('*', 'invoices')
            ->only(['index', 'show'])
            ->middleware('permission:view-invoices');

        // Deliveries
        Route::prefix('deliveries')->name('deliveries.')->group(function () {
            Route::get('/', [DeliveryController::class, 'index'])->name('index')->middleware('permission:view-deliveries');
            Route::get('/{order}', [DeliveryController::class, 'show'])->name('show')->middleware('permission:view-deliveries');
            Route::post('/{order}/assign', [DeliveryController::class, 'assignOrder'])->name('assign')->middleware('permission:assign-deliveries');
            Route::put('/{order}/status', [DeliveryController::class, 'updateStatus'])->name('status')->middleware('permission:update-delivery-status');
        });

        // Roles
        Route::resource('roles', RoleController::class)
            ->name('*', 'roles')
            ->middleware('permission:view-roles');

        // Admins Management
        Route::resource('admins', AdminUserController::class)
            ->name('*', 'admins')
            ->middleware('permission:manage-admins');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('permission:view-reports');
    });
});
