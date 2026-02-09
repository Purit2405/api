<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\PointWallet;

/*
|--------------------------------------------------------------------------
| API CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PointController;
use App\Http\Controllers\Api\PointTransactionController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| REDEEM API (PROTECTED)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Api\RedeemProductController;
use App\Http\Controllers\Api\RedeemPromotionController;

/*
|--------------------------------------------------------------------------
| AUTH API (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {

    // ✅ REGISTER
    Route::post('/register', function (Request $request) {

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        // สร้าง wallet
        PointWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        $user->tokens()->delete();

        $token = $user->createToken('android');
        $expiresAt = Carbon::now()->addMonth();

        $token->accessToken->expires_at = $expiresAt;
        $token->accessToken->save();

        return response()->json([
            'success' => true,
            'message' => 'สมัครสมาชิกสำเร็จ',
            'data' => [
                'user' => $user->only('id','name','email','phone'),
                'token' => $token->plainTextToken,
                'expires_at' => $expiresAt,
            ]
        ], 201);
    });

    // ✅ LOGIN
    Route::post('/login', function (Request $request) {

        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
            ], 401);
        }

        $user->tokens()->delete();

        $expiresAt = Carbon::now()->addMonth();

        $token = $user->createToken('android');
        $token->accessToken->expires_at = $expiresAt;
        $token->accessToken->save();

        return response()->json([
            'success' => true,
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'data' => [
                'user' => $user->only('id','name','email','phone'),
                'token' => $token->plainTextToken,
                'expires_at' => $expiresAt,
            ]
        ]);
    });

    // ✅ FORGOT PASSWORD
    Route::post('/forgot-password', ForgotPasswordController::class);
});

/*
|--------------------------------------------------------------------------
| USER API (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('user')->group(function () {

    // 👤 PROFILE
    Route::get('/me', fn (Request $request) => response()->json([
        'success' => true,
        'data' => $request->user(),
    ]));

    // 🚪 LOGOUT
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'ออกจากระบบเรียบร้อย'
        ]);
    });

    // 💰 POINT
    Route::get('/points/wallet', [PointController::class, 'wallet']);
    Route::get('/points/history', [PointTransactionController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| REDEEM API (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // 🛒 แลกสินค้า
    // POST /api/redeem/product/{product}
    Route::post(
        '/redeem/product/{product}',
        [RedeemProductController::class, 'redeem']
    );

    // 🎁 แลกโปรโมชั่น
    // POST /api/redeem/promotion/{promotion}
    Route::post(
        '/redeem/promotion/{promotion}',
        [RedeemPromotionController::class, 'redeem']
    );
});

/*
|--------------------------------------------------------------------------
| PUBLIC DATA API
|--------------------------------------------------------------------------
*/
Route::prefix('public')->group(function () {

    Route::get('/banners', [BannerController::class, 'index']);

    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{news}', [NewsController::class, 'show']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
});
