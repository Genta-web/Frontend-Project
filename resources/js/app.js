import './bootstrap';
import Swal from 'sweetalert2';

// Pastikan DOM sudah siap
document.addEventListener('DOMContentLoaded', function () {
    console.log('SweetAlert2 loaded:', typeof Swal);
});

// Fungsi global yang bisa dipanggil dari Blade
window.triggerLoginSuccess = function (message) {
    console.log('triggerLoginSuccess called with message:', message);

    Swal.fire({
        title: 'Login Berhasil!',
        text: message,
        icon: 'success',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        customClass: {
            popup: 'slide-fade-in'
        },
        didOpen: () => {
            const popup = Swal.getPopup();
            if (popup) {
                popup.classList.add('slide-fade-in');
            }
        }
    }).then(() => {
        console.log('SweetAlert popup closed');
    });
};

// Fungsi untuk popup umum
window.showAlert = function (title, message, icon = 'info') {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        confirmButtonText: 'OK',
        customClass: {
            popup: 'slide-fade-in'
        }
    });
};


// Fungsi untuk konfirmasi
window.showConfirm = function (title, message, callback) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'slide-fade-in'
        }
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
};

// Fungsi untuk konfirmasi delete
window.confirmDelete = function (itemName, deleteUrl) {
    Swal.fire({
        title: 'Hapus Data?',
        text: `Apakah Anda yakin ingin menghapus ${itemName}? Data yang dihapus tidak dapat dikembalikan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        customClass: {
            popup: 'slide-fade-in'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Create and submit form for DELETE request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }

            // Add method spoofing for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
};
