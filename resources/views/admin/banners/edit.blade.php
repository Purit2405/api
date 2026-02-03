<x-app-layout>
<x-slot name="header">
    <h2 class="font-bold text-xl">แก้ไข Banner</h2>
</x-slot>

<div class="p-6 max-w-xl mx-auto bg-white rounded shadow">
<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.banners.update',$banner) }}">
@csrf
@method('PUT')

<input name="title" class="w-full border p-2 mb-3"
       value="{{ $banner->title }}">

<input name="link" class="w-full border p-2 mb-3"
       value="{{ $banner->link }}">

<input type="number" name="sort_order"
       class="w-full border p-2 mb-3"
       value="{{ $banner->sort_order }}">

<img src="{{ asset('storage/'.$banner->image) }}"
     class="w-40 mb-3 rounded">

<input type="file" name="image" class="mb-3">

<label class="flex items-center gap-2 mb-4">
    <input type="checkbox" name="is_active" value="1"
        {{ $banner->is_active ? 'checked' : '' }}>
    เปิดใช้งาน
</label>

<button class="bg-indigo-600 text-white px-6 py-2 rounded">
    อัปเดต
</button>

</form>
</div>
</x-app-layout>
