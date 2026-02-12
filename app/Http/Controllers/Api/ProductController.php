<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
                    ? asset('storage/' . $p->image)
                    : null,
                'redeemable'      => (bool) $p->redeemable,
                'points_required' => $p->points_required,
                'category' => $p->category ? [
                    'id'   => $p->category->id,
                    'name' => $p->category->name,
                ] : null,
            ]);

        return response()->json([
            'success' => true,
            'data'    => $products,
        ]);
    }
}