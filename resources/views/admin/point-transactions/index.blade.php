<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
                    ⭐ ประวัติแต้มทั้งหมด
                </h2>
                <p class="text-sm text-gray-500">
                    ตรวจสอบการได้รับและการใช้แต้มของผู้ใช้ทั้งหมด
                </p>
            </div>

            {{-- ปุ่มเพิ่มแต้ม --}}
            <a href="{{ route('admin.point-transactions.create') }}"
               class="inline-flex items-center gap-2
                      bg-gradient-to-r from-indigo-500 to-purple-600
                      text-white px-5 py-2.5 rounded-xl
                      shadow-lg hover:shadow-xl
                      hover:from-indigo-600 hover:to-purple-700
                      transition">
                ➕ เพิ่มแต้ม
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- กล่องหัว --}}
            <div class="bg-white shadow rounded-2xl p-6 border">
                <h3 class="text-lg font-semibold text-gray-700">
                    📊 รายการเคลื่อนไหวแต้ม
                </h3>
                <p class="text-sm text-gray-500">
                    แสดงประวัติการเพิ่มและการใช้แต้มทั้งหมด
                </p>
            </div>

            {{-- ตาราง --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-x-auto border">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 border text-left">ผู้ใช้</th>
                            <th class="p-3 border text-center">ประเภท</th>
                            <th class="p-3 border text-left">รายการ</th>
                            <th class="p-3 border text-center">แต้ม</th>
                            <th class="p-3 border text-center">วันที่</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($transactions as $t)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- ผู้ใช้ --}}
                            <td class="p-3 border">
                                <div class="font-medium text-gray-800">
                                    {{ $t->user->name ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    ID: {{ $t->user_id }}
                                </div>
                            </td>

                            {{-- ประเภท --}}
                            <td class="p-3 border text-center">
                                <span class="px-3 py-1 text-xs rounded-full text-white
                                    {{ $t->points > 0 ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $t->points > 0 ? 'ได้รับแต้ม' : 'ใช้แต้ม' }}
                                </span>
                            </td>

                            {{-- รายการ --}}
                            <td class="p-3 border">
                                <div class="flex items-center gap-3">
                                    @if ($t->source && isset($t->source->image))
                                        <img
                                            src="{{ asset('storage/'.$t->source->image) }}"
                                            class="w-12 h-12 rounded-xl object-cover shadow"
                                        >
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-gray-200
                                                    flex items-center justify-center
                                                    text-xs text-gray-500">
                                            N/A
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-medium text-gray-800">
                                            {{ $t->description }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ ucfirst($t->source_type) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- แต้ม --}}
                            <td class="p-3 border text-center font-semibold
                                {{ $t->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $t->points > 0 ? '+' : '' }}{{ $t->points }}
                            </td>

                            {{-- วันที่ --}}
                            <td class="p-3 border text-center text-gray-600">
                                {{ $t->created_at->format('d/m/Y H:i') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="p-6 text-center text-gray-400">
                                ยังไม่มีประวัติการทำรายการ
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div>
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
