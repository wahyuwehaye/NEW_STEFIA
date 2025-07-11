<x-auth-layout title="Login">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Sign-In</h5>
                <div class="nk-block-des">
                    <p>Access the STEFIA dashboard with your email and password.</p>
                </div>
            </div>
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="email">Email</label>
            </div>
            <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email address">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Password</label>
                @if (Route::has('password.request'))
                    <a class="link link-primary link-sm" href="{{ route('password.request') }}">Forgot Code?</a>
                @endif
            </div>
            <div class="form-control-wrap">
                <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" class="form-control form-control-lg" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                <label class="custom-control-label" for="remember_me">Remember me</label>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block">Sign in</button>
        </div>
    </form>

    <div class="form-note-s2 text-center pt-4">
        <a href="{{ route('register') }}">Create an account</a>
    </div>
</x-auth-layout>
