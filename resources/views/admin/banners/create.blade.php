<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            เพิ่ม Banner
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-6 space-y-8">

                {{-- =========================
                 |  VALIDATION ERROR
                 ========================= --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.banners.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf

                    {{-- =========================
                     |  SECTION: ข้อมูลพื้นฐาน
                     ========================= --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold border-b pb-2">
                            ข้อมูล Banner
                        </h3>

                        {{-- ชื่อ --}}
                        <div>
                            <label class="block font-medium mb-1">
                                ชื่อ Banner
                            </label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                                placeholder="ชื่อแบนเนอร์ (ไม่บังคับ)">
                        </div>

                        {{-- ลิงก์ --}}
                        <div>
                            <label class="block font-medium mb-1">
                                ลิงก์ (เมื่อกด Banner)
                            </label>
                            <input
                                type="url"
                                name="link"
                                value="{{ old('link') }}"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                                placeholder="https://example.com">
                        </div>
                    </div>

                    {{-- =========================
                     |  SECTION: การแสดงผล
                     ========================= --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold border-b pb-2">
                            การแสดงผล
                        </h3>

                        {{-- ลำดับ --}}
                        <div>
                            <label class="block font-medium mb-1">
                                ลำดับการแสดง
                            </label>
                            <input
                                type="number"
                                name="sort_order"
                                value="{{ old('sort_order', 1) }}"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                                placeholder="เช่น 1 (เลขน้อยแสดงก่อน)">
                        </div>

                        {{-- สถานะ --}}
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="font-medium">สถานะ Banner</p>
                                <p class="text-sm text-gray-500">
                                    เปิดเพื่อแสดงบนแอปมือถือ
                                </p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    class="sr-only peer"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-300 rounded-full peer
                                    peer-checked:bg-indigo-600
                                    after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                    after:bg-white after:rounded-full after:h-5 after:w-5
                                    after:transition-all peer-checked:after:translate-x-full">
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- =========================
                     |  SECTION: รูปภาพ
                     ========================= --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold border-b pb-2">
                            รูป Banner
                        </h3>

                        <div>
                            <label class="block font-medium mb-1">
                                รูปภาพ <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="file"
                                name="image"
                                required
                                class="block w-full text-sm text-gray-600">
                            <p class="text-xs text-gray-500 mt-1">
                                รองรับ jpg, png ขนาดไม่เกิน 2MB
                            </p>
                        </div>
                    </div>

                    {{-- =========================
                     |  ACTION BUTTONS
                     ========================= --}}
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('admin.banners.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                            ยกเลิก
                        </a>
                        <button
                            type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            บันทึก Banner
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
