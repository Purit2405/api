<x-app-layout>
<x-slot name="header">
    <h2 class="font-bold text-xl">
        เพิ่มโปรโมชั่น
    </h2>
</x-slot>

<div class="p-6 max-w-3xl mx-auto bg-white rounded shadow">

<form method="POST"
      action="{{ route('admin.promotions.store') }}"
      enctype="multipart/form-data">

@csrf

{{-- ชื่อ --}}
<input name="title"
       class="w-full border p-2 mb-3"
       placeholder="ชื่อโปรโมชั่น"
       required>

{{-- รายละเอียด --}}
<textarea name="description"
          class="w-full border p-2 mb-3"
          placeholder="รายละเอียด"></textarea>

{{-- แต้ม + ประเภท --}}
<div class="grid grid-cols-2 gap-3 mb-3">
    <input type="number"
           name="points_value"
           placeholder="จำนวนแต้ม"
           class="border p-2"
           required>

    <select name="type" class="border p-2">
        <option value="reward">🎉 ให้แต้ม</option>
        <option value="redeem">🎁 ใช้แต้ม</option>
    </select>
</div>

<hr class="my-4">

<h3 class="font-bold mb-2">จำกัดสิทธิ์การแลก</h3>

<div class="grid grid-cols-2 gap-3">
    <input type="number"
           name="max_per_user"
           placeholder="ต่อคน (ว่าง = ไม่จำกัด)"
           class="border p-2">

    <input type="number"
           name="max_total"
           placeholder="ทั้งระบบ (ว่าง = ไม่จำกัด)"
           class="border p-2">
</div>

{{-- สถานะ --}}
<div class="mt-4">
    <label class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" checked>
        <span>เปิดใช้งาน</span>
    </label>
</div>

{{-- รูป --}}
<div class="mt-4">
    <input type="file" name="image">
</div>

<button class="mt-6 bg-indigo-600 text-white px-6 py-2 rounded">
    บันทึก
</button>

</form>
</div>
</x-app-layout>
