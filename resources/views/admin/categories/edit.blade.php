<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            แก้ไขหมวดหมู่สินค้า
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">

                <form method="POST"
                      action="{{ route('admin.categories.update', $category) }}"
                      enctype="multipart/form-data"
                      class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- ชื่อ --}}
                    <div>
                        <label class="block font-medium mb-1">ชื่อหมวดหมู่</label>
                        <input name="name"
                               value="{{ $category->name }}"
                               class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200"
                               required>
                    </div>

                    {{-- ไอคอน --}}
                    <div>
                        <label class="block font-medium mb-2">ไอคอนหมวดหมู่ (SVG)</label>

                        @if($category->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$category->image) }}"
                                     class="w-20 h-20 bg-gray-100 p-2 rounded-lg">
                            </div>
                        @endif

                        <input type="file"
                               name="image"
                               accept=".svg"
                               class="block w-full text-sm text-gray-600">
                        <p class="text-sm text-gray-400 mt-1">
                            อัปโหลดใหม่หากต้องการเปลี่ยน
                        </p>
                    </div>

                    {{-- สถานะ --}}
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                        <div>
                            <p class="font-medium">สถานะหมวดหมู่</p>
                            <p class="text-sm text-gray-500">เปิด / ปิดการแสดงผล</p>
                        </div>

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ $category->is_active ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-300 peer-focus:ring-2 peer-focus:ring-indigo-300
                                rounded-full peer peer-checked:bg-indigo-600
                                after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                after:bg-white after:border after:rounded-full after:h-5 after:w-5
                                after:transition-all peer-checked:after:translate-x-full">
                            </div>
                        </label>
                    </div>

                    {{-- ปุ่ม --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.categories.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded-lg">
                            กลับ
                        </a>
                        <button
                            class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            อัปเดต
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
