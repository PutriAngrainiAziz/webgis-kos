<x-guest-layout>

     <!-- Pesan error dari middleware -->
    {{-- @if ($errors->has('verifikasi'))
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ $errors->first('verifikasi') }}
        </div>
    @endif --}}
    @if ($errors->has('verifikasi'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: '{{ $errors->first('verifikasi') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif




    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-semibold text-center mb-4 mt-3">Selamat Datang, Silahkan Login</h2>

    <form method="POST" action="{{ route('login') }}" class="mt-6">
        @csrf

        <!-- Email Address -->
        <div>
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    Lupa kata sandi ?
                </a>
            @endif

            <x-primary-button class="ms-3">
                Masuk
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
