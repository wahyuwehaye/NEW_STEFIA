<x-auth-new title="Sign-In">
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="auth-content">
            <div class="auth-header">
                <h1 class="auth-title text-2xl">Sign-In</h1>
                <p class="auth-description">Akses panel STEFIA menggunakan email dan password Anda.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Email Address -->
            <div class="input-group">
                <label for="email" class="input-label">Email atau Username</label>
                <span class="input-icon ni ni-mail"></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email atau username Anda" class="input-field">
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <span class="input-icon ni ni-lock"></span>
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" class="input-field">
                <a href="#" class="toggle-password" data-target="password"><i class="ni ni-eye"></i></a>
                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="form-options">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Ingat saya</label>
                </div>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link">Lupa Password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-red w-full">
                <em class="icon ni ni-signin"></em>
                Sign In
            </button>

            <div class="text-center text-sm">
                Baru di platform kami? 
                <a href="{{ route('register') }}" class="link">Buat akun</a>
            </div>
        </div>
    </form>
</x-auth-new>
