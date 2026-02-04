<x-app-layout>
<x-slot name="header">
    <h2 class="font-bold text-xl">จัดการ Banner</h2>
</x-slot>

<div class="p-6 max-w-6xl mx-auto">

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.banners.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded">
            + เพิ่ม Banner
        </a>
    </div>

    <div class="bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">ลำดับ</th>
                    <th class="p-3">รูป</th>
                    <th class="p-3">ชื่อ</th>
                    <th class="p-3">สถานะ</th>
                    <th class="p-3 text-right">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $banner)
                <tr class="border-t">
                    <td class="p-3">{{ $banner->sort_order }}</td>
                    <td class="p-3">
                        <img src="{{ asset('storage/'.$banner->image) }}"
                             class="w-32 rounded">
                    </td>
                    <td class="p-3">{{ $banner->title }}</td>
                    <td class="p-3">
                        {{ $banner->is_active ? 'เปิด' : 'ปิด' }}
                    </td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.banners.edit',$banner) }}"
                           class="text-indigo-600">
                            แก้ไข
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>
