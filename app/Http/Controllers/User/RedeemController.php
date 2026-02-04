<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\PointWallet;
use Illuminate\Http\JsonResponse;

class RedeemController extends Controller
{
    /**
     * 🛒 แลกสินค้า
     */
    public function redeemProduct(int $id): JsonResponse
    {
        $user = auth()->user();

        $product = Product::with('category')->findOrFail($id);

        // ตรวจสอบสถานะสินค้า + หมวดหมู่
        if (
            ! $product->is_active ||
            ! $product->category ||
            ! $product->category->is_active
        ) {
            return response()->json([
                'message' => 'รายการนี้ยังไม่เปิดให้แลก'
            ], 403);
        }

        $wallet = PointWallet::ofUser($user->id);

        try {
            $wallet->spendPoints(
                $product->points_required,
                'redeem',
                'product',
                $product->id,
                'แลกสินค้า: ' . $product->name
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'แลกสินค้าสำเร็จ',
            'balance' => $wallet->fresh()->balance
        ]);
    }

    /**
     * 🎁 แลกโปรโมชั่น
     */
    public function redeemPromotion(int $id): JsonResponse
    {
        $user = auth()->user();

        $promotion = Promotion::findOrFail($id);

        if (! $promotion->is_active) {
            return response()->json([
                'message' => 'โปรโมชั่นนี้ยังไม่เปิดให้ใช้'
            ], 403);
        }

        $wallet = PointWallet::ofUser($user->id);

        try {
            $wallet->spendPoints(
                $promotion->points_required,
                'redeem',
                'promotion',
                $promotion->id,
                'แลกโปร: ' . $promotion->title
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'แลกโปรโมชั่นสำเร็จ',
            'balance' => $wallet->fresh()->balance
        ]);
    }
}
