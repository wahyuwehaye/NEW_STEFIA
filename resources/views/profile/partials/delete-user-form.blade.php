<div class="alert alert-fill alert-danger alert-icon">
    <em class="icon ni ni-alert-circle"></em>
    <strong>Warning!</strong> Before deleting your account, please download any data or information that you wish to retain.
</div>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <em class="icon ni ni-trash"></em>
    <span>{{ __('Delete Account') }}</span>
</button>

<!-- Delete Account Modal -->
<div class="modal fade" tabindex="-1" id="deleteAccountModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Delete Account') }}</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('delete')
                    
                    <div class="alert alert-warning alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>{{ __('Are you sure you want to delete your account?') }}</strong>
                    </div>
                    
                    <p class="text-soft">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                    
                    <div class="form-group">
                        <label class="form-label" for="delete_password">{{ __('Confirm Password') }}</label>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="delete_password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" class="form-control form-control-lg" id="delete_password" name="password" placeholder="{{ __('Enter your password') }}" required>
                            @if($errors->userDeletion->has('password'))
                                <span class="invalid text-danger">{{ $errors->userDeletion->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <em class="icon ni ni-trash"></em>
                    <span>{{ __('Delete Account') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        deleteModal.show();
    });
</script>
@endif
