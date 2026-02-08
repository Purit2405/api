<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Validation Errors --}}
        <x-validation-errors class="mb-4" />

        {{-- Status Message --}}
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div>
                <x-label for="email" value="อีเมล" />
                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
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
                    autocomplete="current-password"
                />
            </div>

            {{-- Remember Me --}}
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">
                        จดจำการเข้าสู่ระบบ
                    </span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between mt-6">
                <div>
                    @if (Route::has('password.request'))
                        <a
                            class="underline text-sm text-gray-600 hover:text-gray-900
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}"
                        >
                            ลืมรหัสผ่าน?
                        </a>
                    @endif
                </div>

                <x-button>
                    เข้าสู่ระบบ
                </x-button>
            </div>
        </form>

        {{-- Register Link --}}
        <div class="mt-6 text-center border-t pt-4">
            <p class="text-sm text-gray-600">
                ยังไม่มีบัญชีใช่ไหม?
                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-indigo-600 hover:text-indigo-700 underline"
                >
                    สมัครสมาชิก
                </a>
            </p>
        </div>

    </x-authentication-card>
</x-guest-layout>
