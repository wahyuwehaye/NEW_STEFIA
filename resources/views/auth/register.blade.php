<x-auth-layout title="Create an Account">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Register</h5>
                <div class="nk-block-des">
                    <p>Create your STEFIA account to access the platform.</p>
                </div>
            </div>
        </div>

        <!-- Name -->
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="name">Name</label>
            </div>
            <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="email">Email</label>
            </div>
            <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email address">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="form-control-wrap">
                <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" class="form-control form-control-lg" id="password" name="password" required autocomplete="new-password" placeholder="Enter your password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
            </div>
            <div class="form-control-wrap">
                <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password_confirmation">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block">Register</button>
        </div>
    </form>

    <div class="form-note-s2 text-center pt-4">
        <a href="{{ route('login') }}">Already registered? Sign in</a>
    </div>
</x-auth-layout>
