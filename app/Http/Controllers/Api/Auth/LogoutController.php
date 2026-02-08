<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * 🔐 ออกจากระบบ (ลบ token ปัจจุบัน)
     * Route: POST /api/auth/logout
     * Middleware: auth:sanctum
     */
    public function __invoke(Request $request)
    {
        // -------------------------------
        // 1) ลบ token ที่ใช้งานอยู่
        // -------------------------------
        $request->user()->currentAccessToken()->delete();

        // -------------------------------
        // 2) Response
        // -------------------------------
        return response()->json([
            'success' => true,
            'message' => 'ออกจากระบบเรียบร้อย',
        ]);
    }
}
