<?= $this->extend('direktur/layout.php') ?>

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

                    <form id="changeUsernameForm" method="post" action="<?= base_url('direktur/ubah_username_auth') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="current_username" class="form-label">Username Saat Ini <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="current_username" name="current_username" value="<?= session()->get('username') ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password untuk Konfirmasi <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text">Masukkan password Anda untuk konfirmasi perubahan username</div>
                        </div>

                        <div class="mb-3">
                            <label for="new_username" class="form-label">Username Baru <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="new_username" name="new_username" required minlength="3" maxlength="50" pattern="[a-zA-Z0-9._-]+">
                            <div class="form-text">Username harus minimal 3 karakter, hanya boleh menggunakan huruf, angka, titik, underscore, dan dash</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_username" class="form-label">Konfirmasi Username Baru <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="confirm_username" name="confirm_username" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-edit me-2"></i>Ubah Username
                            </button>
                            <a href="<?= base_url('direktur/dashboard') ?>" class="btn btn-secondary">
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
    const changeUsernameForm = document.getElementById('changeUsernameForm');
    const newUsernameInput = document.getElementById('new_username');
    const confirmUsernameInput = document.getElementById('confirm_username');

    // Sweet Alert for form submission confirmation
    changeUsernameForm.addEventListener('submit', function(e) {
        // Mencegah submit default form untuk melakukan konfirmasi SweetAlert
        e.preventDefault(); 

        const newUsername = newUsernameInput.value;
        const confirmUsername = confirmUsernameInput.value;

        if (newUsername !== confirmUsername) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username baru dan konfirmasi username tidak cocok!',
            });
            confirmUsernameInput.focus();
            return false;
        }

        // Validasi format username
        const usernamePattern = /^[a-zA-Z0-9._-]+$/;
        if (!usernamePattern.test(newUsername)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Username Salah',
                text: 'Username hanya boleh menggunakan huruf, angka, titik, underscore, dan dash!',
            });
            newUsernameInput.focus();
            return false;
        }

        if (newUsername.length < 3) {
            Swal.fire({
                icon: 'error',
                title: 'Username Terlalu Pendek',
                text: 'Username harus minimal 3 karakter!',
            });
            newUsernameInput.focus();
            return false;
        }

        Swal.fire({
            title: "Yakin Ubah Username?",
            text: "Username yang sudah diubah akan digunakan untuk login selanjutnya!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, ubah!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user mengkonfirmasi, baru submit form secara manual
                changeUsernameForm.submit(); 
            }
        });
    });

    // Real-time username match validation
    confirmUsernameInput.addEventListener('input', function() {
        const newUsername = newUsernameInput.value;
        const confirmUsername = this.value;
        
        if (confirmUsername && newUsername !== confirmUsername) {
            this.setCustomValidity('Username tidak cocok');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
            if (confirmUsername && newUsername === confirmUsername) {
                this.classList.add('is-valid');
            }
        }
    });

    newUsernameInput.addEventListener('input', function() {
        // Clear validity of confirm username when new username changes
        confirmUsernameInput.setCustomValidity('');
        confirmUsernameInput.classList.remove('is-invalid');
        confirmUsernameInput.classList.remove('is-valid');
        
        // Validate format real-time
        const usernamePattern = /^[a-zA-Z0-9._-]+$/;
        if (this.value && !usernamePattern.test(this.value)) {
            this.setCustomValidity('Username hanya boleh menggunakan huruf, angka, titik, underscore, dan dash');
            this.classList.add('is-invalid');
        } else if (this.value.length > 0 && this.value.length < 3) {
            this.setCustomValidity('Username harus minimal 3 karakter');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
            if (this.value.length >= 3) {
                this.classList.add('is-valid');
            }
        }
    });

}); // End DOMContentLoaded
</script>
<?= $this->endSection() ?>