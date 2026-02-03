<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            ✏️ แก้ไขสินค้า
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.products.update', $product) }}"
                  enctype="multipart/form-data"
                  class="space-y-5">

                @csrf
                @method('PUT')

                {{-- หมวดหมู่ --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        หมวดหมู่สินค้า
                    </label>
                    <select name="category_id"
                            class="w-full border rounded p-2"
                            required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                @selected($product->category_id == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ชื่อ --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        ชื่อสินค้า
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           class="w-full border rounded p-2"
                           required>
                </div>

                {{-- รายละเอียด --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        รายละเอียดสินค้า
                    </label>
                    <textarea name="description"
                              rows="3"
                              class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- ราคา --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        ราคา (บาท)
                    </label>
                    <input type="number"
                           name="price"
                           value="{{ old('price', $product->price) }}"
                           step="0.01"
                           min="0"
                           class="w-full border rounded p-2"
                           required>
                </div>

                {{-- สถานะ --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        สถานะสินค้า
                    </label>
                    <select name="is_active"
                            class="w-full border rounded p-2">
                        <option value="1" @selected($product->is_active)>
                            เปิดใช้งาน
                        </option>
                        <option value="0" @selected(!$product->is_active)>
                            ปิดการแสดงผล
                        </option>
                    </select>
                </div>

                {{-- รูปสินค้า --}}
                <div>
                    <label class="block text-sm font-medium mb-1">
                        รูปสินค้า
                    </label>

                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="w-24 h-24 object-cover rounded mb-2 border">
                    @endif

                    <input type="file"
                           name="image"
                           accept="image/*"
                           class="block w-full text-sm text-gray-600">
                </div>

                {{-- ปุ่ม --}}
                <div class="flex justify-end gap-2 pt-4">
                    <a href="{{ route('admin.products.index') }}"
                       class="px-4 py-2 border rounded text-gray-700">
                        ยกเลิก
                    </a>

                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        💾 อัปเดตสินค้า
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
