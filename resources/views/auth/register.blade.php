<x-auth-new title="Buat Akun">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="auth-content">
            <div class="auth-header">
                <h1 class="auth-title text-2xl">Daftar</h1>
                <p class="auth-description">Buat akun STEFIA Anda untuk mengakses platform.</p>
            </div>

            <!-- Nama -->
            <div class="input-group">
                <label for="name" class="input-label">Nama</label>
                <span class="input-icon ni ni-user"></span>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama Anda" class="input-field">
                <x-input-error :messages="$errors->get('name')" class="input-error" />
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <span class="input-icon ni ni-mail"></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan alamat email Anda" class="input-field">
                <x-input-error :messages="$errors->get('email')" class="input-error" />
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Kata Sandi</label>
                <span class="input-icon ni ni-lock"></span>
                <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi" class="input-field">
                <a href="#" class="toggle-password" data-target="password"><i class="ni ni-eye"></i></a>
                <x-input-error :messages="$errors->get('password')" class="input-error" />
            </div>

            <!-- Konfirmasi Password -->
            <div class="input-group">
                <label for="password_confirmation" class="input-label">Konfirmasi Kata Sandi</label>
                <span class="input-icon ni ni-lock"></span>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Konfirmasi kata sandi" class="input-field">
                <a href="#" class="toggle-password" data-target="password_confirmation"><i class="ni ni-eye"></i></a>
                <x-input-error :messages="$errors->get('password_confirmation')" class="input-error" />
            </div>

            <button type="submit" class="btn btn-red w-full">Daftar</button>

            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="link">Sudah punya akun? Masuk</a>
            </div>
        </div>
    </form>
</x-auth-new>
