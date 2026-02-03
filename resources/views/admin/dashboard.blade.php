<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-bold text-2xl text-gray-800">
            Admin Dashboard
        </h2>
        <span class="text-sm text-gray-500">
            ระบบจัดการหลังบ้าน
        </span>
    </div>
</x-slot>

<div class="py-10" x-data="{ modalOpen: false, modalTitle: '', modalDesc: '' }">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

{{-- Welcome --}}
<div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-xl rounded-2xl p-6">
    <h3 class="text-2xl font-semibold mb-2">
        👑 ยินดีต้อนรับ Admin
    </h3>
    <p class="text-indigo-100">
        จัดการร้านค้า โปรโมชั่น แบนเนอร์ และข่าวสาร
    </p>
</div>

{{-- Menu --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

{{-- Categories --}}
<a href="{{ route('admin.categories.index') }}"
   class="bg-white shadow rounded-xl p-6 border hover:shadow-xl transition">
    <span class="text-3xl">📂</span>
    <h4 class="text-lg font-semibold mt-4">หมวดหมู่</h4>
    <p class="text-sm text-gray-500">จัดการหมวดหมู่สินค้า</p>
</a>

{{-- Products --}}
<a href="{{ route('admin.products.index') }}"
   class="bg-white shadow rounded-xl p-6 border hover:shadow-xl transition">
    <span class="text-3xl">🛒</span>
    <h4 class="text-lg font-semibold mt-4">สินค้า</h4>
    <p class="text-sm text-gray-500">สินค้า & การแลกแต้ม</p>
</a>

{{-- Promotions --}}
<a href="{{ route('admin.promotions.index') }}"
   class="bg-white shadow rounded-xl p-6 border hover:shadow-xl transition">
    <span class="text-3xl">🎁</span>
    <h4 class="text-lg font-semibold mt-4">โปรโมชั่น</h4>
    <p class="text-sm text-gray-500">สิทธิ์ & แคมเปญ</p>
</a>

{{-- Banners --}}
<a href="{{ route('admin.banners.index') }}"
   class="bg-white shadow rounded-xl p-6 border hover:shadow-xl transition">
    <span class="text-3xl">🖼️</span>
    <h4 class="text-lg font-semibold mt-4">แบนเนอร์</h4>
    <p class="text-sm text-gray-500">รูปหน้าหลัก</p>
</a>

{{-- News --}}
<a href="{{ route('admin.news.index') }}"
   class="bg-white shadow rounded-xl p-6 border hover:shadow-xl transition">
    <span class="text-3xl">📰</span>
    <h4 class="text-lg font-semibold mt-4">ข่าวสาร</h4>
    <p class="text-sm text-gray-500">ข่าว & ประกาศ</p>
</a>

{{-- Points --}}
<a href="{{ route('admin.point-transactions.index') }}"
   class="bg-white shadow rounded-xl p-6 border hover:shadow-xl transition">
    <span class="text-3xl">⭐</span>
    <h4 class="text-lg font-semibold mt-4">ระบบแต้ม</h4>
    <p class="text-sm text-gray-500">ประวัติแต้ม</p>
</a>

{{-- Staff --}}
<button
    @click="
        modalOpen = true;
        modalTitle = 'พนักงาน';
        modalDesc = 'จัดการบัญชี Staff และสิทธิ์การเข้าถึง';
    "
    class="bg-gray-100 shadow-inner rounded-xl p-6 border text-left hover:bg-gray-200 transition">
    <span class="text-3xl">👥</span>
    <h4 class="text-lg font-semibold mt-4 text-gray-700">พนักงาน</h4>
    <p class="text-sm text-gray-500">Roles & Permissions</p>
</button>

{{-- Reports --}}
<button
    @click="
        modalOpen = true;
        modalTitle = 'รายงาน';
        modalDesc = 'สถิติการใช้งาน ยอดแต้ม และการแลก';
    "
    class="bg-gray-100 shadow-inner rounded-xl p-6 border text-left hover:bg-gray-200 transition">
    <span class="text-3xl">📊</span>
    <h4 class="text-lg font-semibold mt-4 text-gray-700">รายงาน</h4>
    <p class="text-sm text-gray-500">Analytics</p>
</button>

</div>
</div>

{{-- Modal --}}
<div x-show="modalOpen"
     x-transition
     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-2" x-text="modalTitle"></h3>
        <p class="text-gray-600 mb-6" x-text="modalDesc"></p>

        <div class="text-right">
            <button
                @click="modalOpen = false"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                เข้าใจแล้ว
            </button>
        </div>
    </div>
</div>

</div>
</x-app-layout>
