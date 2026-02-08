<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">
                    🛒 จัดการสินค้า
                </h2>
                <p class="text-sm text-gray-500">
                    เพิ่ม แก้ไข เปิด–ปิดสินค้า และการแลกแต้ม
                </p>
            </div>

            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center gap-2
                      bg-gradient-to-r from-indigo-500 to-purple-600
                      text-white px-5 py-2.5 rounded-xl
                      shadow-lg hover:shadow-xl transition">
                ➕ เพิ่มสินค้า
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 🔔 แจ้งเตือน --}}
            @if (session('success'))
                <div class="p-4 rounded-xl bg-green-100 text-green-700 shadow">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-red-100 text-red-700 shadow">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            {{-- กล่องหัว --}}
            <div class="bg-white shadow rounded-2xl p-6 border">
                <h3 class="text-lg font-semibold text-gray-700">
                    📦 รายการสินค้า
                </h3>
                <p class="text-sm text-gray-500">
                    ควบคุมการแสดงสินค้าและระบบแลกแต้ม
                </p>
            </div>

            {{-- ตาราง --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-x-auto border">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 border">รูป</th>
                            <th class="p-3 border text-left">ชื่อสินค้า</th>
                            <th class="p-3 border">ราคา</th>
                            <th class="p-3 border">แลกแต้ม</th>
                            <th class="p-3 border">สถานะ</th>
                            <th class="p-3 border">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($products as $p)

                        @php
                            // ❗ หมวดหมู่ปิด + สินค้าปิด → ห้ามเปิด
                            $categoryInactive = ! $p->is_active
                                && (! $p->category || ! $p->category->is_active);
                        @endphp

                        <tr class="hover:bg-gray-50 transition">

                            {{-- รูป --}}
                            <td class="p-3 border text-center">
                                @if($p->image)
                                    <img src="{{ asset('storage/'.$p->image) }}"
                                         class="w-16 h-16 object-cover mx-auto rounded-xl shadow">
                                @else
                                    <span class="text-gray-400 text-xs">ไม่มีรูป</span>
                                @endif
                            </td>

                            {{-- ชื่อ --}}
                            <td class="p-3 border font-medium text-gray-800">
                                {{ $p->name }}
                            </td>

                            {{-- ราคา --}}
                            <td class="p-3 border text-center">
                                {{ number_format($p->price, 2) }} บาท
                            </td>

                            {{-- แลกแต้ม --}}
                            <td class="p-3 border text-center">
                                @if($p->redeemable)
                                    <span class="px-3 py-1 text-xs rounded-full bg-purple-100 text-purple-700">
                                        ⭐ แลกได้
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-gray-200 text-gray-600">
                                        ❌ แลกไม่ได้
                                    </span>
                                @endif
                            </td>

                            {{-- สถานะ --}}
                            <td class="p-3 border text-center">
                                @if($p->is_active)
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        เปิดใช้งาน
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                        ปิดใช้งาน
                                    </span>
                                @endif
                            </td>

                            {{-- จัดการ --}}
                            <td class="p-3 border text-center space-y-2">

                                {{-- เปิด / ปิดสินค้า --}}
                                <form method="POST" action="{{ route('admin.products.toggle', $p) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        @disabled($categoryInactive)
                                        title="{{ $categoryInactive
                                            ? 'หมวดหมู่ของสินค้านี้ถูกปิดอยู่ ต้องเปิดหมวดหมู่ก่อน'
                                            : '' }}"
                                        class="w-full px-3 py-1.5 text-xs rounded-lg transition shadow
                                        @if($categoryInactive)
                                            bg-gray-300 text-gray-500 cursor-not-allowed
                                        @elseif($p->is_active)
                                            bg-red-500 text-white hover:bg-red-600
                                        @else
                                            bg-green-500 text-white hover:bg-green-600
                                        @endif">
                                        @if($categoryInactive)
                                            🚫 เปิดสินค้าไม่ได้
                                        @else
                                            {{ $p->is_active ? 'ปิดสินค้า' : 'เปิดสินค้า' }}
                                        @endif
                                    </button>
                                </form>

                                {{-- เปิด / ปิดแลกแต้ม --}}
                                <form method="POST" action="{{ route('admin.products.toggleRedeem', $p) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        @disabled($categoryInactive)
                                        title="{{ $categoryInactive
                                            ? 'ไม่สามารถเปิดแลกแต้มได้ เนื่องจากหมวดหมู่ถูกปิด'
                                            : '' }}"
                                        class="w-full px-3 py-1.5 text-xs rounded-lg transition shadow
                                        @if($categoryInactive)
                                            bg-gray-300 text-gray-500 cursor-not-allowed
                                        @elseif($p->redeemable)
                                            bg-gray-500 text-white hover:bg-gray-600
                                        @else
                                            bg-indigo-500 text-white hover:bg-indigo-600
                                        @endif">
                                        @if($categoryInactive)
                                            🚫 แลกแต้มไม่ได้
                                        @else
                                            {{ $p->redeemable ? 'ปิดแลกแต้ม' : 'เปิดแลกแต้ม' }}
                                        @endif
                                    </button>
                                </form>

                                @if($categoryInactive)
                                    <div class="text-[11px] text-red-500">
                                        หมวดหมู่ถูกปิดอยู่<br>
                                        ต้องเปิดหมวดหมู่ก่อน
                                    </div>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400">
                                ยังไม่มีสินค้าในระบบ
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
