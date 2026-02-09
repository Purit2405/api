<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    // 📌 ดูโปรโมชั่นทั้งหมด
    public function index()
    {
        return response()->json(
            Promotion::where('is_active', true)->get()
        );
    }

    // 🎁 แลก / ใช้โปรโมชั่น
    public function redeem(Request $request, $id)
    {
        $user = $request->user(); // ใช้ Sanctum
        $promotion = Promotion::findOrFail($id);

        if (! $promotion->canRedeem($user)) {
            return response()->json([
                'message' => 'ไม่สามารถใช้โปรโมชั่นนี้ได้'
            ], 400);
        }

        DB::transaction(function () use ($promotion, $user) {

            // บันทึกการใช้โปรโมชั่น
            PromotionUsage::create([
                'promotion_id' => $promotion->id,
                'user_id' => $user->id,
            ]);

            // บันทึกแต้ม
            PointTransaction::create([
                'user_id' => $user->id,
                'points' => $promotion->points_value,
                'type' => $promotion->type, // reward / redeem
                'source_type' => PointTransaction::SOURCE_PROMOTION,
                'source_id' => $promotion->id,
            ]);
        });

        return response()->json([
            'message' => 'ใช้โปรโมชั่นสำเร็จ'
        ]);
    }
}
