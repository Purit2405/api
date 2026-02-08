<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">
                    🖼️ จัดการ Banner
                </h2>
                <p class="text-sm text-gray-500">
                    จัดการรูปแบนเนอร์หน้าแรก และลำดับการแสดง
                </p>
            </div>

            <a href="{{ route('admin.banners.create') }}"
               class="inline-flex items-center gap-2
                      bg-gradient-to-r from-indigo-500 to-purple-600
                      text-white px-5 py-2.5 rounded-xl
                      shadow-lg hover:shadow-xl
                      hover:from-indigo-600 hover:to-purple-700
                      transition">
                ➕ เพิ่ม Banner
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow rounded-2xl p-6 border">
                <h3 class="text-lg font-semibold text-gray-700">
                    📸 รายการ Banner
                </h3>
                <p class="text-sm text-gray-500">
                    ควบคุมการแสดงผลและลำดับของแบนเนอร์
                </p>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-x-auto border">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 border">ลำดับ</th>
                            <th class="p-3 border">รูป</th>
                            <th class="p-3 border text-left">หัวข้อ</th>
                            <th class="p-3 border">สถานะ</th>
                            <th class="p-3 border">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($banners as $banner)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="p-3 border text-center font-semibold">
                                {{ $banner->sort_order }}
                            </td>

                            <td class="p-3 border text-center">
                                <img src="{{ asset('storage/'.$banner->image) }}"
                                     class="w-40 h-20 object-cover mx-auto rounded-xl shadow">
                            </td>

                            <td class="p-3 border font-medium text-gray-800">
                                {{ $banner->title }}
                            </td>

                            <td class="p-3 border text-center">
                                @if($banner->is_active)
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        เปิดใช้งาน
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                        ปิดใช้งาน
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 border text-center space-y-2">
                                <form method="POST"
                                      action="{{ route('admin.banners.toggle', $banner) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="w-full px-3 py-1.5 text-xs rounded-lg
                                            {{ $banner->is_active
                                                ? 'bg-red-500 hover:bg-red-600'
                                                : 'bg-green-500 hover:bg-green-600' }}
                                            text-white transition shadow">
                                        {{ $banner->is_active ? '⛔ ปิดใช้งาน' : '✅ เปิดใช้งาน' }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.banners.edit', $banner) }}"
                                   class="block w-full px-3 py-1.5 text-xs rounded-lg
                                          bg-indigo-500 text-white hover:bg-indigo-600
                                          transition shadow">
                                    ✏️ แก้ไข
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">
                                ยังไม่มี Banner ในระบบ
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
