<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| MODELS
|--------------------------------------------------------------------------
*/
use App\Models\User;
use App\Models\PointWallet;

/*
|--------------------------------------------------------------------------
| API CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PointController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| AUTH API (PUBLIC)
|--------------------------------------------------------------------------
| สมัคร / เข้าสู่ระบบ
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {

    // POST /api/auth/register
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
                'user' => $user->only('id', 'name', 'email', 'phone'),
                'token' => $token->plainTextToken,
                'expires_at' => $expiresAt,
            ]
        ], 201);
    });

    // POST /api/auth/login
    Route::post('/login', function (Request $request) {

        $validated = $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
            'remember_me' => 'nullable|boolean',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
            ], 401);
        }

        $user->tokens()->delete();

        $expiresAt = $request->boolean('remember_me')
            ? Carbon::now()->addYear()
            : Carbon::now()->addMonth();

        $token = $user->createToken('android');
        $token->accessToken->expires_at = $expiresAt;
        $token->accessToken->save();

        return response()->json([
            'success' => true,
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'data' => [
                'user' => $user->only('id', 'name', 'email', 'phone'),
                'token' => $token->plainTextToken,
                'expires_at' => $expiresAt,
            ]
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| USER API (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('user')->group(function () {

    // ✅ GET /api/user/me
    Route::get('/me', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    });

    // POST /api/user/logout
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'ออกจากระบบเรียบร้อย'
        ]);
    });

    // POINT SYSTEM
    Route::get('/points/wallet', [PointController::class, 'wallet']);
    Route::get('/points/history', [PointController::class, 'history']);
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
