<x-app-layout>
<x-slot name="header">
    <h2 class="font-bold text-xl">เพิ่ม Banner</h2>
</x-slot>

<div class="p-6 max-w-xl mx-auto bg-white rounded shadow">
<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.banners.store') }}">
@csrf

<input name="title" class="w-full border p-2 mb-3" placeholder="ชื่อ">

<input name="link" class="w-full border p-2 mb-3" placeholder="ลิงก์">

<input type="number" name="sort_order"
       class="w-full border p-2 mb-3"
       placeholder="ลำดับ">

<input type="file" name="image" class="mb-3" required>

<label class="flex items-center gap-2 mb-4">
    <input type="checkbox" name="is_active" value="1" checked>
    เปิดใช้งาน
</label>

<button class="bg-indigo-600 text-white px-6 py-2 rounded">
    บันทึก
</button>

</form>
</div>
</x-app-layout>
