<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

// ===== Admin Controllers =====
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PointTransactionController;

// ===== User Controllers =====
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RedeemController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect ตาม Role
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
| Admin Routes 👑
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->prefix('admin')->name('admin.')->group(function () {

    /* ===== Dashboard ===== */
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    /* ===== Categories ===== */
    Route::resource('categories', AdminCategoryController::class)
        ->except(['show', 'destroy']);

    Route::patch('categories/{category}/toggle', [
        AdminCategoryController::class, 'toggle'
    ])->name('categories.toggle');

    /* ===== Products ===== */
    Route::resource('products', ProductController::class)
        ->except(['show', 'destroy']);

    Route::patch('products/{product}/toggle', [
        ProductController::class, 'toggle'
    ])->name('products.toggle');

    Route::patch('products/{product}/toggle-redeem', [
        ProductController::class, 'toggleRedeem'
    ])->name('products.toggleRedeem');

    /* ===== Promotions ===== */
    Route::resource('promotions', PromotionController::class)
        ->except(['show']);

    Route::patch('promotions/{promotion}/toggle', [
        PromotionController::class, 'toggle'
    ])->name('promotions.toggle');

    /* ===== Banners ===== */
    Route::resource('banners', BannerController::class)
        ->except(['show', 'destroy']);

    Route::patch('banners/{banner}/toggle', [
        BannerController::class, 'toggle'
    ])->name('banners.toggle');

    /* ===== News ===== */
    Route::resource('news', NewsController::class)
        ->except(['show']);

    Route::patch('news/{news}/toggle', [
        NewsController::class, 'toggle'
    ])->name('news.toggle');

    /* ===== Point Transactions ===== */
    Route::get('point-transactions', [
        PointTransactionController::class, 'index'
    ])->name('point-transactions.index');

    Route::get('point-transactions/create', [
        PointTransactionController::class, 'create'
    ])->name('point-transactions.create');

    Route::post('point-transactions', [
        PointTransactionController::class, 'store'
    ])->name('point-transactions.store');

    Route::get('point-transactions/find-user', [
        PointTransactionController::class, 'findUser'
    ])->name('point-transactions.find-user');
});

/*
|--------------------------------------------------------------------------
| User Routes 🙋‍♂️
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('user')->name('user.')->group(function () {

    /* ===== Dashboard ===== */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /* ===== Redeem ===== */
    Route::post('/redeem/product/{product}', [
        RedeemController::class, 'redeemProduct'
    ])->name('redeem.product');

    Route::post('/redeem/promotion/{promotion}', [
        RedeemController::class, 'redeemPromotion'
    ])->name('redeem.promotion');

    /* ===== Categories (User View) ===== */
    Route::get('/categories/{category}', [
        UserCategoryController::class, 'show'
    ])->name('categories.show');
});
