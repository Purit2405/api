<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            แก้ไขหมวดหมู่
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">

                <form method="POST"
                      action="{{ route('admin.categories.update', $category) }}"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label>ชื่อหมวดหมู่</label>
                        <input name="name"
                               value="{{ $category->name }}"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <div>
                        <label>รูปหมวดหมู่</label><br>
                        @if($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}"
                                 class="w-24 mb-2 rounded">
                        @endif
                        <input type="file" name="image">
                    </div>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                            อัปเดต
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                           class="px-4 py-2 bg-gray-300 rounded">
                            กลับ
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
