<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\NewsController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Redirect Dashboard (ตาม role)
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', function () {
    return match (Auth::user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->prefix('admin')->name('admin.')->group(function () {

    /*
    |-----------------
    | Dashboard
    |-----------------
    */
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |-----------------
    | Categories
    |-----------------
    */
    Route::resource('categories', CategoryController::class)
        ->except(['show', 'destroy']);

    Route::patch('categories/{category}/toggle',
        [CategoryController::class, 'toggle']
    )->name('categories.toggle');

    /*
    |-----------------
    | Products
    |-----------------
    */
    Route::resource('products', ProductController::class)
        ->except(['show', 'destroy']);

    Route::patch('products/{product}/toggle',
        [ProductController::class, 'toggle']
    )->name('products.toggle');

    /*
    |-----------------
    | Promotions
    |-----------------
    */
    Route::resource('promotions', PromotionController::class)
        ->except(['show', 'destroy']);

    /*
    |-----------------
    | Banners
    |-----------------
    */
    Route::resource('banners', BannerController::class)
        ->except(['show', 'destroy']);

    /*
    |-----------------
    | News
    |-----------------
    */
    Route::resource('news', NewsController::class)
        ->except(['show', 'destroy']);
});
