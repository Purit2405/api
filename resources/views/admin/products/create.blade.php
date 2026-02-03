<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">เพิ่มสินค้า</h2>
</x-slot>

<div class="p-6 max-w-4xl mx-auto">
<form method="POST"
      action="{{ route('admin.products.store') }}"
      enctype="multipart/form-data"
      class="space-y-4">

    @csrf

    <div>
        <label>หมวดหมู่</label>
        <select name="category_id" class="w-full border rounded">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>ชื่อสินค้า</label>
        <input name="name" class="w-full border rounded">
    </div>

    <div>
        <label>รายละเอียด</label>
        <textarea name="description"
                  class="w-full border rounded"></textarea>
    </div>

    <div>
        <label>ราคา</label>
        <input type="number" name="price"
               step="0.01"
               class="w-full border rounded">
    </div>

    <div>
        <label>รูปสินค้า</label>
        <input type="file" name="image">
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        บันทึก
    </button>

</form>
</div>
</x-app-layout>
