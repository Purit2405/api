<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        // ข่าวใหม่ขึ้นก่อน
        $news = News::orderByDesc('created_at')->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'title'        => 'required|string|max:255',
        'content'      => 'nullable|string',
        'image'        => 'nullable|image|max:2048',
        'is_active'    => 'boolean',
        'publish_date' => 'nullable|date',
    ]);

    // อัปโหลดรูป
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')
            ->store('news', 'public');
    }

    // สถานะ
    $data['is_active'] = $request->boolean('is_active');

    // 👉 ถ้าไม่ส่ง publish_date มา → ใช้วันนี้
    $data['publish_date'] = $data['publish_date'] ?? now();

    News::create($data);

    return redirect()
        ->route('admin.news.index')
        ->with('success', 'เพิ่มข่าวเรียบร้อย');
}


    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
            'image'     => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $data['image'] = $request->file('image')
                ->store('news', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $news->update($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'อัปเดตข่าวเรียบร้อย');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return back()->with('success', 'ลบข่าวเรียบร้อย');
    }

    // เปิด / ปิด ข่าว
    public function toggle(News $news)
    {
        $news->update([
            'is_active' => ! $news->is_active
        ]);

        return back();
    }
}
