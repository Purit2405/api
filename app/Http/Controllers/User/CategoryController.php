<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // โหลดสินค้าที่เปิดใช้งานในหมวดนี้
        $products = $category->products()
            ->where('is_active', true)
            ->get();

        return view('user.categories.show', compact(
            'category',
            'products'
        ));
    }
}
