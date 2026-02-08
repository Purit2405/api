<x-app-layout>
    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">👋 สวัสดี {{ $user->name }}</h2>
                <p class="text-sm text-gray-500">ยินดีต้อนรับกลับมา</p>
            </div>

            <div class="bg-indigo-600 text-white px-6 py-3 rounded-2xl shadow">
                ⭐ {{ number_format($wallet->balance) }} แต้ม
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-10 space-y-12">

        {{-- ================= BANNER SLIDER ================= --}}
<section
    x-data="{
        active: 0,
        total: {{ $banners->count() }},
        init() {
            setInterval(() => {
                this.active = (this.active + 1) % this.total
            }, 5000)
        }
    }"
    class="relative overflow-hidden rounded-2xl shadow-md">

    {{-- slides --}}
    <div
        class="flex transition-transform duration-700 ease-in-out"
        :style="`transform: translateX(-${active * 100}%)`">
        @foreach ($banners as $banner)
            <img
                src="{{ asset('storage/'.$banner->image) }}"
                class="w-full h-40 md:h-56 object-cover flex-shrink-0">
        @endforeach
    </div>

    {{-- left arrow --}}
    <button
        @click="active = active === 0 ? total - 1 : active - 1"
        class="absolute left-3 top-1/2 -translate-y-1/2
               bg-black/40 hover:bg-black/60
               text-white w-8 h-8 rounded-full
               flex items-center justify-center">
        ‹
    </button>

    {{-- right arrow --}}
    <button
        @click="active = (active + 1) % total"
        class="absolute right-3 top-1/2 -translate-y-1/2
               bg-black/40 hover:bg-black/60
               text-white w-8 h-8 rounded-full
               flex items-center justify-center">
        ›
    </button>

    {{-- dots --}}
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
        @foreach ($banners as $i => $banner)
            <button
                @click="active={{ $i }}"
                class="w-2 h-2 rounded-full transition"
                :class="active === {{ $i }} ? 'bg-white' : 'bg-white/50'">
            </button>
        @endforeach
    </div>
</section>


        {{-- ================= CATEGORIES (IMAGE ONLY) ================= --}}
  <section>
    <h3 class="text-xl font-bold mb-4">📂 หมวดหมู่</h3>

    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-4">
        @foreach ($categories as $category)
           <a href="{{ route('user.categories.show', $category) }}"

               class="flex flex-col items-center gap-2">

                <div
                    class="w-16 h-16 rounded-full overflow-hidden shadow
                           hover:scale-105 transition">
                    <img src="{{ asset('storage/'.$category->image) }}"
                         class="w-full h-full object-cover">
                </div>

                <span class="text-xs text-gray-600 text-center">
                    {{ $category->name }}
                </span>
            </a>
        @endforeach
    </div>
</section>
    

        {{-- ================= PROMOTIONS ================= --}}
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold">🎁 โปรโมชั่น</h3>
                <span class="text-sm text-gray-500">สิทธิพิเศษสำหรับคุณ</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($promotions as $promotion)
                    <div
                        class="bg-white rounded-2xl shadow-md
                            hover:shadow-xl transition overflow-hidden">

                        @if($promotion->image)
                            <img src="{{ asset('storage/'.$promotion->image) }}"
                                class="h-40 w-full object-cover">
                        @endif

                        <div class="p-6 space-y-4">
                            <h4 class="font-semibold text-lg leading-snug">
                                {{ $promotion->title }}
                            </h4>

                            <p class="text-sm text-gray-600 line-clamp-2">
                                {{ $promotion->description }}
                            </p>

                            <div
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                {{ $promotion->type === 'reward'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700' }}">
                                {{ $promotion->type === 'reward'
                                    ? 'รับ '.number_format($promotion->points_value).' แต้ม'
                                    : 'ใช้ '.number_format($promotion->points_value).' แต้ม' }}
                            </div>

                            <form method="POST"
                                action="{{ route('user.redeem.promotion', $promotion->id) }}">
                                @csrf
                                <button
                                    class="w-full mt-4
                                        bg-gradient-to-r from-indigo-500 to-purple-600
                                        hover:from-indigo-600 hover:to-purple-700
                                        text-white py-4
                                        rounded-2xl
                                        text-base font-semibold
                                        shadow-lg hover:shadow-xl
                                        transition active:scale-[0.97]">
                                    ใช้โปรโมชั่น
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        ยังไม่มีโปรโมชั่น
                    </div>
                @endforelse
            </div>
        </section>



        {{-- ================= NEWS ================= --}}
<section>
    <h3 class="text-xl font-bold mb-6">📰 ข่าวสาร</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse ($news as $item)
            <div
                class="flex gap-4 bg-white rounded-2xl shadow-md
                       hover:shadow-lg transition p-5">

                {{-- รูปข่าว --}}
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xl">
                            📰
                        </div>
                    @endif
                </div>

                {{-- เนื้อหา --}}
                <div class="flex flex-col justify-between">
                    <div>
                        <p class="font-semibold text-sm line-clamp-2">
                            {{ $item->title }}
                        </p>

                        @if(!empty($item->summary))
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                {{ $item->summary }}
                            </p>
                        @endif
                    </div>

                    <p class="text-xs text-gray-400 mt-2">
                        {{ $item->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-10">
                ยังไม่มีข่าวสาร
            </div>
        @endforelse
    </div>
</section>

        {{-- ================= PRODUCTS ================= --}}
        <section>
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-xl font-bold">🛒 สินค้า</h3>
        <span class="text-sm text-gray-500">แลกด้วยแต้มสะสม</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                {{-- รูปสินค้า --}}
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="h-40 w-full object-cover">

                <div class="p-4 space-y-2">

                    {{-- ชื่อสินค้า --}}
                    <h4 class="font-semibold text-gray-800 text-base">
                        {{ $product->name }}
                    </h4>

                    {{-- รายละเอียดสินค้า --}}
                    @if($product->description)
                        <p class="text-xs text-gray-500 line-clamp-2">
                            {{ $product->description }}
                        </p>
                    @endif

                    {{-- ราคาเงิน --}}
                    @if(!is_null($product->price))
                        <p class="text-sm text-gray-600">
                            💰 ราคา
                            <span class="font-semibold text-gray-800">
                                {{ number_format($product->price, 2) }}
                            </span>
                            บาท
                        </p>
                    @endif

                    {{-- ราคาแต้ม --}}
                    @if($product->points_required)
                        <p class="text-sm font-bold text-indigo-600">
                            ⭐ {{ number_format($product->points_required) }} แต้ม
                        </p>
                    @endif

                    {{-- ปุ่มแลก --}}
                    @if($product->redeemable && $product->is_active)
                        <form method="POST"
                              action="{{ route('user.redeem.product', $product->id) }}">
                            @csrf
                            <button
                                class="w-full mt-3 bg-indigo-600 hover:bg-indigo-700
                                       text-white py-2 rounded-xl text-sm">
                                แลกสินค้า
                            </button>
                        </form>
                    @else
                        <div
                            class="w-full mt-3 py-2 text-center text-sm
                                   bg-gray-200 text-gray-500 rounded-xl">
                            🚫 ยังไม่เปิดให้แลก
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
</section>




        {{-- ================= HISTORY ================= --}}
        <section>
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold">📜 ประวัติการใช้งาน</h3>
                <span class="text-sm text-gray-500">10 รายการล่าสุด</span>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="p-3 text-left">วันที่</th>
                            <th class="p-3 text-left">รายการ</th>
                            <th class="p-3 text-right">แต้ม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3">
                                    {{ $tx->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-3">{{ $tx->description }}</td>
                                <td class="p-3 text-right font-bold
                                    {{ $tx->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $tx->points > 0 ? '+' : '' }}{{ number_format($tx->points) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="p-6 text-center text-gray-500">
                                    ยังไม่มีประวัติ
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</x-app-layout>
