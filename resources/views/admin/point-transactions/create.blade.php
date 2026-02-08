<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ เพิ่มแต้มให้ผู้ใช้</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <div class="bg-white shadow rounded-xl p-6">

            {{-- แจ้ง error --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.point-transactions.store') }}">
                @csrf

                {{-- ใช้เก็บสถานะว่าพบ user หรือไม่ --}}
                <input type="hidden" id="user-found" value="0">

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

                {{-- ชื่อผู้ใช้ --}}
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

                {{-- จำนวนแต้ม --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        จำนวนแต้ม
                    </label>
                    <input
                        type="number"
                        name="points"
                        min="1"
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

                {{-- ปุ่ม submit --}}
                <button
                    type="submit"
                    id="submit-btn"
                    disabled
                    class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                >
                    เพิ่มแต้ม
                </button>
            </form>

        </div>
    </div>

    {{-- ================= JS ================= --}}
    <script>
        const phoneInput   = document.getElementById('phone');
        const userName     = document.getElementById('user-name');
        const statusText   = document.getElementById('user-status');
        const submitBtn    = document.getElementById('submit-btn');
        const userFoundInp = document.getElementById('user-found');

        let timeout = null;

        function disableSubmit() {
            submitBtn.disabled = true;
            submitBtn.className =
                'bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed';
            userFoundInp.value = 0;
        }

        function enableSubmit() {
            submitBtn.disabled = false;
            submitBtn.className =
                'bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700';
            userFoundInp.value = 1;
        }

        phoneInput.addEventListener('input', () => {
            clearTimeout(timeout);

            userName.value = '';
            statusText.textContent = '';
            disableSubmit();

            if (phoneInput.value.length < 9) return;

            timeout = setTimeout(() => {
                fetch(`{{ route('admin.point-transactions.find-user') }}?phone=${phoneInput.value}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.found) {
                            userName.value = data.name;
                            statusText.textContent = '✔ พบผู้ใช้';
                            statusText.className = 'text-green-600 text-sm';
                            enableSubmit();
                        } else {
                            statusText.textContent = '❌ ไม่พบผู้ใช้ในระบบ';
                            statusText.className = 'text-red-600 text-sm';
                            disableSubmit();
                        }
                    })
                    .catch(() => {
                        statusText.textContent = 'เกิดข้อผิดพลาด';
                        statusText.className = 'text-red-600 text-sm';
                        disableSubmit();
                    });
            }, 500);
        });
    </script>
</x-app-layout>
