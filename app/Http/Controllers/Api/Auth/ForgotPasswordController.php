<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * POST /api/auth/forgot-password
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'ส่งลิงก์รีเซ็ทรหัสผ่านไปที่อีเมลแล้ว'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'ไม่พบอีเมลนี้ในระบบ'
        ], 404);
    }
}
