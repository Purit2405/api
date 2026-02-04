<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ เพิ่มแต้มให้ผู้ใช้</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <div class="bg-white shadow rounded-xl p-6">

            <form method="POST" action="{{ route('admin.point-transactions.store') }}">
                @csrf

                {{-- เบอร์โทร --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        เบอร์โทรศัพท์
                    </label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="w-full rounded border-gray-300"
                        placeholder="0991234567"
                        required
                    >
                    <p id="user-status" class="text-sm mt-1"></p>
                </div>

                {{-- ชื่อผู้ใช้ (แสดงอย่างเดียว) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        ชื่อผู้ใช้งาน
                    </label>
                    <input
                        type="text"
                        id="user-name"
                        class="w-full rounded bg-gray-100"
                        disabled
                    >
                </div>

                {{-- แต้ม --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        จำนวนแต้ม
                    </label>
                    <input
                        type="number"
                        name="points"
                        class="w-full rounded border-gray-300"
                        required
                    >
                </div>

                {{-- หมายเหตุ --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">
                        หมายเหตุ
                    </label>
                    <textarea
                        name="description"
                        class="w-full rounded border-gray-300"
                        rows="3"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded"
                >
                    เพิ่มแต้ม
                </button>
            </form>

        </div>
    </div>

    {{-- JS --}}
    <script>
        const phoneInput = document.getElementById('phone');
        const userNameInput = document.getElementById('user-name');
        const statusText = document.getElementById('user-status');

        let timeout = null;

        phoneInput.addEventListener('input', () => {
            clearTimeout(timeout);

            userNameInput.value = '';
            statusText.textContent = '';

            if (phoneInput.value.length < 9) return;

            timeout = setTimeout(() => {
                fetch(`{{ route('admin.point-transactions.find-user') }}?phone=${phoneInput.value}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.found) {
                            userNameInput.value = data.name;
                            statusText.textContent = '✔ พบผู้ใช้';
                            statusText.className = 'text-green-600 text-sm';
                        } else {
                            statusText.textContent = '❌ ไม่พบผู้ใช้';
                            statusText.className = 'text-red-600 text-sm';
                        }
                    });
            }, 500);
        });
    </script>
</x-app-layout>
