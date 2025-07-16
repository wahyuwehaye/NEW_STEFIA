@extends('layouts.admin')

@section('title', 'Profile Settings')

@section('content')
<x-page-header 
    title="Profile Settings" 
    subtitle="Manage your account information and security settings"
    :breadcrumbs="[
        ['title' => 'Profile']
    ]">
    <x-slot name="actions">
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <div class="toggle-content">
                    <ul class="nk-block-tools g-3">
                        <li><a href="{{ route('profile.activity') }}" class="btn btn-outline-light"><em class="icon ni ni-activity"></em><span>Activity Log</span></a></li>
                        <li><a href="{{ route('profile.security') }}" class="btn btn-outline-light"><em class="icon ni ni-shield-check"></em><span>Security</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>
</x-page-header>

<!-- Status Messages -->
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        @if(session('status') == 'profile-updated')
            <strong>Berhasil!</strong> Profil Anda telah diperbarui.
        @elseif(session('status') == 'password-updated')
            <strong>Berhasil!</strong> Password Anda telah diperbarui.
        @elseif(session('status') == 'avatar-updated')
            <strong>Berhasil!</strong> Foto profil Anda telah diperbarui.
        @elseif(session('status') == 'avatar-removed')
            <strong>Berhasil!</strong> Foto profil Anda telah dihapus.
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('message'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Info!</strong> {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="nk-block">
    <div class="row g-gs">
        <!-- Profile Avatar Card -->
        <div class="col-xxl-4">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Profile Photo</h6>
                            </div>
                            <div class="card-tools">
                                <em class="icon ni ni-camera"></em>
                            </div>
                        </div>
                        <p class="sub-text">Update your profile photo and view account status.</p>
                    </div>
                    <div class="card-inner">
                        <div class="user-card user-card-s2">
                            <div class="user-avatar xl">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                @else
                                    <span class="bg-primary">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div class="user-info">
                                <h5>{{ $user->name }}</h5>
                                <span class="sub-text">{{ $user->email }}</span>
                                <span class="badge badge-sm {{ $user->status === 'active' ? 'badge-success' : 'badge-warning' }} mt-1">{{ $user->status_label }}</span>
                            </div>
                        </div>
                        
                        <!-- Avatar Upload Form -->
                        <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Update Profile Photo</label>
                                <div class="form-control-wrap">
                                    <input type="file" name="avatar" class="form-control" accept="image/*" required>
                                    @error('avatar')
                                        <div class="form-note-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-note">Maksimal 2MB, format: JPG, PNG, GIF</div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">Upload Photo</button>
                                @if($user->avatar)
                                    <form method="POST" action="{{ route('profile.avatar.remove') }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove your profile photo?')">Remove Photo</button>
                                    </form>
                                @endif
                            </div>
                        </form>
                        
                        <!-- Profile Stats -->
                        <div class="row gy-4 pt-4">
                            <div class="col-12">
                                <div class="user-status user-status-unverified">
                                    <span class="sub-text">Account Status:</span>
                                    <span class="badge badge-dot badge-{{ $user->status === 'active' ? 'success' : 'warning' }}">{{ $user->status_label }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <span class="sub-text">Member Since:</span>
                                <span>{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="col-6">
                                <span class="sub-text">Last Login:</span>
                                <span>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y') : 'Never' }}</span>
                            </div>
                            <div class="col-6">
                                <span class="sub-text">Role:</span>
                                <span>{{ $user->role_name }}</span>
                            </div>
                            <div class="col-6">
                                <span class="sub-text">Employee ID:</span>
                                <span>{{ $user->employee_id ?? 'Not Set' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profile Information Card -->
        <div class="col-xxl-8">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Profile Information</h6>
                            </div>
                            <div class="card-tools">
                                <em class="icon ni ni-user-circle"></em>
                            </div>
                        </div>
                        <p class="sub-text">Update your account's profile information and email address.</p>
                    </div>
                    <div class="card-inner">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Security Settings Card -->
        <div class="col-xxl-6">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Security Settings</h6>
                            </div>
                            <div class="card-tools">
                                <em class="icon ni ni-shield-check"></em>
                            </div>
                        </div>
                        <p class="sub-text">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    <div class="card-inner">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity Card -->
        <div class="col-xxl-6">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Recent Activity</h6>
                            </div>
                            <div class="card-tools">
                                <a href="{{ route('profile.activity') }}" class="link">View All</a>
                            </div>
                        </div>
                        <p class="sub-text">Your recent account activity and login history.</p>
                    </div>
                    <div class="card-inner">
                        @if($recentActivity->count() > 0)
                            <div class="timeline">
                                @foreach($recentActivity as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-status bg-{{ $activity->action === 'login' ? 'success' : 'primary' }}"></div>
                                        <div class="timeline-date">{{ $activity->created_at->format('M d, H:i') }}</div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</h6>
                                            <div class="timeline-des">
                                                <p>{{ ucfirst($activity->resource) }} activity from {{ $activity->ip_address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <em class="icon ni ni-activity text-muted" style="font-size: 3rem;"></em>
                                <p class="text-muted mt-2">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Danger Zone Card -->
        <div class="col-12">
            <div class="card card-bordered border-danger">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title text-danger">Danger Zone</h6>
                            </div>
                            <div class="card-tools">
                                <em class="icon ni ni-alert-circle text-danger"></em>
                            </div>
                        </div>
                        <p class="sub-text">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
                    </div>
                    <div class="card-inner">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
