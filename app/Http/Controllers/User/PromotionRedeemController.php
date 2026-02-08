<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\PointWallet;
use App\Models\PromotionUsage;
use Exception;

class PromotionRedeemController extends Controller
{
    /**
     * ใช้งานโปรโมชั่น
     */
    public function store(Request $request, Promotion $promotion)
    {
        $user = Auth::user();

        // ❌ เช็คสิทธิ์ก่อน
        if (! $promotion->canRedeem($user)) {
            return back()->withErrors('โปรโมชั่นนี้ไม่สามารถใช้งานได้แล้ว');
        }

        $wallet = PointWallet::ofUser($user->id);

        // ❌ แต้มไม่พอ
        if (
            $promotion->type === 'redeem' &&
            $wallet->balance < $promotion->points_value
        ) {
            return back()->withErrors('แต้มของคุณไม่เพียงพอ');
        }

        DB::beginTransaction();

        try {

            if ($promotion->type === 'redeem') {

                // 🔻 ใช้แต้ม
                $wallet->spendPoints(
                    $promotion->points_value,
                    'redeem',
                    'promotion',
                    $promotion->id,
                    'ใช้แต้มแลกโปรโมชั่น: ' . $promotion->title
                );

                // ✅ บันทึกการใช้งาน (นับ max_per_user)
                PromotionUsage::create([
                    'promotion_id' => $promotion->id,
                    'user_id'      => $user->id,
                ]);

            } else {

                // 🔺 รับแต้ม (ไม่ล็อกสิทธิ์)
                $wallet->addPoints(
                    $promotion->points_value,
                    'reward',
                    'promotion',
                    $promotion->id,
                    'รับแต้มจากโปรโมชั่น: ' . $promotion->title
                );
            }

            DB::commit();

            return back()->with('success', 'ใช้โปรโมชั่นเรียบร้อย 🎉');

        } catch (Exception $e) {

            DB::rollBack();

            return back()->withErrors(
                'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง'
            );
        }
    }
}
