<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">แก้ไขสินค้า</h2>
</x-slot>

<div class="p-6 max-w-4xl mx-auto">
<form method="POST"
      action="{{ route('admin.products.update',$product) }}"
      enctype="multipart/form-data"
      class="space-y-4 bg-white p-6 rounded shadow">

@csrf
@method('PUT')

<div>
    <label>หมวดหมู่</label>
    <select name="category_id" class="w-full border rounded p-2">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                @selected($product->category_id == $cat->id)>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label>ชื่อสินค้า</label>
    <input name="name"
           value="{{ $product->name }}"
           class="w-full border rounded p-2">
</div>

<div>
    <label>รายละเอียด</label>
    <textarea name="description"
              class="w-full border rounded p-2">{{ $product->description }}</textarea>
</div>

<div>
    <label>ราคา (บาท)</label>
    <input type="number"
           step="0.01"
           name="price"
           value="{{ $product->price }}"
           class="w-full border rounded p-2">
</div>

<div>
    <label>แต้มที่ใช้แลก</label>
    <input type="number"
           name="points_required"
           value="{{ $product->points_required }}"
           class="w-full border rounded p-2">
</div>

<div class="flex items-center gap-2">
    <input type="checkbox" name="redeemable" value="1"
        @checked($product->redeemable)>
    <label>เปิดให้แลกด้วยแต้ม</label>
</div>

<div class="flex items-center gap-2">
    <input type="checkbox" name="is_active" value="1"
        @checked($product->is_active)>
    <label>เปิดการใช้งานสินค้า</label>
</div>

@if($product->image)
    <img src="{{ asset('storage/'.$product->image) }}" class="w-24">
@endif

<div>
    <input type="file" name="image">
</div>

<button class="bg-indigo-600 text-white px-4 py-2 rounded">
    อัปเดต
</button>

</form>
</div>
</x-app-layout>
