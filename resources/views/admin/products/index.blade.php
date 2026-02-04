<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">สินค้า</h2>
</x-slot>

<div class="p-6 max-w-7xl mx-auto">

<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full border text-sm">
<thead class="bg-gray-100">
<tr>
    <th class="p-2 border">รูป</th>
    <th class="p-2 border">ชื่อสินค้า</th>
    <th class="p-2 border">ราคา</th>
    <th class="p-2 border">แลกแต้ม</th>
    <th class="p-2 border">สถานะสินค้า</th>
    <th class="p-2 border">จัดการ</th>
</tr>
</thead>
<tbody>

@foreach($products as $p)
<tr class="hover:bg-gray-50">

    {{-- รูป --}}
    <td class="p-2 border text-center">
        @if($p->image)
            <img src="{{ asset('storage/'.$p->image) }}"
                 class="w-16 h-16 object-cover mx-auto rounded">
        @else
            <span class="text-gray-400">ไม่มีรูป</span>
        @endif
    </td>

    {{-- ชื่อ --}}
    <td class="p-2 border font-medium">
        {{ $p->name }}
    </td>

    {{-- ราคา --}}
    <td class="p-2 border">
        {{ number_format($p->price,2) }} บาท
    </td>

    {{-- แลกแต้ม --}}
    <td class="p-2 border text-center">
        @if($p->redeemable)
            <span class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-700">
                แลกได้
            </span>
        @else
            <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-600">
                แลกไม่ได้
            </span>
        @endif
    </td>

    {{-- สถานะสินค้า --}}
    <td class="p-2 border text-center">
        @if($p->is_active)
            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                เปิดใช้งาน
            </span>
        @else
            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                ปิดการใช้งาน
            </span>
        @endif
    </td>

    {{-- จัดการ --}}
    <td class="p-2 border space-x-2 text-center">

        {{-- เปิด / ปิดสินค้า --}}
        <form method="POST"
              action="{{ route('admin.products.toggle',$p) }}"
              class="inline">
            @csrf @method('PATCH')
            <button
                class="px-3 py-1 text-xs rounded
                {{ $p->is_active
                    ? 'bg-red-500 text-white hover:bg-red-600'
                    : 'bg-green-500 text-white hover:bg-green-600' }}">
                {{ $p->is_active ? 'ปิดสินค้า' : 'เปิดสินค้า' }}
            </button>
        </form>

        {{-- เปิด / ปิดแลกแต้ม --}}
        <form method="POST"
              action="{{ route('admin.products.toggleRedeem',$p) }}"
              class="inline">
            @csrf @method('PATCH')
            <button
                class="px-3 py-1 text-xs rounded
                {{ $p->redeemable
                    ? 'bg-gray-500 text-white hover:bg-gray-600'
                    : 'bg-indigo-500 text-white hover:bg-indigo-600' }}">
                {{ $p->redeemable ? 'ปิดแลกแต้ม' : 'เปิดแลกแต้ม' }}
            </button>
        </form>

    </td>
</tr>
@endforeach

</tbody>
</table>
</div>
</div>
</x-app-layout>
