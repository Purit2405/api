<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * 🔐 เข้าสู่ระบบ
     * Route: POST /api/auth/login
     */
    public function __invoke(Request $request)
    {
        // -------------------------------
        // 1) Validate input
        // -------------------------------
        $validated = $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
            'remember_me' => 'nullable|boolean',
        ]);

        // -------------------------------
        // 2) ค้นหาผู้ใช้
        // -------------------------------
        $user = User::where('email', $validated['email'])->first();

        // -------------------------------
        // 3) ตรวจสอบรหัสผ่าน
        // -------------------------------
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
            ], 401);
        }

        // -------------------------------
        // 4) ลบ token เก่าทั้งหมด
        // -------------------------------
        $user->tokens()->delete();

        // -------------------------------
        // 5) สร้าง token ใหม่
        // -------------------------------
        $tokenResult = $user->createToken('android');

        // remember me
        $expiresAt = !empty($validated['remember_me']) && $validated['remember_me']
            ? Carbon::now()->addYear()   // 1 ปี
            : Carbon::now()->addMonth(); // 1 เดือน

        $tokenResult->accessToken->expires_at = $expiresAt;
        $tokenResult->accessToken->save();

        // -------------------------------
        // 6) Response
        // -------------------------------
        return response()->json([
            'success' => true,
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'data' => [
                'user' => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'token'      => $tokenResult->plainTextToken,
                'expires_at' => $expiresAt,
            ]
        ]);
    }
}
