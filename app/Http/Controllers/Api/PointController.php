<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PointWallet;
use App\Models\PointTransaction;

class PointController extends Controller
{
    /**
     * 🔹 ดูแต้มคงเหลือของผู้ใช้
     * Route: GET /api/user/points/wallet
     * Middleware: auth:sanctum
     */
    public function wallet(Request $request)
    {
        $user = $request->user(); // ✅ ดึงจาก token เท่านั้น

        $wallet = PointWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        return response()->json([
            'success' => true,
            'data' => [
                'user_id' => $user->id,
                'balance' => $wallet->balance,
            ]
        ]);
    }

    /**
     * 🔹 ดูประวัติแต้ม
     * Route: GET /api/user/points/history
     * Middleware: auth:sanctum
     */
    public function history(Request $request)
    {
        $user = $request->user();

        $transactions = PointTransaction::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function (PointTransaction $t) {
                return [
                    'id'           => $t->id,
                    'type'         => $t->type,          // reward | redeem | adjust
                    'points'       => $t->points,        // + / -
                    'description'  => $t->description,
                    'source_type'  => $t->source_type,   // product | promotion | manual
                    'source_name'  => $t->source_name,   // accessor จาก model
                    'created_at'   => $t->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }
}
