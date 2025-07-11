@extends('layouts.auth-new')

@section('title', 'Sign-In')

@section('content')
    <div class="auth-title">Sign-In</div>
    <div class="auth-subtitle">Akses panel STEFIA menggunakan email dan password Anda.</div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email atau Username">
            <div class="input-icon">
                <em class="icon ni ni-mail"></em>
            </div>
            @error('email')
                <div class="alert mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" placeholder="Password">
            <div class="input-icon" onclick="togglePassword()">
                <em class="icon ni ni-eye" id="toggleIcon"></em>
            </div>
            @error('password')
                <div class="alert mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me and Forgot Password -->
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Ingat saya</label>
        </div>
        
        @if (Route::has('password.request'))
            <a class="forgot-link" href="{{ route('password.request') }}">Lupa Password?</a>
        @endif

        <button type="submit" class="btn-auth">
            <em class="icon ni ni-signin"></em>
            Sign In
        </button>
    </form>

    <div class="divider">
        <span>ATAU</span>
    </div>

    <div class="auth-footer">
        Baru di platform kami? 
        <a href="{{ route('register') }}">Buat akun</a>
    </div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.className = 'icon ni ni-eye-off';
        } else {
            passwordInput.type = 'password';
            toggleIcon.className = 'icon ni ni-eye';
        }
    }
</script>
@endpush
