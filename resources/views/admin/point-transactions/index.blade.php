<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold flex items-center gap-2">
                ⭐ ประวัติแต้มทั้งหมด
            </h2>

            {{-- ปุ่มเพิ่มแต้ม --}}
            <a href="{{ route('admin.point-transactions.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm shadow transition">
                ➕ เพิ่มแต้ม
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        <div class="bg-white shadow rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">ผู้ใช้</th>
                        <th class="p-3 text-center">ประเภท</th>
                        <th class="p-3 text-left">รายการ</th>
                        <th class="p-3 text-center">แต้ม</th>
                        <th class="p-3 text-center">วันที่</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transactions as $t)
                        <tr class="border-t hover:bg-gray-50">

                            {{-- ผู้ใช้ --}}
                            <td class="p-3">
                                <div class="font-medium">
                                    {{ $t->user->name ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    ID: {{ $t->user_id }}
                                </div>
                            </td>

                            {{-- ประเภท --}}
                            <td class="p-3 text-center">
                                <span class="px-2 py-1 rounded text-white text-xs
                                    {{ $t->points > 0 ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $t->points > 0 ? 'ได้รับ' : 'ใช้' }}
                                </span>
                            </td>

                            {{-- รายการ --}}
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    @if ($t->source && isset($t->source->image))
                                        <img
                                            src="{{ asset('storage/'.$t->source->image) }}"
                                            class="w-10 h-10 rounded object-cover"
                                        >
                                    @else
                                        <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                            N/A
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-medium">
                                            {{ $t->description }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ ucfirst($t->source_type) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- แต้ม --}}
                            <td class="p-3 text-center font-semibold
                                {{ $t->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $t->points > 0 ? '+' : '' }}{{ $t->points }}
                            </td>

                            {{-- วันที่ --}}
                            <td class="p-3 text-center text-gray-600">
                                {{ $t->created_at->format('d/m/Y H:i') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                ยังไม่มีประวัติการทำรายการ
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>

    </div>
</x-app-layout>
