<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">ข่าวสาร</h2>
</x-slot>

<div class="p-6 max-w-5xl mx-auto">
<a href="{{ route('admin.news.create') }}"
   class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">
    + เพิ่มข่าว
</a>

<table class="w-full border">
<thead class="bg-gray-100">
<tr>
    <th class="p-2">รูป</th>
    <th>หัวข้อ</th>
    <th>วันที่</th>
    <th>สถานะ</th>
    <th></th>
</tr>
</thead>
<tbody>
@foreach($news as $item)
<tr class="border-t">
    <td class="p-2">
        @if($item->image)
            <img src="{{ asset('storage/'.$item->image) }}" class="w-16">
        @endif
    </td>
    <td>{{ $item->title }}</td>
    <td>{{ $item->publish_date?->format('d/m/Y') }}</td>
    <td>{{ $item->is_active ? 'เปิด' : 'ปิด' }}</td>
    <td>
        <a href="{{ route('admin.news.edit',$item) }}"
           class="text-blue-600">แก้ไข</a>
    </td>
</tr>
@endforeach
</tbody>
</table>

{{ $news->links() }}
</div>
</x-app-layout>
