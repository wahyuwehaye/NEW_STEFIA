<form method="post" action="{{ route('password.update') }}" class="form-validate is-alter">
    @csrf
    @method('put')

    <div class="row gy-4">
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="update_password_current_password">{{ __('Current Password') }}</label>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="update_password_current_password">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <input type="password" class="form-control form-control-lg" id="update_password_current_password" name="current_password" autocomplete="current-password">
                    @if($errors->updatePassword->has('current_password'))
                        <span class="invalid text-danger">{{ $errors->updatePassword->first('current_password') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="update_password_password">{{ __('New Password') }}</label>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="update_password_password">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <input type="password" class="form-control form-control-lg" id="update_password_password" name="password" autocomplete="new-password">
                    @if($errors->updatePassword->has('password'))
                        <span class="invalid text-danger">{{ $errors->updatePassword->first('password') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="update_password_password_confirmation">{{ __('Confirm New Password') }}</label>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="update_password_password_confirmation">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <input type="password" class="form-control form-control-lg" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
                    @if($errors->updatePassword->has('password_confirmation'))
                        <span class="invalid text-danger">{{ $errors->updatePassword->first('password_confirmation') }}</span>
                    @endif
                </div>
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
