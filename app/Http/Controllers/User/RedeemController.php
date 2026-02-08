<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Models\PointWallet;
use App\Models\PointTransaction;

class RedeemController extends Controller
{
    /* ===============================
     | แลกสินค้า
     =============================== */
    public function redeemProduct($id)
    {
        $user = Auth::user();
        $wallet = PointWallet::ofUser($user->id);

        $product = Product::where('is_active', true)
            ->where('redeemable', true)
            ->findOrFail($id);

        if (! $product->points_required || $product->points_required <= 0) {
            return back()->with('error', 'สินค้านี้ไม่สามารถแลกด้วยแต้มได้');
        }

        try {
            DB::transaction(function () use ($wallet, $product) {

                $wallet->spendPoints(
                    $product->points_required,
                    PointTransaction::TYPE_REDEEM,
                    PointTransaction::SOURCE_PRODUCT, // ✅ ถูกต้อง
                    $product->id,
                    'แลกสินค้า: ' . $product->name
                );
            });

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'แลกสินค้าเรียบร้อย');
    }

    /* ===============================
     | ใช้โปรโมชั่น
     =============================== */
    public function redeemPromotion($id)
{
    $user = Auth::user();
    $wallet = PointWallet::ofUser($user->id);

    $promotion = Promotion::where('is_active', true)->findOrFail($id);

    if (! $promotion->canRedeem($user)) {
        return back()->with('error', 'คุณใช้โปรโมชั่นนี้ครบจำนวนแล้ว');
    }

    DB::transaction(function () use ($promotion, $wallet, $user) {

        if ($promotion->type === 'redeem') {
            $wallet->spendPoints(
                $promotion->points_value,
                PointTransaction::TYPE_REDEEM,
                PointTransaction::SOURCE_PROMOTION,
                $promotion->id,
                'ใช้โปรโมชั่น: ' . $promotion->title
            );
        }

        if ($promotion->type === 'reward') {
            $wallet->addPoints(
                $promotion->points_value,
                PointTransaction::TYPE_REWARD,
                PointTransaction::SOURCE_PROMOTION,
                $promotion->id,
                'รับแต้มจากโปรโมชั่น: ' . $promotion->title
            );
        }

        // ✅ บันทึกทุกครั้ง
        PromotionUsage::create([
            'promotion_id' => $promotion->id,
            'user_id'      => $user->id,
        ]);
    });

    return back()->with('success', 'ใช้โปรโมชั่นเรียบร้อย 🎉');
}

}
