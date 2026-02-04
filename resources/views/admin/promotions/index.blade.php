<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-bold text-xl">โปรโมชั่น</h2>
        <a href="{{ route('admin.promotions.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded">
            + เพิ่ม
        </a>
    </div>
</x-slot>

<div class="p-6">
<table class="w-full bg-white rounded shadow">
<tr class="border-b bg-gray-50">
    <th class="p-3">ชื่อ</th>
    <th>แต้ม</th>
    <th>จำกัด</th>
    <th>สถานะ</th>
    <th></th>
</tr>

@foreach($promotions as $p)
<tr class="border-b">
    <td class="p-3">{{ $p->title }}</td>
    <td>{{ $p->points_value }}</td>
    <td>
        {{ $p->max_per_user ?? '∞' }} / คน<br>
        {{ $p->max_total ?? '∞' }} คน
    </td>
    <td>
        {{ $p->is_active ? 'เปิด' : 'ปิด' }}
    </td>
    <td>
        <a href="{{ route('admin.promotions.edit',$p) }}"
           class="text-blue-600">แก้ไข</a>
    </td>
</tr>
@endforeach
</table>
</div>
</x-app-layout>
