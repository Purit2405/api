@php use Illuminate\Support\Str; @endphp

<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">📰 ข่าวสาร</h2>

        <a href="{{ route('admin.news.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700
                  text-white px-4 py-2 rounded-lg text-sm shadow">
            ➕ เพิ่มข่าว
        </a>
    </div>
</x-slot>

<div class="p-6 max-w-7xl mx-auto">

<div class="bg-white shadow rounded-xl overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
    <th class="p-3 text-center w-16">#</th>
    <th class="p-3 text-center w-24">รูป</th>
    <th class="p-3 text-left">หัวข้อ</th>
    <th class="p-3 text-left">รายละเอียด</th>
    <th class="p-3 text-center w-32">วันที่</th>
    <th class="p-3 text-center w-28">สถานะ</th>
    <th class="p-3 text-center w-32">จัดการ</th>
</tr>
</thead>

<tbody>
@forelse ($news as $n)
<tr class="border-t hover:bg-gray-50 align-top">

    {{-- ลำดับ --}}
    <td class="p-3 text-center font-bold">
        {{ $loop->iteration + ($news->currentPage()-1)*$news->perPage() }}
    </td>

    {{-- รูป --}}
    <td class="p-3 text-center">
        @if ($n->image)
            <img src="{{ asset('storage/'.$n->image) }}"
                 class="w-16 h-16 object-cover rounded mx-auto">
        @else
            <div class="w-16 h-16 bg-gray-200 rounded mx-auto"></div>
        @endif
    </td>

    {{-- หัวข้อ --}}
    <td class="p-3 font-medium">
        {{ $n->title }}
    </td>

    {{-- รายละเอียด --}}
    <td class="p-3 text-gray-600 text-sm">
        {{ Str::limit(strip_tags($n->content), 80, '...') }}
    </td>

    {{-- วันที่ --}}
    <td class="p-3 text-center text-gray-600">
        {{ $n->created_at->format('d/m/Y') }}
    </td>

    {{-- สถานะ --}}
    <td class="p-3 text-center">
        @if ($n->is_active)
            <span class="px-3 py-1 text-xs rounded-full
                         bg-green-100 text-green-700 font-semibold">
                🟢 เปิดใช้งาน
            </span>
        @else
            <span class="px-3 py-1 text-xs rounded-full
                         bg-red-100 text-red-700 font-semibold">
                🔴 ปิดใช้งาน
            </span>
        @endif
    </td>

    {{-- จัดการ --}}
    <td class="p-3 text-center space-y-2">
        <a href="{{ route('admin.news.edit',$n) }}"
           class="block w-full px-3 py-1.5 text-xs rounded-lg
                  bg-blue-500 text-white hover:bg-blue-600 shadow">
            ✏️ แก้ไข
        </a>

        <form method="POST" action="{{ route('admin.news.toggle',$n) }}">
            @csrf @method('PATCH')
            <button
                class="w-full px-3 py-1.5 text-xs rounded-lg
                {{ $n->is_active
                    ? 'bg-red-500 hover:bg-red-600'
                    : 'bg-green-500 hover:bg-green-600' }}
                text-white shadow">
                {{ $n->is_active ? 'ปิดข่าว' : 'เปิดข่าว' }}
            </button>
        </form>

        <form method="POST"
              action="{{ route('admin.news.destroy',$n) }}"
              onsubmit="return confirm('ลบข่าวนี้ ?')">
            @csrf @method('DELETE')
            <button
                class="w-full px-3 py-1.5 text-xs rounded-lg
                       bg-gray-500 hover:bg-gray-600
                       text-white shadow">
                🗑 ลบ
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="p-6 text-center text-gray-500">
        ยังไม่มีข่าว
    </td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-6">
    {{ $news->links() }}
</div>

</div>
</x-app-layout>
