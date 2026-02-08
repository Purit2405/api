<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold flex items-center gap-2">
                ✏️ แก้ไขข่าว
            </h2>

            <a href="{{ route('admin.news.index') }}"
               class="text-sm text-gray-600 hover:text-indigo-600">
                ← กลับไปหน้ารายการข่าว
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">

        <form method="POST"
              action="{{ route('admin.news.update', $news) }}"
              enctype="multipart/form-data"
              class="bg-white shadow rounded-xl p-6 space-y-6">

            @csrf
            @method('PUT')

            {{-- หัวข้อข่าว --}}
            <div>
                <label class="block font-medium mb-1">
                    หัวข้อข่าว <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $news->title) }}"
                    required
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                >
            </div>

            {{-- รายละเอียดข่าว --}}
            <div>
                <label class="block font-medium mb-1">
                    รายละเอียดข่าว
                </label>
                <textarea
                    name="content"
                    rows="5"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                >{{ old('content', $news->content) }}</textarea>
            </div>

            {{-- รูปข่าว --}}
            <div>
                <label class="block font-medium mb-1">
                    รูปภาพข่าว
                </label>

                @if ($news->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$news->image) }}"
                             class="w-48 h-32 object-cover rounded-lg shadow">
                    </div>
                @endif

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
                    ถ้าไม่เลือกไฟล์ใหม่ ระบบจะใช้รูปเดิม
                </p>
            </div>

            {{-- สถานะ --}}
            <div class="space-y-3">
                <input type="hidden" name="is_active" value="0">
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $news->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600">
                    <span>เปิดใช้งานข่าว</span>
                </label>
            </div>

            {{-- วันที่ --}}
            <div class="text-sm text-gray-500">
                📅 วันที่สร้าง:
                <span class="font-medium">
                    {{ $news->created_at->format('d/m/Y H:i') }}
                </span>
            </div>

            {{-- ปุ่ม --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.news.index') }}"
                   class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    ยกเลิก
                </a>

                <button
                    type="submit"
                    class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow">
                    💾 อัปเดตข่าว
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
