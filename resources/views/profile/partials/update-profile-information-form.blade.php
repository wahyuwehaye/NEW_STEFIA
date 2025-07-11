<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="form-validate is-alter">
    @csrf
    @method('patch')

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="name">{{ __('Full Name') }}</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                <div class="form-control-wrap">
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning alert-icon mt-2">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>{{ __('Your email address is unverified.') }}</strong>
                        <button form="send-verification" class="btn btn-sm btn-warning ms-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                        @if (session('status') === 'verification-link-sent')
                            <div class="mt-2">
                                <small class="text-success">{{ __('A new verification link has been sent to your email address.') }}</small>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
        @if (session('status') === 'profile-updated')
            <span class="text-success ms-2" id="profile-saved">{{ __('Saved successfully!') }}</span>
            <script>
                setTimeout(function() {
                    document.getElementById('profile-saved').style.display = 'none';
                }, 3000);
            </script>
        @endif
    </div>
</form>
