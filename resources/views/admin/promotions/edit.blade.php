<x-app-layout>
<x-slot name="header">
    <h2 class="font-bold text-xl">
        แก้ไขโปรโมชั่น
    </h2>
</x-slot>

<div class="p-6 max-w-3xl mx-auto bg-white rounded shadow">

<form method="POST"
      action="{{ route('admin.promotions.update', $promotion) }}"
      enctype="multipart/form-data">

@csrf
@method('PUT')

{{-- ชื่อ --}}
<input name="title"
       class="w-full border p-2 mb-3"
       value="{{ $promotion->title }}"
       required>

{{-- รายละเอียด --}}
<textarea name="description"
          class="w-full border p-2 mb-3">{{ $promotion->description }}</textarea>

{{-- แต้ม + ประเภท --}}
<div class="grid grid-cols-2 gap-3 mb-3">
    <input type="number"
           name="points_value"
           class="border p-2"
           value="{{ $promotion->points_value }}"
           required>

    <select name="type" class="border p-2">
        <option value="reward" @selected($promotion->type=='reward')>
            🎉 ให้แต้ม
        </option>
        <option value="redeem" @selected($promotion->type=='redeem')>
            🎁 ใช้แต้ม
        </option>
    </select>
</div>

<hr class="my-4">

<h3 class="font-bold mb-2">จำกัดสิทธิ์การแลก</h3>

<div class="grid grid-cols-2 gap-3">
    <input type="number"
           name="max_per_user"
           class="border p-2"
           value="{{ $promotion->max_per_user }}"
           placeholder="ต่อคน">

    <input type="number"
           name="max_total"
           class="border p-2"
           value="{{ $promotion->max_total }}"
           placeholder="ทั้งระบบ">
</div>

{{-- สถานะ --}}
<div class="mt-4">
    <label class="flex items-center gap-2">
        <input type="checkbox"
               name="is_active"
               value="1"
               {{ $promotion->is_active ? 'checked' : '' }}>
        <span>เปิดใช้งาน</span>
    </label>
</div>

{{-- รูป --}}
<div class="mt-4">
    @if($promotion->image)
        <img src="{{ asset('storage/'.$promotion->image) }}"
             class="w-24 mb-2 rounded">
    @endif
    <input type="file" name="image">
</div>

<button class="mt-6 bg-indigo-600 text-white px-6 py-2 rounded">
    อัปเดต
</button>

</form>
</div>
</x-app-layout>
