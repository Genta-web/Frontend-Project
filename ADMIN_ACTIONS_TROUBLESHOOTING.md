# Admin Actions Troubleshooting Guide

## 🔧 Masalah yang Diperbaiki

### 1. **Admin Tidak Dapat Approve/Reject**
**Masalah:** Admin tidak memiliki akses ke tombol approve/reject
**Solusi:** 
- ✅ Mengubah kondisi permission dari `!Auth::user()->isEmployee()` ke `Auth::user()->hasRole(['admin', 'hr', 'manager'])`
- ✅ Menambahkan admin action panel yang prominent di halaman show
- ✅ Memastikan tombol approve/reject menggunakan enhanced JavaScript service

### 2. **Modal Conflict**
**Masalah:** Modal lama konflik dengan modal baru dari JavaScript service
**Solusi:**
- ✅ Menghapus modal lama dari index.blade.php dan show.blade.php
- ✅ Menggunakan enhanced modal dari LeaveActionsService

### 3. **JavaScript Service Tidak Terinisialisasi**
**Masalah:** Global functions tidak dapat mengakses service
**Solusi:**
- ✅ Menambahkan error handling di global functions
- ✅ Memberikan pesan error yang jelas jika service tidak tersedia

## 🎯 Implementasi yang Dilakukan

### **File yang Diupdate:**

1. **`resources/views/leave/show.blade.php`**
   - ✅ Mengubah kondisi permission untuk admin actions
   - ✅ Menambahkan admin action panel yang prominent
   - ✅ Menghapus modal lama yang konflik

2. **`resources/views/leave/index.blade.php`**
   - ✅ Mengupdate tombol approve/reject untuk menggunakan JavaScript service
   - ✅ Menghapus modal lama yang konflik

3. **`public/js/leave-actions.js`**
   - ✅ Menambahkan error handling di global functions
   - ✅ Memberikan feedback yang jelas jika service tidak tersedia

## 🚀 Cara Menggunakan (Admin)

### **Di Halaman Index (`/leave`):**
1. Admin akan melihat tombol **APPROVE** dan **REJECT** untuk setiap pending request
2. Klik **APPROVE** untuk membuka enhanced approval modal dengan templates
3. Klik **REJECT** untuk membuka enhanced rejection modal dengan templates

### **Di Halaman Show (`/leave/{id}`):**
1. Admin akan melihat **Admin Action Panel** yang prominent di bagian atas
2. Panel ini hanya muncul untuk pending requests dan admin/hr/manager
3. Tombol besar **Approve Request** dan **Reject Request** tersedia
4. Juga ada tombol kecil di header untuk akses cepat

## 🔍 Testing Checklist

### **Untuk Admin/HR/Manager:**
- [ ] Login sebagai admin/hr/manager
- [ ] Buka halaman `/leave` 
- [ ] Pastikan tombol APPROVE/REJECT muncul untuk pending requests
- [ ] Klik tombol APPROVE - harus membuka enhanced modal
- [ ] Klik tombol REJECT - harus membuka enhanced modal dengan templates
- [ ] Buka detail leave request (`/leave/{id}`)
- [ ] Pastikan Admin Action Panel muncul di bagian atas
- [ ] Test approve dan reject dari halaman detail

### **Untuk Employee:**
- [ ] Login sebagai employee
- [ ] Pastikan tidak melihat tombol admin actions
- [ ] Hanya melihat tombol Edit/Delete untuk request sendiri yang pending

## 🎨 UI Improvements

### **Admin Action Panel (Show Page):**
```html
<!-- Panel prominent dengan background blur dan shadow -->
<div class="alert alert-warning border-0 shadow-lg mb-4" 
     style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h5>⚡ Admin Action Required</h5>
            <p>This leave request from Employee is pending your review</p>
        </div>
        <div>
            <button class="btn btn-success btn-lg">Approve Request</button>
            <button class="btn btn-danger btn-lg">Reject Request</button>
        </div>
    </div>
</div>
```

### **Enhanced Buttons (Index Page):**
```html
<!-- Tombol dengan enhanced JavaScript service -->
<button onclick="approveLeave('id', {data})" class="btn btn-success btn-sm">
    <i class="fas fa-check me-1"></i><strong>APPROVE</strong>
</button>
<button onclick="showRejectModal('id', 'name', 'type')" class="btn btn-danger btn-sm">
    <i class="fas fa-times me-1"></i><strong>REJECT</strong>
</button>
```

## 🔧 Troubleshooting

### **Jika Tombol Tidak Muncul:**
1. **Check User Role:**
   ```php
   // Pastikan user memiliki role yang benar
   Auth::user()->hasRole(['admin', 'hr', 'manager'])
   ```

2. **Check Leave Status:**
   ```php
   // Pastikan leave request masih pending
   $leave->isPending() // harus return true
   ```

3. **Check Browser Console:**
   - Buka Developer Tools (F12)
   - Check console untuk error JavaScript
   - Pastikan `leave-actions.js` ter-load dengan benar

### **Jika Modal Tidak Muncul:**
1. **Check JavaScript Service:**
   ```javascript
   // Di browser console, check:
   console.log(window.leaveActions); // harus ada object
   ```

2. **Check Bootstrap:**
   ```javascript
   // Pastikan Bootstrap JavaScript ter-load
   console.log(bootstrap); // harus ada object
   ```

3. **Check Error Messages:**
   - Jika muncul alert "System error: Leave actions service not available"
   - Refresh halaman dan pastikan JavaScript ter-load

### **Jika Approve/Reject Tidak Berfungsi:**
1. **Check CSRF Token:**
   ```javascript
   // Pastikan CSRF token valid
   console.log(window.leaveActions.csrfToken);
   ```

2. **Check Routes:**
   ```php
   // Pastikan routes tersedia
   Route::post('/leave/{leave}/approve', [LeaveController::class, 'approve']);
   Route::post('/leave/{leave}/reject', [LeaveController::class, 'reject']);
   ```

3. **Check Permissions di Controller:**
   ```php
   // Di LeaveController, pastikan permission check berfungsi
   LeavePermissionHelper::validateAction(Auth::user(), $leave, 'approve');
   ```

## 📞 Support

Jika masih ada masalah:
1. Check browser console untuk error JavaScript
2. Check Laravel logs untuk error server-side
3. Pastikan user login dengan role admin/hr/manager
4. Pastikan leave request masih dalam status pending

## ✅ Expected Behavior

### **Admin Experience:**
1. **Login** → Dashboard
2. **Navigate** → Leave Management
3. **See** → Pending requests dengan tombol APPROVE/REJECT
4. **Click APPROVE** → Enhanced modal dengan templates dan custom message
5. **Click REJECT** → Enhanced modal dengan templates, alternatives, dan follow-up actions
6. **Submit** → Email notification ke employee + redirect dengan success message

### **Employee Experience:**
1. **Receive** → Professional email notification
2. **Email contains** → Decision, admin message, next steps
3. **For rejections** → Alternative suggestions dan follow-up actions
4. **Can view** → Updated status di leave management system
