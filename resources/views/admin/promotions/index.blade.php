<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">
                    🎉 จัดการโปรโมชั่น
                </h2>
                <p class="text-sm text-gray-500">
                    เพิ่ม แก้ไข เปิด–ปิด และกำหนดการให้/แลกแต้ม
                </p>
            </div>

            {{-- ปุ่มเพิ่มโปรโมชั่น --}}
            <a href="{{ route('admin.promotions.create') }}"
               class="inline-flex items-center gap-2
                      bg-gradient-to-r from-indigo-500 to-purple-600
                      text-white px-5 py-2.5 rounded-xl
                      shadow-lg hover:shadow-xl
                      hover:from-indigo-600 hover:to-purple-700
                      transition">
                ➕ เพิ่มโปรโมชั่น
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- กล่องหัว --}}
            <div class="bg-white shadow rounded-2xl p-6 border">
                <h3 class="text-lg font-semibold text-gray-700">
                    📋 รายการโปรโมชั่น
                </h3>
                <p class="text-sm text-gray-500">
                    ควบคุมการเปิดใช้งานและข้อจำกัดการแลกแต้ม
                </p>
            </div>

            {{-- ตาราง --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-x-auto border">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 border text-center">รูป</th>
                            <th class="p-3 border text-left">ชื่อโปรโมชั่น</th>
                            <th class="p-3 border">ประเภท</th>
                            <th class="p-3 border">แต้ม</th>
                            <th class="p-3 border">จำกัดสิทธิ์</th>
                            <th class="p-3 border">สถานะ</th>
                            <th class="p-3 border">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($promotions as $p)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- รูปโปรโมชั่น --}}
                            <td class="p-3 border text-center">
                                @if($p->image)
                                    <img
                                        src="{{ asset('storage/'.$p->image) }}"
                                        alt="{{ $p->title }}"
                                        class="w-16 h-16 object-cover rounded-xl mx-auto shadow"
                                    >
                                @else
                                    <div
                                        class="w-16 h-16 mx-auto
                                               flex items-center justify-center
                                               bg-gray-100 text-gray-400
                                               rounded-xl text-xs">
                                        ไม่มีรูป
                                    </div>
                                @endif
                            </td>

                            {{-- ชื่อ --}}
                            <td class="p-3 border font-medium text-gray-800">
                                {{ $p->title }}
                            </td>

                            {{-- ประเภท --}}
                            <td class="p-3 border text-center">
                                @if($p->type === 'redeem')
                                    <span class="px-3 py-1 text-xs rounded-full
                                                 bg-purple-100 text-purple-700">
                                        🎁 ใช้แต้ม
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full
                                                 bg-green-100 text-green-700">
                                        🎉 ให้แต้ม
                                    </span>
                                @endif
                            </td>

                            {{-- แต้ม --}}
                            <td class="p-3 border text-center font-semibold">
                                {{ $p->type === 'redeem' ? '-' : '+' }}
                                {{ $p->points_value }}
                            </td>

                            {{-- จำกัดสิทธิ์ --}}
                            <td class="p-3 border text-center text-xs">
                                👤 {{ $p->max_per_user ?? '∞' }} / คน <br>
                                🌍 {{ $p->max_total ?? '∞' }} คน
                            </td>

                            {{-- สถานะ --}}
                            <td class="p-3 border text-center">
                                @if($p->is_active)
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
                                <a href="{{ route('admin.promotions.edit', $p) }}"
                                   class="block w-full px-3 py-1.5 text-xs rounded-lg
                                          bg-blue-500 text-white hover:bg-blue-600
                                          transition shadow">
                                    ✏️ แก้ไข
                                </a>

                                {{-- เปิด / ปิด --}}
                                <form method="POST"
                                      action="{{ route('admin.promotions.toggle', $p) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="w-full px-3 py-1.5 text-xs rounded-lg
                                        {{ $p->is_active
                                            ? 'bg-red-500 text-white hover:bg-red-600'
                                            : 'bg-green-500 text-white hover:bg-green-600' }}
                                        transition shadow">
                                        {{ $p->is_active ? 'ปิดโปรโมชั่น' : 'เปิดโปรโมชั่น' }}
                                    </button>
                                </form>

                                {{-- ลบ --}}
                                <form method="POST"
                                      action="{{ route('admin.promotions.destroy', $p) }}"
                                      onsubmit="return confirm('ลบโปรโมชั่นนี้ ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="w-full px-3 py-1.5 text-xs rounded-lg
                                               bg-gray-500 text-white hover:bg-gray-600
                                               transition shadow">
                                        🗑 ลบ
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7"
                                class="p-6 text-center text-gray-400">
                                ยังไม่มีโปรโมชั่นในระบบ
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
