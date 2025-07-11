<x-auth-new title="Reset Kata Sandi">
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-content">
            <div class="auth-header">
                <h1 class="auth-title text-2xl">Reset Kata Sandi</h1>
                <p class="auth-description">Masukkan kata sandi baru Anda untuk mengakses akun STEFIA.</p>
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <span class="input-icon ni ni-mail"></span>
                <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="Masukkan alamat email Anda" class="input-field">
                <x-input-error :messages="$errors->get('email')" class="input-error" />
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Kata Sandi Baru</label>
                <span class="input-icon ni ni-lock"></span>
                <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi baru" class="input-field">
                <a href="#" class="toggle-password" data-target="password"><i class="ni ni-eye"></i></a>
                <x-input-error :messages="$errors->get('password')" class="input-error" />
            </div>

            <!-- Konfirmasi Password -->
            <div class="input-group">
                <label for="password_confirmation" class="input-label">Konfirmasi Kata Sandi</label>
                <span class="input-icon ni ni-lock"></span>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Konfirmasi kata sandi baru" class="input-field">
                <a href="#" class="toggle-password" data-target="password_confirmation"><i class="ni ni-eye"></i></a>
                <x-input-error :messages="$errors->get('password_confirmation')" class="input-error" />
            </div>

            <button type="submit" class="btn btn-red w-full">Reset Kata Sandi</button>

            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="link">Kembali ke Masuk</a>
            </div>
        </div>
    </form>
</x-auth-new>
