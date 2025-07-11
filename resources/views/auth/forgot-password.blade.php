<x-auth-new title="Lupa Kata Sandi">
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div class="auth-content">
            <div class="auth-header">
                <h1 class="auth-title text-2xl">Lupa Kata Sandi</h1>
                <p class="auth-description">Masukkan alamat email Anda dan kami akan mengirimkan link reset kata sandi ke email Anda.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Email -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <span class="input-icon ni ni-mail"></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan alamat email Anda" class="input-field">
                <x-input-error :messages="$errors->get('email')" class="input-error" />
            </div>

            <button type="submit" class="btn btn-red w-full">Kirim Link Reset</button>

            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="link">Kembali ke Masuk</a>
            </div>
        </div>
    </form>
</x-auth-new>
