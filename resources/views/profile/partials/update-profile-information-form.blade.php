<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="form-validate is-alter">
    @csrf
    @method('patch')

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="name">{{ __('Full Name') }} <span class="text-danger">*</span></label>
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
                <label class="form-label" for="email">{{ __('Email Address') }} <span class="text-danger">*</span></label>
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
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="phone">{{ __('Phone Number') }}</label>
                <div class="form-control-wrap">
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                    @error('phone')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="employee_id">{{ __('Employee ID') }}</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}" autocomplete="organization">
                    @error('employee_id')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="department">{{ __('Department') }}</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="department" name="department" value="{{ old('department', $user->department) }}" autocomplete="organization">
                    @error('department')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="position">{{ __('Position') }}</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $user->position) }}" autocomplete="organization-title">
                    @error('position')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="address">{{ __('Address') }}</label>
                <div class="form-control-wrap">
                    <textarea class="form-control" id="address" name="address" rows="3" autocomplete="street-address">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
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
