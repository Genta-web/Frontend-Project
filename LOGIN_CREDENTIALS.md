# 🔐 LOGIN CREDENTIALS - SISTEM MANAJEMEN KARYAWAN

## 📋 **Daftar User yang Valid di Database**

Berikut adalah daftar username dan password yang dapat digunakan untuk login ke sistem:

### 👨‍💼 **ADMIN USERS**
| Username | Password | Role | Status | Employee ID |
|----------|----------|------|--------|-------------|
| `admin_user` | `password` | admin | ✅ Active | 1 |

### 👥 **HR USERS**
| Username | Password | Role | Status | Employee ID |
|----------|----------|------|--------|-------------|
| `hr_user` | `password` | hr | ✅ Active | 2 |

### 👔 **MANAGER USERS**
| Username | Password | Role | Status | Employee ID |
|----------|----------|------|--------|-------------|
| `manager_user` | `password` | manager | ✅ Active | 3 |

### 👷 **EMPLOYEE USERS**
| Username | Password | Role | Status | Employee ID |
|----------|----------|------|--------|-------------|
| `employee_user` | `password` | employee | ✅ Active | 4 |
| `maylasafana` | `password` | employee | ✅ Active | 12 |
| `genta` | `password` | employee | ✅ Active | 13 |
| `Nurti` | `password` | employee | ✅ Active | 14 |
| `hakim` | `password` | employee | ✅ Active | 15 |

### 🔧 **SYSTEM USERS**
| Username | Password | Role | Status | Employee ID |
|----------|----------|------|--------|-------------|
| `system_user` | `password` | system | ✅ Active | NULL |
| `testuser` | `password` | employee | ✅ Active | NULL |

---

## 🧪 **Test Cases untuk Login**

### ✅ **Login yang BERHASIL:**
```
Username: admin_user
Password: password
Expected: Redirect ke Admin Dashboard
```

```
Username: hr_user
Password: password
Expected: Redirect ke HR Dashboard
```

```
Username: manager_user
Password: password
Expected: Redirect ke Manager Dashboard
```

```
Username: employee_user
Password: password
Expected: Redirect ke Employee Dashboard
```

```
Username: maylasafana
Password: password
Expected: Redirect ke Employee Dashboard
```

### ❌ **Login yang GAGAL:**

**1. Username tidak ditemukan:**
```
Username: nonexistent
Password: password
Expected Error: "Username tidak ditemukan dalam sistem."
```

**2. Password salah:**
```
Username: admin_user
Password: wrongpassword
Expected Error: "Password yang Anda masukkan salah."
```

**3. Username kosong:**
```
Username: (kosong)
Password: password
Expected Error: "Username wajib diisi."
```

**4. Password kosong:**
```
Username: admin_user
Password: (kosong)
Expected Error: "Password wajib diisi."
```

**5. Username terlalu pendek:**
```
Username: ab
Password: password
Expected Error: "Username minimal 3 karakter."
```

**6. Password terlalu pendek:**
```
Username: admin_user
Password: 123
Expected Error: "Password minimal 6 karakter."
```

---

## 🔒 **Security Features**

### **Rate Limiting:**
- Maksimal **5 percobaan login** per menit
- Setelah 5 kali gagal, akun akan di-lock selama 1 menit
- Error message: "Terlalu banyak percobaan login. Silakan coba lagi dalam X detik."

### **Input Validation:**
- Username: 3-50 karakter, hanya huruf, angka, titik, underscore, dash
- Password: minimal 6 karakter
- Semua input di-sanitasi untuk mencegah injection

### **Database Validation:**
- Cek eksistensi user di database
- Validasi status aktif (is_active = true)
- Verifikasi password dengan Hash::check()
- Validasi relasi employee (kecuali untuk admin)

---

## 🚀 **Cara Testing Login**

### **1. Manual Testing:**
1. Buka browser ke `/login`
2. Masukkan username dan password dari daftar di atas
3. Klik tombol "Login"
4. Verifikasi redirect dan pesan error

### **2. Automated Testing:**
```bash
# Test login berhasil
curl -X POST http://localhost/login \
  -d "username=admin_user&password=password" \
  -H "Content-Type: application/x-www-form-urlencoded"

# Test login gagal
curl -X POST http://localhost/login \
  -d "username=nonexistent&password=password" \
  -H "Content-Type: application/x-www-form-urlencoded"
```

---

## 📝 **Notes**

1. **Semua password default adalah `password`** (untuk testing)
2. **Username case-sensitive** (perhatikan huruf besar/kecil)
3. **System akan log semua percobaan login** (berhasil dan gagal)
4. **Admin tidak memerlukan employee record** untuk login
5. **Employee role memerlukan employee record** yang valid

---

## 🔧 **Troubleshooting**

### **Jika login tidak bekerja:**
1. Pastikan username dan password sesuai dengan daftar di atas
2. Cek apakah user masih aktif (is_active = true)
3. Untuk employee, pastikan ada employee record yang terkait
4. Cek log aplikasi untuk detail error
5. Pastikan tidak terkena rate limiting

### **Reset Password (jika diperlukan):**
```bash
php artisan tinker
>>> $user = App\Models\User::where('username', 'admin_user')->first();
>>> $user->password = Hash::make('newpassword');
>>> $user->save();
```

---

**Last Updated:** $(date)
**Database Status:** ✅ Connected and Verified
**Total Active Users:** 10
