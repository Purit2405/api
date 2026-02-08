<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    // 🔹 ดึงรายการข่าว
    public function index()
    {
        $news = News::where('is_active', true)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'content' => $item->content,
                    'image' => $item->image
                        ? asset('storage/' . $item->image)
                        : null,
                    'publish_date' => optional($item->publish_date)->format('Y-m-d'),
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $news
        ]);
    }

    // 🔹 ดึงข่าวเดี่ยว (กดเข้าอ่าน)
    public function show(News $news)
    {
        if (! $news->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข่าว'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'image' => $news->image
                    ? asset('storage/' . $news->image)
                    : null,
                'publish_date' => optional($news->publish_date)->format('Y-m-d'),
            ]
        ]);
    }
}
