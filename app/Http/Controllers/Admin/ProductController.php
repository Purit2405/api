<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'redeemable'      => 'boolean',
            'image'           => 'nullable|image|max:2048',
        ]);

        $data['redeemable'] = $request->has('redeemable');
        $data['is_active']  = true; // ค่าเริ่มต้น เปิดสินค้า

        if ($request->hasFile('image')) {
            $category = Category::find($data['category_id']);
            $data['image'] = $request->file('image')
                ->store('products/'.$category->slug, 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'redeemable'      => 'boolean',
            'image'           => 'nullable|image|max:2048',
        ]);

        $data['redeemable'] = $request->has('redeemable');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $category = Category::find($data['category_id']);
            $data['image'] = $request->file('image')
                ->store('products/'.$category->slug, 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index');
    }

    /** เปิด / ปิดสินค้า */
    public function toggle(Product $product)
    {
        $product->update([
            'is_active' => ! $product->is_active
        ]);

        return back();
    }

    /** เปิด / ปิดการแลกแต้ม */
    public function toggleRedeem(Product $product)
    {
        $product->update([
            'redeemable' => ! $product->redeemable
        ]);

        return back();
    }
}
