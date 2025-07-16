<form method="post" action="{{ route('profile.password.update') }}" class="form-validate is-alter">
    @csrf
    @method('patch')

    <!-- Password Requirements Info -->
    <div class="alert alert-info alert-icon mb-4">
        <em class="icon ni ni-info-circle"></em>
        <strong>Password Requirements:</strong>
        <ul class="mt-2 mb-0">
            <li>Minimum 8 characters</li>
            <li>At least one uppercase letter (A-Z)</li>
            <li>At least one lowercase letter (a-z)</li>
            <li>At least one number (0-9)</li>
            <li>At least one special character (@$!%*?&)</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="update_password_current_password">{{ __('Current Password') }} <span class="text-danger">*</span></label>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="update_password_current_password">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <input type="password" class="form-control form-control-lg" id="update_password_current_password" name="current_password" autocomplete="current-password" required>
                    @error('current_password')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="update_password_password">{{ __('New Password') }} <span class="text-danger">*</span></label>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="update_password_password">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <input type="password" class="form-control form-control-lg" id="update_password_password" name="password" autocomplete="new-password" required>
                    @error('password')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-note">Enter your new password according to the requirements above.</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="update_password_password_confirmation">{{ __('Confirm New Password') }} <span class="text-danger">*</span></label>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="update_password_password_confirmation">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <input type="password" class="form-control form-control-lg" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                    @error('password_confirmation')
                        <span class="invalid text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-note">Re-enter your new password to confirm.</div>
            </div>
        </div>
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
        @if (session('status') === 'password-updated')
            <span class="text-success ms-2" id="password-saved">{{ __('Password updated successfully!') }}</span>
            <script>
                setTimeout(function() {
                    document.getElementById('password-saved').style.display = 'none';
                }, 3000);
            </script>
        @endif
    </div>
</form>
