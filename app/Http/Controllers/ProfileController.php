<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\AvatarUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        return view('profile.edit', [
            'user' => $user,
            'recentActivity' => $user->activityLogs()->latest()->take(10)->get(),
            'loginHistory' => $user->activityLogs()->where('action', 'login')->latest()->take(5)->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldData = $user->only(['name', 'email', 'phone', 'address', 'department', 'position']);
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        
        // Log the profile update
        $user->logActivity('profile_updated', 'user', $user->id, [
            'old_data' => $oldData,
            'new_data' => $user->only(['name', 'email', 'phone', 'address', 'department', 'position'])
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);
        
        // Log password change
        $user->logActivity('password_changed', 'user', $user->id);
        
        return Redirect::route('profile.edit')
            ->with('status', 'password-updated')
            ->with('message', 'Password berhasil diperbarui.');
    }
    
    /**
     * Update the user's avatar.
     */
    public function updateAvatar(AvatarUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Store new avatar
            $fileName = Str::random(40) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars', $fileName, 'public');
            
            $user->update(['avatar' => $path]);
            
            // Log avatar update
            $user->logActivity('avatar_updated', 'user', $user->id);
            
            return Redirect::route('profile.edit')
                ->with('status', 'avatar-updated')
                ->with('message', 'Foto profil berhasil diperbarui.');
        }
        
        return Redirect::route('profile.edit')
            ->with('error', 'Tidak ada file yang diupload.');
    }
    
    /**
     * Remove the user's avatar.
     */
    public function removeAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
            
            // Log avatar removal
            $user->logActivity('avatar_removed', 'user', $user->id);
            
            return Redirect::route('profile.edit')
                ->with('status', 'avatar-removed')
                ->with('message', 'Foto profil berhasil dihapus.');
        }
        
        return Redirect::route('profile.edit')
            ->with('error', 'Tidak ada foto profil untuk dihapus.');
    }
    
    /**
     * Show user's activity log.
     */
    public function activityLog(Request $request): View
    {
        $user = $request->user();
        
        $activities = $user->activityLogs()
            ->latest()
            ->paginate(20);
            
        return view('profile.activity-log', [
            'user' => $user,
            'activities' => $activities,
        ]);
    }
    
    /**
     * Show user's login history.
     */
    public function loginHistory(Request $request): View
    {
        $user = $request->user();
        
        $loginHistory = $user->activityLogs()
            ->where('action', 'login')
            ->latest()
            ->paginate(20);
            
        return view('profile.login-history', [
            'user' => $user,
            'loginHistory' => $loginHistory,
        ]);
    }
    
    /**
     * Show security settings.
     */
    public function security(Request $request): View
    {
        $user = $request->user();
        
        return view('profile.security', [
            'user' => $user,
            'recentLoginAttempts' => $user->activityLogs()
                ->where('action', 'login')
                ->orWhere('action', 'failed_login')
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        
        // Log account deletion
        $user->logActivity('account_deleted', 'user', $user->id);
        
        // Delete avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
