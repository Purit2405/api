<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

// Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PointTransactionController;

// User
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RedeemController;

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
| Redirect Dashboard ตาม Role
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

    /* ================= Dashboard ================= */
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    /* ================= Categories ================= */
    Route::resource('categories', CategoryController::class)
        ->except(['show', 'destroy']);

    Route::patch('categories/{category}/toggle',
        [CategoryController::class, 'toggle']
    )->name('categories.toggle');

    /* ================= Products ================= */
    Route::resource('products', ProductController::class)
        ->except(['show', 'destroy']);

    // เปิด / ปิดการแสดงสินค้า (user จะไม่เห็น)
    Route::patch('products/{product}/toggle',
        [ProductController::class, 'toggle']
    )->name('products.toggle');

    // เปิด / ปิดการแลกแต้ม (สินค้าแสดง แต่แลกไม่ได้)
    Route::patch('products/{product}/toggle-redeem',
        [ProductController::class, 'toggleRedeem']
    )->name('products.toggleRedeem');

    /* ================= Promotions ================= */
    Route::resource('promotions', PromotionController::class)
        ->except(['show', 'destroy']);

    /* ================= Banners ================= */
    Route::resource('banners', BannerController::class)
        ->except(['show', 'destroy']);

    /* ================= News ================= */
    Route::resource('news', NewsController::class)
        ->except(['show', 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Point Transactions ⭐
    |--------------------------------------------------------------------------
    */

    // ประวัติแต้ม
    Route::get('/point-transactions',
        [PointTransactionController::class, 'index']
    )->name('point-transactions.index');

    // หน้าเพิ่มแต้ม
    Route::get('/point-transactions/create',
        [PointTransactionController::class, 'create']
    )->name('point-transactions.create');

    // บันทึกเพิ่มแต้ม
    Route::post('/point-transactions',
        [PointTransactionController::class, 'store']
    )->name('point-transactions.store');

    // ค้นหาผู้ใช้จากเบอร์ (AJAX)
    Route::get('/point-transactions/find-user', function (Request $request) {
        $user = \App\Models\User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'name'  => $user->name,
        ]);
    })->name('point-transactions.find-user');

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

    // Dashboard ผู้ใช้
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // แลกสินค้า
    Route::post('/redeem/product/{id}',
        [RedeemController::class, 'redeemProduct']
    )->name('redeem.product');

    // แลกโปรโมชั่น
    Route::post('/redeem/promotion/{id}',
        [RedeemController::class, 'redeemPromotion']
    )->name('redeem.promotion');
});
