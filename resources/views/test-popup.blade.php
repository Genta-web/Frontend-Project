@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Test Popup</div>
                <div class="card-body">
                    <h5>Test SweetAlert2 Popup</h5>
                    <p>Klik tombol di bawah untuk menguji popup:</p>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" onclick="testLoginSuccess()">
                            Test Login Success Popup
                        </button>

                        <button type="button" class="btn btn-info" onclick="testAlert()">
                            Test Alert Popup
                        </button>

                        <button type="button" class="btn btn-warning" onclick="testConfirm()">
                            Test Confirm Popup
                        </button>

                        <button type="button" class="btn btn-danger" onclick="testError()">
                            Test Error Popup
                        </button>

                        <button type="button" class="btn btn-outline-danger" onclick="testDeleteConfirm()">
                            Test Delete Confirmation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function testLoginSuccess() {
        if (typeof window.triggerLoginSuccess === 'function') {
            window.triggerLoginSuccess('Login berhasil! Selamat datang kembali.');
        } else {
            alert('Function triggerLoginSuccess tidak ditemukan!');
        }
    }

    function testAlert() {
        if (typeof window.showAlert === 'function') {
            window.showAlert('Informasi', 'Ini adalah popup informasi.', 'info');
        } else {
            alert('Function showAlert tidak ditemukan!');
        }
    }

    function testConfirm() {
        if (typeof window.showConfirm === 'function') {
            window.showConfirm(
                'Konfirmasi',
                'Apakah Anda yakin ingin melanjutkan?',
                function() {
                    window.showAlert('Berhasil', 'Anda memilih Ya!', 'success');
                }
            );
        } else {
            alert('Function showConfirm tidak ditemukan!');
        }
    }

    function testError() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan dalam sistem.',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'slide-fade-in'
                }
            });
        } else {
            alert('SweetAlert2 tidak ter-load!');
        }
    }

    function testDeleteConfirm() {
        if (typeof window.confirmDelete === 'function') {
            // Test dengan URL dummy (tidak akan benar-benar menghapus)
            window.confirmDelete('Employee John Doe', '#');
        } else {
            alert('Function confirmDelete tidak ditemukan!');
        }
    }
</script>
@endpush
