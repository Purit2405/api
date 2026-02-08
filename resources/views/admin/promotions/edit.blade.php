<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold flex items-center gap-2">
                ✏️ แก้ไขโปรโมชั่น
            </h2>

            <a href="{{ route('admin.promotions.index') }}"
               class="text-sm text-gray-600 hover:text-indigo-600">
                ← กลับไปหน้ารายการโปรโมชั่น
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">

        <form method="POST"
              action="{{ route('admin.promotions.update', $promotion) }}"
              enctype="multipart/form-data"
              class="bg-white shadow rounded-xl p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- ชื่อโปรโมชั่น --}}
            <div>
                <label class="block font-medium mb-1">
                    ชื่อโปรโมชั่น <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="title"
                       value="{{ old('title', $promotion->title) }}"
                       required
                       class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">
            </div>

            {{-- รายละเอียด --}}
            <div>
                <label class="block font-medium mb-1">
                    รายละเอียด
                </label>
                <textarea name="description"
                          rows="4"
                          class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">{{ old('description', $promotion->description) }}</textarea>
            </div>

            {{-- ประเภท + แต้ม --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">
                        ประเภท <span class="text-red-500">*</span>
                    </label>
                    <select name="type"
                            required
                            class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">
                        <option value="reward"
                            @selected(old('type', $promotion->type) === 'reward')>
                            🎉 ให้แต้ม
                        </option>
                        <option value="redeem"
                            @selected(old('type', $promotion->type) === 'redeem')>
                            🎁 ใช้แต้ม
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">
                        จำนวนแต้ม <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="points_value"
                           min="1"
                           value="{{ old('points_value', $promotion->points_value) }}"
                           required
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">
                </div>
            </div>

            {{-- จำกัดสิทธิ์ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">
                        จำกัดต่อคน
                    </label>
                    <input type="number"
                           name="max_per_user"
                           value="{{ old('max_per_user', $promotion->max_per_user) }}"
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block font-medium mb-1">
                        จำกัดทั้งหมด
                    </label>
                    <input type="number"
                           name="max_total"
                           value="{{ old('max_total', $promotion->max_total) }}"
                           class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">
                </div>
            </div>

            {{-- รูปโปรโมชั่น --}}
            <div>
                <label class="block font-medium mb-1">
                    รูปโปรโมชั่น
                </label>

                @if($promotion->image)
                    <img src="{{ asset('storage/'.$promotion->image) }}"
                         class="h-28 rounded-lg mb-3 shadow">
                @endif

                <input type="file"
                       name="image"
                       accept="image/*"
                       class="block w-full text-sm text-gray-600
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-lg file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100">
            </div>

            {{-- สถานะ --}}
            <div class="space-y-3">
                <input type="hidden" name="is_active" value="0">
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           @checked(old('is_active', $promotion->is_active))
                           class="rounded border-gray-300 text-indigo-600">
                    <span>เปิดใช้งานโปรโมชั่น</span>
                </label>
            </div>

            {{-- ปุ่ม --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.promotions.index') }}"
                   class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    ยกเลิก
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow">
                    💾 อัปเดตโปรโมชั่น
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
