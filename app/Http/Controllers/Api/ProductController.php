<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * GET /api/public/products
     */
    public function index()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->orderBy('id')
            ->get()
            ->map(fn (Product $p) => [
                'id'          => $p->id,
                'name'        => $p->name,
                'description' => $p->description,
                'price'       => (float) $p->price,
                'image'       => $p->image
                    ? asset('storage/products/' . $p->image)
                    : null,

                // แต้ม
                'redeemable'      => (bool) $p->redeemable,
                'points_required' => $p->points_required,

                // หมวดหมู่
                'category' => $p->category ? [
                    'id'   => $p->category->id,
                    'name' => $p->category->name,
                ] : null,
            ]);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
