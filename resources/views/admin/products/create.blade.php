<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">เพิ่มสินค้า</h2>
</x-slot>

<div class="p-6 max-w-4xl mx-auto">
<form method="POST"
      action="{{ route('admin.products.store') }}"
      enctype="multipart/form-data"
      class="space-y-4 bg-white p-6 rounded shadow">

@csrf

<div>
    <label>หมวดหมู่</label>
    <select name="category_id" class="w-full border rounded p-2">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <label>ชื่อสินค้า</label>
    <input name="name" class="w-full border rounded p-2" required>
</div>

<div>
    <label>รายละเอียด</label>
    <textarea name="description" class="w-full border rounded p-2"></textarea>
</div>

<div>
    <label>ราคา (บาท)</label>
    <input type="number" step="0.01"
           name="price"
           class="w-full border rounded p-2" required>
</div>

<div>
    <label>แต้มที่ใช้แลก</label>
    <input type="number"
           name="points_required"
           class="w-full border rounded p-2">
</div>

<div class="flex items-center gap-2">
    <input type="checkbox" name="redeemable" value="1">
    <label>เปิดให้แลกด้วยแต้ม</label>
</div>

<div class="flex items-center gap-2">
    <input type="checkbox" name="is_active" value="1" checked>
    <label>เปิดการใช้งานสินค้า (แสดงในหน้าผู้ใช้)</label>
</div>

<div>
    <label>รูปสินค้า</label>
    <input type="file" name="image">
</div>

<button class="bg-indigo-600 text-white px-4 py-2 rounded">
    บันทึก
</button>

</form>
</div>
</x-app-layout>
