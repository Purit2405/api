<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * GET /api/public/banners
     * ดึงรายการแบนเนอร์ที่เปิดใช้งานอยู่ส่งไปให้ Android App
     */
    public function index(): JsonResponse
    {
        $banners = Banner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($b) => [
                'id'    => $b->id,
                // แก้ไข: ลบ /banners/ ออก เพราะในฐานข้อมูลมี Path นี้ติดมาอยู่แล้ว
                'image' => $b->image 
                    ? asset('storage/' . $b->image) 
                    : null,
                'link'  => $b->link,
            ]);

        return response()->json([
            'success' => true,
            'data'    => $banners,
        ]);
    }
}