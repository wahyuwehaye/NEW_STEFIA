# Migration Guide: Laravel Breeze to Spatie Permission

## Jika ingin menggunakan Spatie Permission untuk project STEFIA

### 1. Install Spatie Permission
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 2. Update User Model
```php
// app/Models/User.php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    
    // Remove manual role methods
    // public function isAdmin() { ... }
    // public function hasRole() { ... }
}
```

### 3. Create Seeder for Roles & Permissions
```php
// database/seeders/RolePermissionSeeder.php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view users',
            'create users',
            'update users', 
            'delete users',
            'manage roles',
            'view payments',
            'create payments',
            'verify payments',
            'view reports',
            'export reports',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());
        
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users', 'create users', 'update users',
            'view payments', 'create payments', 'view reports'
        ]);
        
        $finance = Role::create(['name' => 'finance']);
        $finance->givePermissionTo([
            'view payments', 'create payments', 'verify payments',
            'view reports', 'export reports'
        ]);
    }
}
```

### 4. Update Middleware
```php
// routes/web.php
Route::middleware(['auth', 'role:super_admin|admin'])->group(function () {
    Route::resource('users', UsersController::class);
});

Route::middleware(['auth', 'permission:verify payments'])->group(function () {
    Route::post('/payments/verify/{payment}', [PaymentsController::class, 'verify']);
});
```

### 5. Update Views
```blade
@can('create users')
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
@endcan

@role('super_admin')
    <li><a href="{{ route('users.roles') }}">Manage Roles</a></li>
@endrole
```

### 6. Update Controllers
```php
// app/Http/Controllers/UsersController.php
public function __construct()
{
    $this->middleware('permission:view users')->only(['index', 'show']);
    $this->middleware('permission:create users')->only(['create', 'store']);
    $this->middleware('permission:update users')->only(['edit', 'update']);
    $this->middleware('permission:delete users')->only(['destroy']);
}
```

## Kesimpulan

### Tetap dengan Breeze jika:
- Tim development kecil
- Requirement role sederhana
- Fokus pada kecepatan development
- Aplikasi tidak akan berkembang kompleks

### Upgrade ke Spatie jika:
- Butuh permission granular per fitur
- Aplikasi akan berkembang kompleks
- Butuh dynamic role/permission management
- Tim sudah familiar dengan package ini

## Untuk project STEFIA saat ini, **Laravel Breeze sudah cukup** dan implementasi yang sudah ada sudah baik.
