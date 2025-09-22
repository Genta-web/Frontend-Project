# Panduan Setup dan Testing Sistem Login Laravel

## 📋 Daftar Isi
1. [Persiapan Environment](#persiapan-environment)
2. [Setup Database](#setup-database)
3. [Konfigurasi Laravel](#konfigurasi-laravel)
4. [Testing Login System](#testing-login-system)
5. [Troubleshooting](#troubleshooting)

## 🚀 Persiapan Environment

### 1. Pastikan XAMPP Berjalan
- Buka XAMPP Control Panel
- Start **Apache** dan **MySQL**
- Pastikan status keduanya **Running** (hijau)

### 2. Cek PHP dan Composer
```bash
php --version
composer --version
```

## 🗄️ Setup Database

### 1. Buat Database
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Login dengan username: `root`, password: (kosong)
3. Buat database baru bernama: `employee`

### 2. Import Database (Opsional)
Jika ada file SQL:
```bash
# Import melalui phpMyAdmin atau command line
mysql -u root -p employee < employee_db.sql
```

### 3. Jalankan Migration
```bash
cd c:\xampp\htdocs\blablabla
php artisan migrate
```

### 4. Jalankan Seeder
```bash
php artisan db:seed
```

## ⚙️ Konfigurasi Laravel

### 1. File .env sudah dikonfigurasi:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Generate Application Key (jika belum)
```bash
php artisan key:generate
```

### 3. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 🔐 LoginController.php Features

### Fitur yang Sudah Diimplementasi:

1. **Login dengan Username** (bukan email)
2. **Role-based Redirect** setelah login:
   - Admin → `/admin/dashboard`
   - HR → `/hr/dashboard`
   - Manager → `/manager/dashboard`
   - Employee → `/employee/dashboard`
   - Default → `/dashboard`

3. **Security Features**:
   - Hanya user aktif yang bisa login (`is_active = true`)
   - Password hashing
   - Session management
   - Login attempt logging
   - Remember me functionality

4. **User Experience**:
   - Pesan sukses setelah login
   - Pesan error yang informatif dalam Bahasa Indonesia
   - Update timestamp last_login
   - Proper logout handling

## 🧪 Testing Login System

### 1. Test Otomatis
Jalankan file test:
```bash
# Via browser
http://localhost/blablabla/test_login_system.php

# Via command line
cd c:\xampp\htdocs\blablabla
php test_login_system.php
```

### 2. Test Manual Login

#### Akses Halaman Login:
```
http://localhost/blablabla/public/login
```

#### Test Credentials (setelah seeder dijalankan):
- **Admin User**:
  - Username: `admin`
  - Password: `password`
  - Redirect ke: `/admin/dashboard`

- **HR User**:
  - Username: `hr_user`
  - Password: `password`
  - Redirect ke: `/hr/dashboard`

- **Employee User**:
  - Username: `employee1`
  - Password: `password`
  - Redirect ke: `/employee/dashboard`

### 3. Test Logout
```
http://localhost/blablabla/public/logout
```

## 🔧 Troubleshooting

### Problem 1: "Database not found"
**Solusi:**
1. Pastikan database `employee` sudah dibuat di phpMyAdmin
2. Cek konfigurasi .env
3. Test koneksi: `php artisan tinker` → `DB::connection()->getPdo()`

### Problem 2: "Table doesn't exist"
**Solusi:**
```bash
php artisan migrate:fresh
php artisan db:seed
```

### Problem 3: "Route not found"
**Solusi:**
```bash
php artisan route:clear
php artisan route:cache
```

### Problem 4: "Class not found"
**Solusi:**
```bash
composer dump-autoload
php artisan config:clear
```

### Problem 5: Login gagal terus
**Solusi:**
1. Cek apakah user ada di database
2. Cek apakah `is_active = 1`
3. Cek password hash di database
4. Lihat log error: `storage/logs/laravel.log`

### Problem 6: Redirect tidak bekerja
**Solusi:**
1. Pastikan routes sudah didefinisikan di `routes/web.php`
2. Cek middleware di controller
3. Clear route cache: `php artisan route:clear`

## 📝 Struktur File Login System

```
app/Http/Controllers/Auth/
├── LoginController.php          # ✅ Main login controller
├── RegisterController.php       # Registration (if needed)
└── ...

resources/views/auth/
├── login.blade.php             # ✅ Login form
└── ...

routes/
├── web.php                     # ✅ Login routes defined

database/
├── migrations/                 # User table migration
└── seeders/                   # User data seeder
```

## 🎯 Next Steps

1. **Customize Dashboard Views**: Buat view untuk setiap role dashboard
2. **Add Registration**: Implement user registration jika diperlukan
3. **Password Reset**: Implement forgot password functionality
4. **User Management**: CRUD untuk manage users
5. **Middleware Enhancement**: Add more security middleware

## 📞 Support

Jika masih ada masalah:
1. Cek file log: `storage/logs/laravel.log`
2. Enable debug mode di .env: `APP_DEBUG=true`
3. Test step by step sesuai panduan ini
4. Pastikan semua service XAMPP running

---
**Happy Coding! 🚀**
