<?= $this->extend('kepalaBagian/layout.php') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4"><?= esc($title) ?></h2>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form id="changePasswordForm" method="post" action="<?= base_url('kepala_bagian/ubah_password_auth') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Password Lama <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                            <div class="form-text">Password minimal 8 karakter.</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
                            <a href="<?= base_url('kepala_bagian/dashboard') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Pastikan DOM sudah siap sebelum menjalankan script
document.addEventListener('DOMContentLoaded', function() {
    const changePasswordForm = document.getElementById('changePasswordForm');
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    // Sweet Alert for form submission confirmation
    // Kita akan pasang event listener di form-nya, bukan di tombolnya
    changePasswordForm.addEventListener('submit', function(e) {
        // Mencegah submit default form untuk melakukan konfirmasi SweetAlert
        e.preventDefault(); 

        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password baru dan konfirmasi password tidak cocok!',
            });
            confirmPasswordInput.focus();
            return false;
        }

        Swal.fire({
            title: "Yakin Ubah Password?",
            text: "Password yang sudah di ubah harap di ingat!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user mengkonfirmasi, baru submit form secara manual
                changePasswordForm.submit(); 
            }
        });
    });

    // Real-time password match validation (ini sudah bagus)
    confirmPasswordInput.addEventListener('input', function() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = this.value;
        
        if (confirmPassword && newPassword !== confirmPassword) {
            this.setCustomValidity('Password tidak cocok');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
            this.classList.add('is-valid'); // Opsional: tambahkan valid jika cocok
        }
    });

    newPasswordInput.addEventListener('input', function() {
        // Clear validity of confirm password when new password changes
        confirmPasswordInput.setCustomValidity('');
        confirmPasswordInput.classList.remove('is-invalid');
        confirmPasswordInput.classList.remove('is-valid');
    });

}); // End DOMContentLoaded
</script>
<?= $this->endSection() ?>