<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * GET /api/public/banners
     */
    public function index()
    {
        $banners = Banner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($b) => [
                'id'    => $b->id,
                'image' => $b->image
                    ? asset('storage/banners/' . $b->image)
                    : null,
                'link'  => $b->link,
            ]);

        return response()->json([
            'success' => true,
            'data' => $banners,
        ]);
    }
}
