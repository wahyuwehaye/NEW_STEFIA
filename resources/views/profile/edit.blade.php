@extends('layouts.admin')

@section('title', 'Profile Settings')

@section('content')
<x-page-header 
    title="Profile Settings" 
    subtitle="Manage your account information and security settings"
    :breadcrumbs="[
        ['title' => 'Profile']
    ]">
</x-page-header>

<div class="nk-block">
    <div class="row g-gs">
        <!-- Profile Information Card -->
        <div class="col-xxl-6">
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
        
        <!-- Profile Avatar Card -->
        <div class="col-xxl-6">
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
                        <p class="sub-text">Update your profile photo and personal information.</p>
                    </div>
                    <div class="card-inner">
                        <div class="user-card user-card-s2">
                            <div class="user-avatar lg bg-primary">
                                <span>{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            </div>
                            <div class="user-info">
                                <h5>{{ auth()->user()->name }}</h5>
                                <span class="sub-text">{{ auth()->user()->email }}</span>
                                <span class="sub-text">{{ ucfirst(auth()->user()->role ?? 'User') }}</span>
                            </div>
                        </div>
                        <div class="row gy-4 pt-4">
                            <div class="col-sm-6">
                                <span class="sub-text">Member Since:</span>
                                <span>{{ auth()->user()->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="sub-text">Last Login:</span>
                                <span>{{ now()->format('M d, Y') }}</span>
                            </div>
                        </div>
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
        
        <!-- Danger Zone Card -->
        <div class="col-xxl-6">
            <div class="card card-bordered">
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
                        <p class="sub-text">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
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
