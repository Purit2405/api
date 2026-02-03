<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">แก้ไขข่าว</h2>
</x-slot>

<div class="p-6 max-w-3xl mx-auto bg-white rounded shadow">
<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('admin.news.update',$news) }}">
@csrf
@method('PUT')

<input name="title"
       value="{{ $news->title }}"
       class="w-full border p-2 mb-3">

<input type="date" name="publish_date"
       value="{{ $news->publish_date }}"
       class="w-full border p-2 mb-3">

@if($news->image)
<img src="{{ asset('storage/'.$news->image) }}" class="w-32 mb-2">
@endif

<input type="file" name="image" class="mb-3">

<label>
<input type="checkbox" name="is_active" value="1"
 {{ $news->is_active ? 'checked' : '' }}>
 เปิดใช้งาน
</label>

<button class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded">
อัปเดต
</button>
</form>
</div>
</x-app-layout>
