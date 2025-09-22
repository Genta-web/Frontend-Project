# 🌱 Panduan Seeder Employee Management System

## 📋 Daftar Seeder yang Tersedia

### 1. `EmployeeDataSeeder.php`
Seeder utama yang berisi data sesuai dengan `employee_db.sql`:
- 4 data karyawan (EMP001 - EMP004)
- 5 data user dengan role berbeda
- Password yang mudah diingat: `password123`

### 2. `TestDataSeeder.php` 
Seeder alternatif dengan hash password yang sama seperti di database asli

## 🚀 Cara Menjalankan Seeder

### Opsi 1: Jalankan Seeder Utama
```bash
php artisan db:seed --class=EmployeeDataSeeder
```

### Opsi 2: Jalankan Semua Seeder
```bash
php artisan db:seed
```

### Opsi 3: Reset Database + Seeder
```bash
php artisan migrate:fresh --seed
```

## 👥 Data yang Di-seed

### 📊 Data Karyawan
| ID | Kode | Nama | Email | Department | Position | Status |
|----|------|------|-------|------------|----------|--------|
| 1 | EMP001 | John Admin | john.admin@example.com | IT | Administrator | Active |
| 2 | EMP002 | Sarah HR | sarah.hr@example.com | HR | HR Officer | Active |
| 3 | EMP003 | Michael Manager | michael.manager@example.com | Sales | Sales Manager | Active |
| 4 | EMP004 | Lisa Employee | lisa.employee@example.com | Support | Customer Support | Active |

### 🔐 Data User Login
| ID | Username | Password | Role | Employee ID |
|----|----------|----------|------|-------------|
| 1 | admin_user | password123 | admin | 1 |
| 2 | hr_user | password123 | hr | 2 |
| 3 | manager_user | password123 | manager | 3 |
| 4 | employee_user | password123 | employee | 4 |
| 5 | system_user | password123 | system | null |

## 🎯 Akses Berdasarkan Role

### 👑 Admin (admin_user)
- ✅ Akses penuh ke semua fitur
- ✅ CRUD karyawan
- ✅ Dashboard admin
- ✅ Manajemen user

### 👔 HR (hr_user)
- ✅ Lihat dan tambah karyawan
- ✅ Dashboard HR
- ❌ Edit/hapus karyawan (hanya admin)

### 📊 Manager (manager_user)
- ✅ Lihat data karyawan
- ✅ Dashboard manager
- ❌ CRUD karyawan

### 👤 Employee (employee_user)
- ✅ Dashboard employee
- ❌ Akses manajemen karyawan

## 🔧 Troubleshooting

### Error: Table doesn't exist
```bash
# Jalankan migration terlebih dahulu
php artisan migrate
```

### Error: Duplicate entry
```bash
# Reset database
php artisan migrate:fresh --seed
```

### Password tidak bisa login
Pastikan menggunakan password: `password123`

## 📝 Catatan Penting

1. **Auto Increment**: Seeder akan set auto increment ke nilai yang benar
   - employees: AUTO_INCREMENT = 9
   - users: AUTO_INCREMENT = 6

2. **Truncate**: Seeder akan menghapus data lama sebelum insert data baru

3. **Timestamps**: Menggunakan timestamp yang sama seperti di database asli

4. **Password Hash**: Menggunakan Laravel Hash::make() untuk keamanan

## 🎉 Setelah Seeding

1. Jalankan server:
   ```bash
   php artisan serve
   ```

2. Buka browser: `http://localhost:8000`

3. Login dengan salah satu akun di atas

4. Mulai gunakan sistem Employee Management!

---

💡 **Tips**: Gunakan akun `admin_user` untuk testing lengkap semua fitur sistem!
