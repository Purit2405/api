<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Banner;
use App\Models\News;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\PointTransaction;
use App\Models\PointWallet;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 💰 Wallet
        $wallet = PointWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        // 📜 ประวัติแต้มล่าสุด 10 รายการ
        $transactions = PointTransaction::where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        // 🖼 Banner (สำหรับ slider)
        $banners = Banner::where('is_active', true)
            ->orderBy('id') // หรือ orderBy('position') ถ้ามี
            ->get();

        // 📰 News
        $news = News::latest()
            ->limit(5)
            ->get();

        // 🗂 Categories + Products
        $categories = Category::where('is_active', true)
            ->with(['products' => function ($q) {
                $q->where('is_active', true);
            }])
            ->get();

        // 🛒 Products
        $products = Product::where('is_active', true)
    ->whereHas('category', function ($q) {
        $q->where('is_active', true);
    })
    ->with('category')
    ->get();


        // 🎁 Promotions
        $promotions = Promotion::where('is_active', true)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'wallet',
            'transactions',
            'banners',
            'news',
            'categories',
            'products',
            'promotions'
        ));
    }
}
