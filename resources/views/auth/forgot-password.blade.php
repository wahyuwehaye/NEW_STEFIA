<x-auth-new title="Lupa Kata Sandi">
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div class="auth-content">
            <div class="auth-header">
                <h1 class="auth-title text-2xl">Lupa Kata Sandi</h1>
                <p class="auth-description">Masukkan alamat email Anda dan kami akan mengirimkan link reset kata sandi ke email Anda.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Email -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <span class="input-icon ni ni-mail"></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan alamat email Anda" class="input-field">
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-red w-full" style="display: block !important; visibility: visible !important;">Kirim Link Reset</button>

            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="link">Kembali ke Masuk</a>
            </div>
        </div>
    </form>
</x-auth-new>
