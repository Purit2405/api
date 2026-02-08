<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PointWallet;

class RegisterController extends Controller
{
    /**
     * 📝 สมัครสมาชิก
     * POST /api/auth/register
     */
    public function __invoke(Request $request)
    {
        // 1) Validate
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'required|string|unique:users,phone',
            'password'              => 'required|min:6|confirmed',
        ]);

        try {
            // 2) สร้างผู้ใช้
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role'     => 'user',
            ]);

            // 3) สร้างกระเป๋าแต้ม
            PointWallet::create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);

            // 4) ลบ token เก่า
            $user->tokens()->delete();

            // 5) สร้าง token ใหม่ (Sanctum)
            $token = $user->createToken('android')->plainTextToken;

            // 6) Response
            return response()->json([
                'success' => true,
                'message' => 'สมัครสมาชิกสำเร็จ',
                'data' => [
                    'user' => [
                        'id'    => $user->id,
                        'name'  => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ],
                    'token' => $token,
                ]
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
