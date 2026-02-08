<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * แสดงรายการสินค้า (รวมสินค้าที่อยู่ในหมวดปิด)
     */
    public function index()
    {
        $products = Product::withoutGlobalScope('active_category')
            ->with('category')
            ->latest()
            ->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * ฟอร์มเพิ่มสินค้า
     */
    public function create()
    {
        // เลือกได้เฉพาะหมวดที่เปิด
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * บันทึกสินค้าใหม่
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'image'           => 'nullable|image|max:2048',
        ]);

        $data['redeemable'] = $request->boolean('redeemable');
        $data['is_active']  = $request->boolean('is_active');

        // อัปโหลดรูป (แยกตาม slug หมวด)
        if ($request->hasFile('image')) {
            $category = Category::findOrFail($data['category_id']);

            $data['image'] = $request->file('image')
                ->store("products/{$category->slug}", 'public');
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'เพิ่มสินค้าเรียบร้อย');
    }

    /**
     * ฟอร์มแก้ไขสินค้า
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * อัปเดตสินค้า
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'image'           => 'nullable|image|max:2048',
        ]);

        $data['redeemable'] = $request->boolean('redeemable');
        $data['is_active']  = $request->boolean('is_active');

        // เปลี่ยนรูป
        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $category = Category::findOrFail($data['category_id']);

            $data['image'] = $request->file('image')
                ->store("products/{$category->slug}", 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'อัปเดตสินค้าเรียบร้อย');
    }

    /**
     * ลบสินค้า
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'ลบสินค้าเรียบร้อย');
    }

    /**
     * ✅ toggle สถานะสินค้า (เปิด / ปิดการแสดง)
     * route: admin/products/{product}/toggle
     */
    public function toggle(Product $product): RedirectResponse
    {
        // กำลังจะ "เปิดสินค้า"
        if (! $product->is_active) {

            // ❌ หมวดหมู่ถูกปิด
            if (! $product->category || ! $product->category->is_active) {
                return back()->withErrors(
                    'ไม่สามารถเปิดสินค้าได้ เนื่องจากหมวดหมู่ของสินค้านี้ถูกปิดอยู่ กรุณาเปิดหมวดหมู่ก่อน'
                );
            }
        }

        $product->update([
            'is_active' => ! $product->is_active
        ]);

        return back()->with(
            'success',
            $product->is_active
                ? 'เปิดการแสดงสินค้าเรียบร้อย'
                : 'ปิดการแสดงสินค้าเรียบร้อย'
        );
    }

    /**
     * ✅ toggle การแลกแต้ม
     * route: admin/products/{product}/toggle-redeem
     */
    public function toggleRedeem(Product $product): RedirectResponse
    {
        // ❌ สินค้าปิด หรือ หมวดหมู่ปิด
        if (
            ! $product->is_active ||
            ! $product->category ||
            ! $product->category->is_active
        ) {
            return back()->withErrors(
                'ไม่สามารถเปิดแลกแต้มได้ เนื่องจากสินค้าหรือหมวดหมู่ถูกปิดอยู่'
            );
        }

        $product->update([
            'redeemable' => ! $product->redeemable,
        ]);

        return back()->with(
            'success',
            $product->redeemable
                ? 'เปิดการแลกแต้มเรียบร้อย'
                : 'ปิดการแลกแต้มเรียบร้อย'
        );
    }
}
