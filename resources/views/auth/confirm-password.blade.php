<x-auth-new title="Konfirmasi Kata Sandi">
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div class="auth-content">
            <div class="auth-header">
                <h1 class="auth-title text-2xl">Konfirmasi Kata Sandi</h1>
                <p class="auth-description">Ini adalah area aman dari aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.</p>
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Kata Sandi</label>
                <span class="input-icon ni ni-lock"></span>
                <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi Anda" class="input-field">
                <a href="#" class="toggle-password" data-target="password"><i class="ni ni-eye"></i></a>
                <x-input-error :messages="$errors->get('password')" class="input-error" />
            </div>

            <button type="submit" class="btn btn-red w-full">Konfirmasi</button>
        </div>
    </form>
</x-auth-new>
