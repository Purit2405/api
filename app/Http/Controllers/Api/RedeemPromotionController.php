<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Models\PointTransaction;
use App\Models\PointWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedeemPromotionController extends Controller
{
    /**
     * 🎁 แลก / ใช้โปรโมชั่น
     * POST /api/redeem/promotion/{promotion}
     */
    public function redeem(Request $request, Promotion $promotion)
    {
        $user   = $request->user();
        $wallet = PointWallet::ofUser($user->id);

        // ❌ โปรโมชั่นไม่เปิดใช้งาน
        if (! $promotion->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'โปรโมชั่นนี้ไม่สามารถใช้งานได้'
            ], 400);
        }

        // ❌ ตรวจสอบเงื่อนไขการใช้
        if (! $promotion->canRedeem($user)) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่สามารถใช้โปรโมชั่นนี้ได้'
            ], 400);
        }

        // ❌ กรณี redeem แต่แต้มไม่พอ
        if (
            $promotion->type === 'redeem' &&
            $wallet->balance < $promotion->points_value
        ) {
            return response()->json([
                'success' => false,
                'message' => 'แต้มของคุณไม่เพียงพอ'
            ], 400);
        }

        DB::transaction(function () use ($promotion, $user, $wallet) {

            // 1️⃣ บันทึกการใช้โปรโมชั่น
            PromotionUsage::create([
                'promotion_id' => $promotion->id,
                'user_id'      => $user->id,
            ]);

            // 2️⃣ เพิ่ม / ลดแต้ม (ผ่าน Wallet เท่านั้น)
            if ($promotion->type === 'reward') {

                $wallet->addPoints(
                    $promotion->points_value,
                    PointTransaction::TYPE_REWARD,
                    PointTransaction::SOURCE_PROMOTION,
                    $promotion->id,
                    'รับแต้มจากโปรโมชั่น: ' . $promotion->title
                );

            } else {

                $wallet->spendPoints(
                    $promotion->points_value,
                    PointTransaction::TYPE_REDEEM,
                    PointTransaction::SOURCE_PROMOTION,
                    $promotion->id,
                    'ใช้โปรโมชั่น: ' . $promotion->title
                );
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'ใช้โปรโมชั่นสำเร็จ'
        ]);
    }
}
