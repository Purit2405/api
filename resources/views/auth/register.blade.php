<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <div>
                <x-label for="name" value="ชื่อผู้ใช้" />
                <x-input
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                />
            </div>

            {{-- Email --}}
            <div class="mt-4">
                <x-label for="email" value="อีเมล" />
                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                />
            </div>

            {{-- Phone --}}
            <div class="mt-4">
                <x-label for="phone" value="เบอร์โทรศัพท์" />
                <x-input
                    id="phone"
                    class="block mt-1 w-full"
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <x-label for="password" value="รหัสผ่าน" />
                <x-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                />
            </div>

            {{-- Confirm Password --}}
            <div class="mt-4">
                <x-label for="password_confirmation" value="ยืนยันรหัสผ่าน" />
                <x-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    required
                />
            </div>

            {{-- Terms & Privacy --}}
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <label for="terms" class="flex items-center">
                        <x-checkbox name="terms" id="terms" required />

                        <span class="ms-2 text-sm text-gray-600">
                            ฉันยอมรับ
                            <a href="{{ route('terms') }}"
                               target="_blank"
                               class="underline hover:text-gray-900">
                                ข้อตกลงการใช้งาน
                            </a>
                            และ
                            <a href="{{ route('privacy') }}"
                               target="_blank"
                               class="underline hover:text-gray-900">
                                นโยบายความเป็นส่วนตัว
                            </a>
                        </span>
                    </label>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center justify-end mt-4">
                <a
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                    href="{{ route('login') }}"
                >
                    มีบัญชีอยู่แล้ว?
                </a>

                <x-button class="ms-4">
                    สมัครสมาชิก
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
