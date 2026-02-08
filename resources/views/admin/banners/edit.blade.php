<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            ✏️ แก้ไข Banner
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl p-8 border">
                <form method="POST"
                      action="{{ route('admin.banners.update', $banner) }}"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- หัวข้อ --}}
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">
                            หัวข้อ Banner
                        </label>
                        <input type="text" name="title"
                               value="{{ old('title', $banner->title) }}"
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                               required>
                    </div>

                    {{-- รูปปัจจุบัน --}}
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">
                            รูปปัจจุบัน
                        </label>
                        <img src="{{ asset('storage/'.$banner->image) }}"
                             class="w-full max-h-60 object-cover rounded-xl shadow">
                    </div>

                    {{-- อัปโหลดรูปใหม่ --}}
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">
                            เปลี่ยนรูป (ไม่จำเป็น)
                        </label>
                        <input type="file" name="image"
                               class="w-full rounded-xl border-gray-300">
                    </div>

                    {{-- ลิงก์ --}}
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">
                            ลิงก์ (ถ้ามี)
                        </label>
                        <input type="text" name="link"
                               value="{{ old('link', $banner->link) }}"
                               class="w-full rounded-xl border-gray-300">
                    </div>

                    {{-- ลำดับ --}}
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">
                            ลำดับการแสดง
                        </label>
                        <input type="number" name="sort_order"
                               value="{{ old('sort_order', $banner->sort_order) }}"
                               class="w-full rounded-xl border-gray-300">
                    </div>

                    {{-- สถานะ --}}
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1"
                               {{ $banner->is_active ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600">
                        <span class="text-gray-700">เปิดใช้งาน Banner</span>
                    </div>

                    {{-- ปุ่ม --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.banners.index') }}"
                           class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 transition">
                            ยกเลิก
                        </a>

                        <button type="submit"
                                class="px-6 py-2 rounded-xl
                                       bg-indigo-600 text-white
                                       hover:bg-indigo-700 transition shadow">
                            💾 บันทึกการแก้ไข
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
