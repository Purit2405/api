<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * 🔹 ดึงรายการข่าวทั้งหมด (เฉพาะที่เปิดใช้งาน)
     * Route: GET /api/public/news
     */
    public function index()
    {
        $news = News::where('is_active', true)
            ->orderByDesc('created_at')
            ->get()
            ->map(function (News $item) {
                return [
                    'id'           => $item->id,
                    'title'        => $item->title,
                    'content'      => $item->content,
                    'image'        => $item->image
                        ? asset('storage/' . $item->image)
                        : null,
                    'publish_date' => optional($item->publish_date)->format('Y-m-d'),
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $news,
        ]);
    }

    /**
     * 🔹 ดึงข่าวเดี่ยว (กดเข้าอ่าน)
     * Route: GET /api/public/news/{news}
     */
    public function show(News $news)
    {
        // ป้องกันข่าวที่ถูกปิด
        if (! $news->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข่าว',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id'           => $news->id,
                'title'        => $news->title,
                'content'      => $news->content,
                'image'        => $news->image
                    ? asset('storage/' . $news->image)
                    : null,
                'publish_date' => optional($news->publish_date)->format('Y-m-d'),
            ]
        ]);
    }
}
