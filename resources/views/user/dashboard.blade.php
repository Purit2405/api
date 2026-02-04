<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                👤 ยินดีต้อนรับ {{ $user->name }}
            </h2>
            <div class="bg-indigo-600 text-white px-5 py-2 rounded-xl shadow">
                ⭐ แต้มของคุณ: {{ number_format($wallet->balance) }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 space-y-10">

        {{-- =======================
        | Banner
        ======================= --}}
        @if($banners->count())
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($banners as $banner)
                    <div class="rounded-2xl overflow-hidden shadow">
                        <img
                            src="{{ asset('storage/'.$banner->image) }}"
                            class="w-full h-48 object-cover"
                        >
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- =======================
        | Categories
        ======================= --}}
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-xl font-bold mb-4">📂 หมวดหมู่</h3>

            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @foreach($categories as $cat)
                    <div class="bg-white rounded-xl shadow p-4 text-center hover:shadow-lg transition">
                        <div class="font-semibold">{{ $cat->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- =======================
        | Promotions
        ======================= --}}
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-xl font-bold mb-4">🎁 โปรโมชั่น</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($promotions as $promo)
                    <div class="bg-white rounded-2xl shadow overflow-hidden">
                        @if($promo->image)
                            <img src="{{ asset('storage/'.$promo->image) }}"
                                 class="w-full h-40 object-cover">
                        @endif
                        <div class="p-4">
                            <h4 class="font-bold text-lg">{{ $promo->title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">
                                ใช้ {{ number_format($promo->points_required) }} แต้ม
                            </p>

                            <button
                                class="mt-4 w-full bg-indigo-600 text-white py-2 rounded-lg opacity-50 cursor-not-allowed">
                                ใช้แต้ม (กำลังพัฒนา)
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- =======================
        | Products
        ======================= --}}
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-xl font-bold mb-4">🛒 สินค้าแลกแต้ม</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="w-full h-40 object-cover">
                        @endif

                        <div class="p-4">
                            <h4 class="font-semibold">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-500">
                                {{ number_format($product->points_required) }} แต้ม
                            </p>

                            <button
                                class="mt-3 w-full bg-gray-300 text-gray-600 py-2 rounded-lg text-sm cursor-not-allowed">
                                แลกสินค้า
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- =======================
        | News
        ======================= --}}
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-xl font-bold mb-4">📰 ข่าวสาร</h3>

            <div class="space-y-4">
                @foreach($news as $item)
                    <div class="bg-white rounded-xl shadow p-4 flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $item->title }}</div>
                            <div class="text-xs text-gray-500">
                                {{ $item->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        <span class="text-indigo-600 text-sm">อ่าน</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- =======================
        | Point History (เฉพาะของตัวเอง)
        ======================= --}}
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-xl font-bold mb-4">⭐ ประวัติแต้มของคุณ</h3>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">รายการ</th>
                            <th class="p-3 text-center">แต้ม</th>
                            <th class="p-3 text-center">วันที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $t->description }}
                                </td>
                                <td class="p-3 text-center font-semibold
                                    {{ $t->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $t->points > 0 ? '+' : '' }}{{ $t->points }}
                                </td>
                                <td class="p-3 text-center text-gray-500">
                                    {{ $t->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-6 text-center text-gray-500">
                                    ยังไม่มีประวัติแต้ม
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
