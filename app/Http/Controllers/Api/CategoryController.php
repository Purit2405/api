<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * GET /api/public/categories
     */
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get()
            ->map(fn ($c) => [
                'id'   => $c->id,
                'name' => $c->name,
                'icon' => $c->icon
                    ? asset('storage/categories/' . $c->icon)
                    : null,
            ]);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}
