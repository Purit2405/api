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
            'id'    => $c->id,
            'name'  => $c->name,
            // ใน Model คุณใช้ image ดังนั้นต้องดึงจาก $c->image
            'image' => $c->image 
                ? asset('storage/' . $c->image) 
                : null,
        ]);

    return response()->json([
        'success' => true,
        'data' => $categories,
    ]);
}
}
