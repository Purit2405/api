<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\PointWallet;
use App\Models\PointTransaction;

class RedeemProductController extends Controller
{
    /**
     * POST /api/redeem/product/{product}
     */
    public function redeem(Request $request, Product $product)
    {
        $user   = $request->user();
        $wallet = PointWallet::ofUser($user->id);

        // ❌ ตรวจสถานะสินค้า
        if (
            ! $product->is_active ||
            ! $product->redeemable ||
            ! $product->category ||
            ! $product->category->is_active
        ) {
            return response()->json([
                'success' => false,
                'message' => 'สินค้านี้ไม่สามารถแลกได้'
            ], 403);
        }

        // ❌ ไม่ได้ตั้งแต้ม
        if ($product->points_required <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'สินค้านี้ไม่รองรับการแลกแต้ม'
            ], 400);
        }

        // ❌ แต้มไม่พอ
        if ($wallet->balance < $product->points_required) {
            return response()->json([
                'success' => false,
                'message' => 'แต้มของคุณไม่เพียงพอ'
            ], 400);
        }

        DB::transaction(function () use ($wallet, $product) {
            $wallet->spendPoints(
                $product->points_required,
                PointTransaction::TYPE_REDEEM,
                PointTransaction::SOURCE_PRODUCT,
                $product->id,
                'แลกสินค้า: ' . $product->name
            );
        });

        return response()->json([
            'success' => true,
            'message' => 'แลกสินค้าเรียบร้อย'
        ]);
    }
}
