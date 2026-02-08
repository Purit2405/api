<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'type' => 'required|in:reward,redeem',
            'points_value' => 'required|integer|min:1',
            'max_total' => 'nullable|integer|min:1',
            'max_per_user' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        Promotion::create($data);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'เพิ่มโปรโมชั่นเรียบร้อย');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'type' => 'required|in:reward,redeem',
            'points_value' => 'required|integer|min:1',
            'max_total' => 'nullable|integer|min:1',
            'max_per_user' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($promotion->image) {
                Storage::disk('public')->delete($promotion->image);
            }

            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        $promotion->update($data);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'อัปเดตเรียบร้อย');
    }

    // ✅ เพิ่ม
    public function toggle(Promotion $promotion)
    {
        $promotion->update([
            'is_active' => ! $promotion->is_active
        ]);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'เปลี่ยนสถานะโปรโมชั่นเรียบร้อย');
    }

    // ✅ เพิ่ม
    public function destroy(Promotion $promotion)
    {
        if ($promotion->image) {
            Storage::disk('public')->delete($promotion->image);
        }

        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'ลบโปรโมชั่นเรียบร้อย');
    }
}
