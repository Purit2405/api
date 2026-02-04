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

        return view('user.dashboard', [
            'user' => $user,

            'wallet' => PointWallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            ),

            'transactions' => PointTransaction::where('user_id', $user->id)
                ->latest()
                ->limit(10)
                ->get(),

            'banners' => Banner::where('is_active', true)->get(),

            'news' => News::latest()
                ->limit(5)
                ->get(),

            'categories' => Category::where('is_active', true)
                ->with(['products' => function ($q) {
                    $q->where('is_active', true);
                }])
                ->get(),

            'products' => Product::with('category')
                ->where('is_active', true)
                ->get(),

            'promotions' => Promotion::where('is_active', true)->get(),
        ]);
    }
}
