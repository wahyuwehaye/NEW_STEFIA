# STEFIA - Akun Testing

Berikut adalah akun-akun yang telah dibuat untuk testing sistem STEFIA:

## Database Information
- **Database Name:** `new_stefia`
- **Default Password:** `password123` (untuk semua akun)

## Akun Testing

### 1. Super Administrator
- **Email:** `superadmin@stefia.com`
- **Password:** `password123`
- **Role:** `super_admin`
- **Akses:** Full access ke semua fitur sistem

### 2. Administrator
- **Email:** `admin@stefia.com`
- **Password:** `password123`
- **Role:** `admin`
- **Akses:** Administrative access

### 3. Finance Officer
- **Email:** `finance@stefia.com`
- **Password:** `password123`
- **Role:** `finance`
- **Akses:** Financial management features

### 4. Staff Member
- **Email:** `staff@stefia.com`
- **Password:** `password123`
- **Role:** `staff`
- **Akses:** Staff level features

### 5. Regular User
- **Email:** `user@stefia.com`
- **Password:** `password123`
- **Role:** `user`
- **Akses:** Basic user features

### 6. Student
- **Email:** `student@stefia.com`
- **Password:** `password123`
- **Role:** `student`
- **Akses:** Student portal features

## Role Permissions

### Super Admin (`super_admin`)
- Full system access
- User management
- System configuration
- All financial operations
- All reports and analytics

### Admin (`admin`)
- Most system features
- User management (limited)
- Student management
- Financial operations
- Reports

### Finance Officer (`finance`)
- Financial management
- Payment processing
- Financial reports
- Student fee management

### Staff (`staff`)
- Student information management
- Basic reporting
- Limited financial operations

### Student (`student`)
- Personal information
- Fee status
- Payment history
- Scholarship information

### User (`user`)
- Basic access
- Profile management

## Database Schema

### Users Table
```sql
- id (Primary Key)
- name (User's full name)
- email (Unique email address)
- role (User role: super_admin, admin, finance, staff, student, user)
- phone (Phone number)
- address (User address)
- last_login_at (Last login timestamp)
- is_active (Active status)
- email_verified_at (Email verification timestamp)
- password (Hashed password)
- remember_token (Remember token for sessions)
- created_at (Creation timestamp)
- updated_at (Update timestamp)
```

## Reset Database

Untuk mereset database dan membuat ulang data testing:

```bash
php artisan migrate:fresh --seed
```

## Notes

- Semua akun sudah terverifikasi email
- Semua akun dalam status aktif
- Password default: `password123`
- Database menggunakan MySQL dengan charset `utf8mb4`
- Terdapat 10 akun tambahan yang dibuat menggunakan factory untuk testing
