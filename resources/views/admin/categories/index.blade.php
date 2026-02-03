<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            หมวดหมู่สินค้า
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.categories.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded">
                    + เพิ่มหมวดหมู่
                </a>
            </div>

            <div class="bg-white shadow rounded p-6">
                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 border">รูป</th>
                            <th class="p-3 border">ชื่อ</th>
                            <th class="p-3 border">สถานะ</th>
                            <th class="p-3 border">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td class="p-3 border">
                                    @if($cat->image)
                                        <img src="{{ asset('storage/'.$cat->image) }}"
                                             class="w-16 h-16 object-cover rounded">
                                    @endif
                                </td>
                                <td class="p-3 border">{{ $cat->name }}</td>
                                <td class="p-3 border">
                                    {{ $cat->is_active ? 'เปิด' : 'ปิด' }}
                                </td>
                                <td class="p-3 border space-x-2">
                                    <a href="{{ route('admin.categories.edit', $cat) }}"
                                       class="text-blue-600">แก้ไข</a>

                                    <form method="POST"
                                          action="{{ route('admin.categories.toggle', $cat) }}"
                                          class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-red-600">
                                            {{ $cat->is_active ? 'ปิด' : 'เปิด' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
