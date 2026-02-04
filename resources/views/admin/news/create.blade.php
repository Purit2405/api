<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">เพิ่มข่าว</h2>
</x-slot>

<div class="p-6 max-w-3xl mx-auto bg-white rounded shadow">
<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('admin.news.store') }}">
@csrf

<input name="title" class="w-full border p-2 mb-3"
       placeholder="หัวข้อข่าว">

<input type="date" name="publish_date"
       class="w-full border p-2 mb-3">

<input type="file" name="image" class="mb-3">

<label class="block mb-4">
<input type="checkbox" name="is_active" value="1" checked>
 เปิดใช้งาน
</label>

<button class="bg-indigo-600 text-white px-6 py-2 rounded">
บันทึก
</button>
</form>
</div>
</x-app-layout>
