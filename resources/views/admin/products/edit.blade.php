<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold">
                ✏️ แก้ไขสินค้า
            </h2>

            <a href="{{ route('admin.products.index') }}"
               class="text-sm text-gray-600 hover:text-indigo-600">
                ← กลับไปหน้ารายการสินค้า
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">

        <form method="POST"
              action="{{ route('admin.products.update', $product) }}"
              enctype="multipart/form-data"
              class="bg-white shadow rounded-xl p-6 space-y-6">

            @csrf
            @method('PUT')

            {{-- หมวดหมู่ --}}
            <div>
                <label class="block font-medium mb-1">
                    หมวดหมู่ <span class="text-red-500">*</span>
                </label>
                <select name="category_id"
                        required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ชื่อสินค้า --}}
            <div>
                <label class="block font-medium mb-1">
                    ชื่อสินค้า <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    required
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                >
            </div>

            {{-- รายละเอียด --}}
            <div>
                <label class="block font-medium mb-1">
                    รายละเอียดสินค้า
                </label>
                <textarea
                    name="description"
                    rows="4"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                >{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- ราคา + แต้ม --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block font-medium mb-1">
                        ราคา (บาท) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        value="{{ old('price', $product->price) }}"
                        required
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                    >
                </div>

                <div>
                    <label class="block font-medium mb-1">
                        แต้มที่ใช้แลก
                    </label>
                    <input
                        type="number"
                        name="points_required"
                        value="{{ old('points_required', $product->points_required) }}"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                    >
                </div>

            </div>

            {{-- ตัวเลือก --}}
            <div class="space-y-3">

                {{-- redeemable --}}
                <input type="hidden" name="redeemable" value="0">
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="redeemable"
                           value="1"
                           {{ old('redeemable', $product->redeemable) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600">
                    <span>เปิดให้แลกด้วยแต้ม</span>
                </label>

                {{-- is_active --}}
                <input type="hidden" name="is_active" value="0">
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600">
                    <span>เปิดการใช้งานสินค้า</span>
                </label>

            </div>

            {{-- รูปเดิม --}}
            @if($product->image)
                <div>
                    <label class="block font-medium mb-1">
                        รูปสินค้าปัจจุบัน
                    </label>
                    <img
                        src="{{ asset('storage/'.$product->image) }}"
                        class="w-32 h-32 object-cover rounded-xl border shadow"
                    >
                </div>
            @endif

            {{-- เปลี่ยนรูป --}}
            <div>
                <label class="block font-medium mb-1">
                    เปลี่ยนรูปสินค้า (ถ้าต้องการ)
                </label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="block w-full text-sm text-gray-600
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-indigo-50 file:text-indigo-700
                           hover:file:bg-indigo-100"
                >
                <p class="text-xs text-gray-500 mt-1">
                    ถ้าไม่เลือก ระบบจะใช้รูปเดิม
                </p>
            </div>

            {{-- ปุ่ม --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    ยกเลิก
                </a>

                <button
                    type="submit"
                    class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow">
                    💾 อัปเดตสินค้า
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
