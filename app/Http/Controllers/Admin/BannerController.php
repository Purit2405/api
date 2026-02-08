<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'link' => 'nullable|string|max:255',
        'sort_order' => 'nullable|integer',
        'image' => 'required|image|max:2048',
    ]);

    $data['image'] = $request->file('image')
        ->store('banners', 'public');

    $data['is_active'] = $request->boolean('is_active');

    Banner::create($data);

    return redirect()
        ->route('admin.banners.index')
        ->with('success', 'เพิ่ม Banner เรียบร้อย');
}


    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
{
    $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'link' => 'nullable|string|max:255',
        'sort_order' => 'nullable|integer',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($banner->image);

        $data['image'] = $request->file('image')
            ->store('banners', 'public');
    }

    $data['is_active'] = $request->boolean('is_active');

    $banner->update($data);

    return redirect()
        ->route('admin.banners.index')
        ->with('success', 'อัปเดต Banner เรียบร้อย');
}
    
    public function toggle(Banner $banner)
{
    $banner->update([
        'is_active' => ! $banner->is_active
    ]);

    return back()->with('success', 'อัปเดตสถานะ Banner แล้ว');
}
}
