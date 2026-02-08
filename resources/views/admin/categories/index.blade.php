<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">
                    📂 จัดการหมวดหมู่สินค้า
                </h2>
                <p class="text-sm text-gray-500">
                    เพิ่ม แก้ไข และเปิด–ปิดหมวดหมู่
                </p>
            </div>

            {{-- ปุ่มเพิ่มหมวดหมู่ --}}
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center gap-2
                      bg-gradient-to-r from-indigo-500 to-purple-600
                      text-white px-5 py-2.5 rounded-xl
                      shadow-lg hover:shadow-xl
                      hover:from-indigo-600 hover:to-purple-700
                      transition">
                ➕ เพิ่มหมวดหมู่
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- แจ้งเตือน --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- กล่องหัว --}}
            <div class="bg-white shadow rounded-2xl p-6 border">
                <h3 class="text-lg font-semibold text-gray-700">
                    🗂 รายการหมวดหมู่
                </h3>
                <p class="text-sm text-gray-500">
                    ควบคุมการแสดงหมวดหมู่สินค้า
                </p>
            </div>

            {{-- ตาราง --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-x-auto border">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 border">รูป</th>
                            <th class="p-3 border text-left">ชื่อหมวดหมู่</th>
                            <th class="p-3 border">สถานะ</th>
                            <th class="p-3 border">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- รูป --}}
                            <td class="p-3 border text-center">
                                @if($cat->image)
                                    <img src="{{ asset('storage/'.$cat->image) }}"
                                         class="w-16 h-16 object-cover mx-auto rounded-xl shadow">
                                @else
                                    <span class="text-xs text-gray-400">
                                        ไม่มีรูป
                                    </span>
                                @endif
                            </td>

                            {{-- ชื่อ --}}
                            <td class="p-3 border font-medium text-gray-800">
                                {{ $cat->name }}
                            </td>

                            {{-- สถานะ --}}
                            <td class="p-3 border text-center">
                                @if($cat->is_active)
                                    <span class="px-3 py-1 text-xs rounded-full
                                                 bg-green-100 text-green-700">
                                        เปิดใช้งาน
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full
                                                 bg-red-100 text-red-700">
                                        ปิดใช้งาน
                                    </span>
                                @endif
                            </td>

                            {{-- จัดการ --}}
                            <td class="p-3 border text-center space-y-2">

                                {{-- แก้ไข --}}
                                <a href="{{ route('admin.categories.edit', $cat) }}"
                                   class="block w-full px-3 py-1.5 text-xs rounded-lg
                                          bg-blue-500 text-white hover:bg-blue-600
                                          transition shadow">
                                    ✏️ แก้ไข
                                </a>

                                {{-- เปิด / ปิด --}}
                                <form method="POST"
                                      action="{{ route('admin.categories.toggle', $cat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="w-full px-3 py-1.5 text-xs rounded-lg
                                        {{ $cat->is_active
                                            ? 'bg-red-500 text-white hover:bg-red-600'
                                            : 'bg-green-500 text-white hover:bg-green-600' }}
                                        transition shadow">
                                        {{ $cat->is_active ? 'ปิดหมวดหมู่' : 'เปิดหมวดหมู่' }}
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                class="p-6 text-center text-gray-400">
                                ยังไม่มีหมวดหมู่ในระบบ
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
