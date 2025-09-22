# Panduan Penggunaan Popup (SweetAlert2)

## Setup yang Sudah Dilakukan

1. **SweetAlert2** sudah diinstall via npm
2. **Vite configuration** sudah diatur untuk compile JavaScript dan CSS
3. **Custom functions** sudah dibuat di `resources/js/app.js`
4. **Custom styling** sudah ditambahkan di `resources/css/app.css`

## Cara Menggunakan Popup

### 1. Login Success Popup
```javascript
// Dari JavaScript
window.triggerLoginSuccess('Pesan login berhasil');

// Dari Blade template (sudah diimplementasi di login.blade.php)
@if(session('success'))
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.triggerLoginSuccess === 'function') {
                    window.triggerLoginSuccess(@json(session('success')));
                }
            }, 100);
        });
    </script>
@endif
```

### 2. Alert Popup Umum
```javascript
// Info popup
window.showAlert('Judul', 'Pesan informasi', 'info');

// Success popup
window.showAlert('Berhasil', 'Operasi berhasil dilakukan', 'success');

// Error popup
window.showAlert('Error', 'Terjadi kesalahan', 'error');

// Warning popup
window.showAlert('Peringatan', 'Harap perhatikan', 'warning');
```

### 3. Confirmation Popup
```javascript
window.showConfirm('Konfirmasi', 'Apakah Anda yakin?', function() {
    // Callback function yang dijalankan jika user klik "Ya"
    console.log('User mengkonfirmasi');
    // Lakukan aksi yang diinginkan
});
```

### 4. Custom SweetAlert2
```javascript
Swal.fire({
    title: 'Custom Popup',
    text: 'Ini adalah popup custom',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'OK',
    cancelButtonText: 'Batal',
    customClass: {
        popup: 'slide-fade-in'
    }
}).then((result) => {
    if (result.isConfirmed) {
        // User klik OK
    }
});
```

## Testing

1. **Jalankan Vite development server:**
   ```bash
   npm run dev
   ```

2. **Akses halaman test:**
   ```
   http://localhost/blablabla/test-popup
   ```

3. **Test melalui login:**
   - Login dengan akun yang valid
   - Popup success akan muncul otomatis

## Troubleshooting

### Popup tidak muncul:
1. Pastikan Vite development server berjalan (`npm run dev`)
2. Buka Developer Tools (F12) dan cek Console untuk error
3. Pastikan SweetAlert2 ter-load dengan benar
4. Cek apakah function `window.triggerLoginSuccess` tersedia

### Styling tidak sesuai:
1. Pastikan CSS custom sudah ter-compile
2. Refresh halaman dengan Ctrl+F5
3. Cek apakah animasi CSS sudah ter-load

### Function tidak ditemukan:
1. Pastikan `resources/js/app.js` sudah di-import di layout
2. Tunggu sampai DOM ready sebelum memanggil function
3. Gunakan `setTimeout` untuk delay eksekusi

## File yang Terlibat

- `resources/js/app.js` - JavaScript functions
- `resources/css/app.css` - Custom styling dan animasi
- `resources/views/layouts/app.blade.php` - Layout utama
- `resources/views/auth/login.blade.php` - Implementasi di login
- `resources/views/test-popup.blade.php` - Halaman test
- `vite.config.js` - Konfigurasi build
- `package.json` - Dependencies
