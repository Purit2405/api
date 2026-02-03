<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">จัดการสินค้า</h2>
</x-slot>

<div class="p-6 max-w-7xl mx-auto">

    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">รายการสินค้า</h3>

        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + เพิ่มสินค้า
        </a>
    </div>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">รูป</th>
                <th>ชื่อ</th>
                <th>หมวด</th>
                <th>ราคา</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>

        <tbody>
        @foreach($products as $product)
            <tr class="border-t">
                <td class="p-2">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="w-16 h-16 object-cover rounded">
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>
                    {{ $product->category->name }}
                    @if(!$product->category->is_active)
                        <span class="text-xs text-red-600">(หมวดปิด)</span>
                    @endif
                </td>
                <td>{{ number_format($product->price,2) }}</td>
                <td>
                    <span class="px-2 py-1 text-xs rounded text-white
                        {{ $product->is_active ? 'bg-green-600' : 'bg-gray-500' }}">
                        {{ $product->is_active ? 'เปิด' : 'ปิด' }}
                    </span>
                </td>
                <td class="space-x-2">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="text-blue-600">แก้ไข</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
</x-app-layout>
