# Session Timeout Implementation for STEFIA

## Overview
Implementasi session timeout untuk mengatasi error "Call to a member function canManageUsers() on null" ketika session sudah habis. Sistem ini secara otomatis mengarahkan user ke halaman login ketika session expired.

## Components

### 1. Middleware Session Handling

#### `SessionTimeout` Middleware
- **File**: `app/Http/Middleware/SessionTimeout.php`
- **Function**: Mengecek session timeout berdasarkan activity terakhir
- **Features**:
  - Auto-redirect ke login jika session expired
  - Support untuk AJAX requests (JSON response)
  - Update last activity timestamp

#### `CheckUserApproval` Middleware (Enhanced)
- **File**: `app/Http/Middleware/CheckUserApproval.php`  
- **Function**: Pengecekan lebih robust untuk authentication
- **Features**:
  - Validasi user object tidak null
  - Handle session expired gracefully
  - Support JSON response untuk API requests

### 2. Frontend Session Management

#### JavaScript Session Timeout Handler
- **File**: `public/js/session-timeout.js`
- **Features**:
  - Monitor user activity (mouse, keyboard, scroll)
  - Warning modal sebelum logout
  - Auto-extend session via API
  - Handle AJAX 401 errors

#### Authentication Utilities
- **File**: `public/js/auth-utils.js`
- **Features**:
  - CSRF token management
  - Authenticated fetch wrapper
  - Form submission helper
  - Auto-refresh CSRF token

### 3. Template Protection

#### Sidebar Protection
- **File**: `resources/views/layouts/partials/sidebar.blade.php`
- **Changes**: Added `auth()->check()` before `auth()->user()->canManageUsers()`

#### Header Protection  
- **File**: `resources/views/layouts/partials/header.blade.php`
- **Changes**: Added `auth()->check()` before accessing user properties

### 4. API Endpoints

#### Session Extension
- **Endpoint**: `POST /api/extend-session`
- **Function**: Extend user session via AJAX

#### CSRF Token Refresh
- **Endpoint**: `GET /csrf-token`
- **Function**: Get new CSRF token for JavaScript

## Configuration

### Middleware Registration
```php
// bootstrap/app.php
$middleware->alias([
    // ... other middleware
    'session.timeout' => \App\Http\Middleware\SessionTimeout::class,
]);

$middleware->appendToGroup('auth', [
    \App\Http\Middleware\SessionTimeout::class,
    \App\Http\Middleware\CheckUserApproval::class,
]);
```

### Session Settings
- **Timeout Duration**: Configurable via `config('session.lifetime')` (default: 120 minutes)
- **Warning Time**: 5 minutes before timeout
- **Check Interval**: Every 30 seconds

### Layout Integration
```html
<!-- Meta tags required -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="session-lifetime" content="{{ config('session.lifetime') }}">

<!-- Scripts required -->
<script src="{{ asset('js/auth-utils.js') }}"></script>
<script src="{{ asset('js/session-timeout.js') }}"></script>
```

## How It Works

### Server-Side Flow
1. **Request**: User makes request to protected route
2. **SessionTimeout Middleware**: Check last activity timestamp
3. **Validation**: Compare with session lifetime
4. **Action**: 
   - If expired → Logout & redirect to login
   - If valid → Update timestamp & continue

### Client-Side Flow
1. **Monitor**: Track user activity events
2. **Timer**: Check session status every 30 seconds  
3. **Warning**: Show modal 5 minutes before timeout
4. **Extend**: User can extend session via button
5. **Timeout**: Auto-redirect if no action taken

### Error Handling
- **Blade Templates**: Use `auth()->check()` before accessing user
- **AJAX Requests**: Handle 401 status codes
- **JavaScript**: Global error handlers for session timeout

## Testing

### Manual Testing
1. Login to the application
2. Wait for session to expire (or set short timeout)
3. Try to access protected page
4. Should redirect to login with appropriate message

### Automated Testing
```bash
php artisan test --filter SessionTimeoutTest
```

## Benefits

1. **Improved Security**: Auto-logout expired sessions
2. **Better UX**: Warning before logout + extend option
3. **Error Prevention**: No more "null user" errors
4. **Consistent Handling**: Both server and client-side protection
5. **Configurable**: Easy to adjust timeouts and warnings

## Future Enhancements

1. **Remember Me**: Different timeouts for remembered sessions
2. **Activity Types**: Different timeouts based on activity type
3. **Multi-Tab Support**: Sync session across browser tabs
4. **Admin Override**: Ability to force logout specific users
5. **Session Statistics**: Track session usage patterns
