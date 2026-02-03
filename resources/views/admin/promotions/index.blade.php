<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                🎁 จัดการโปรโมชั่น
            </h2>

            <a href="{{ route('admin.promotions.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">
                + เพิ่มโปรโมชั่น
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left">ชื่อ</th>
                            <th class="px-4 py-3">ประเภท</th>
                            <th class="px-4 py-3">แต้ม</th>
                            <th class="px-4 py-3">ผู้ใช้ใหม่</th>
                            <th class="px-4 py-3">สถานะ</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $promo)
                            <tr class="border-t">
                                <td class="px-4 py-3">
                                    {{ $promo->title }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if($promo->type === 'reward')
                                        <span class="text-green-600 font-medium">ได้แต้ม</span>
                                    @else
                                        <span class="text-red-600 font-medium">ใช้แต้ม</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $promo->points_value }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $promo->for_new_user ? '✔' : '-' }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if($promo->is_active)
                                        <span class="text-green-600">เปิด</span>
                                    @else
                                        <span class="text-gray-400">ปิด</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.promotions.edit', $promo) }}"
                                       class="text-indigo-600 hover:underline">
                                        แก้ไข
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    ยังไม่มีโปรโมชั่น
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
