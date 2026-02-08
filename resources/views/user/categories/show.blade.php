<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">

            {{-- ซ้าย: ข้อมูลหมวดหมู่ --}}
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/'.$category->image) }}"
                     class="w-12 h-12 rounded-full object-cover">

                <div>
                    <h2 class="text-2xl font-bold">
                        {{ $category->name }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        สินค้าในหมวดหมู่นี้
                    </p>
                </div>
            </div>

            {{-- ขวา: ปุ่มย้อนกลับ --}}
            <a href="{{ route('user.dashboard') }}"
               class="inline-flex items-center gap-2
                      px-4 py-2 text-sm
                      rounded-xl border
                      text-gray-600 hover:text-indigo-600
                      hover:border-indigo-600
                      transition">
                ← กลับ
            </a>

        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-6">

        @if($products->count() === 0)
            <div class="text-center text-gray-500 py-10">
                😢 ยังไม่มีสินค้าในหมวดหมู่นี้
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="h-40 w-full object-cover">

                        <div class="p-4 space-y-2">
                            <h4 class="font-semibold text-gray-800">
                                {{ $product->name }}
                            </h4>

                            @if($product->description)
                                <p class="text-xs text-gray-500 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                            @endif

                            @if($product->price)
                                <p class="text-sm text-gray-600">
                                    💰 {{ number_format($product->price, 2) }} บาท
                                </p>
                            @endif

                            @if($product->points_required)
                                <p class="text-sm font-bold text-indigo-600">
                                    ⭐ {{ number_format($product->points_required) }} แต้ม
                                </p>
                            @endif

                            @if($product->redeemable)
                                <form method="POST"
                                      action="{{ route('user.redeem.product', $product->id) }}">
                                    @csrf
                                    <button
                                        class="w-full mt-2 bg-indigo-600 hover:bg-indigo-700
                                               text-white py-2 rounded-xl text-sm transition">
                                        แลกสินค้า
                                    </button>
                                </form>
                            @else
                                <div
                                    class="mt-2 text-center text-sm
                                           bg-gray-200 text-gray-500
                                           rounded-xl py-2">
                                    🚫 ยังไม่เปิดให้แลก
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
