<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>

<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-people-fill text-primary me-2"></i>
            Data Pegawai
        </h1>
        <p class="text-muted mb-0">Kelola data pegawai dan akun pengguna</p>
    </div>
    <a href="<?= base_url('admin/data_pegawai/create')?>" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Pegawai
    </a>
</div>

<!-- Search Section -->
<div class="card shadow mb-4">
    <div class="card-body py-4">
        <form method="GET" action="<?= current_url() ?>" class="row g-3 align-items-end">
            <div class="col-md-9">
                <label for="searchInput" class="form-label fw-semibold text-dark mb-2">
                    <i class="bi bi-search text-primary me-1"></i>Pencarian Data Pegawai
                </label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" 
                           id="searchInput"
                           class="form-control border-start-0 ps-0" 
                           name="search" 
                           placeholder="Ketik nama, NIP, jabatan, divisi, atau role untuk mencari..." 
                           value="<?= esc($search ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2 d-md-flex">
                    <button class="btn btn-primary btn-lg flex-fill shadow-sm" type="submit">
                        <i class="bi bi-search me-2"></i>Cari Data
                    </button>
                    <?php if ($search): ?>
                        <a href="<?= base_url('admin/data_pegawai') ?>" 
                           class="btn btn-outline-secondary btn-lg shadow-sm" 
                           title="Reset Pencarian">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Search Results Info -->
<?php if ($search): ?>
    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
            <div>
                <strong>Hasil Pencarian:</strong> "<?= esc($search) ?>" 
                <span class="badge bg-info ms-2"><?= count($pegawai) ?> data ditemukan</span>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Main Table Card -->
<div class="card shadow border-0">
    <div class="card-header bg-gradient-primary text-white">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold">
                <i class="bi bi-table me-2"></i>
                Daftar Pegawai
            </h6>
            <small class="opacity-75">
                <?= $search ? count($pegawai) : ($pager ? $pager->getTotal() : count($pegawai)) ?> total pegawai
            </small>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover no-datatables mb-0" id="datatables">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 60px;">
                            <i class="bi bi-hash"></i>
                        </th>
                        <th style="width: 120px;">
                            <i class="bi bi-credit-card me-1"></i>NIP
                        </th>
                        <th>
                            <i class="bi bi-person me-1"></i>Pegawai
                        </th>
                        <th style="width: 150px;">
                            <i class="bi bi-briefcase me-1"></i>Jabatan
                        </th>
                        <th style="width: 130px;">
                            <i class="bi bi-building me-1"></i>Divisi
                        </th>
                        <th class="text-center" style="width: 100px;">
                            <i class="bi bi-shield me-1"></i>Role
                        </th>
                        <th class="text-center" style="width: 140px;">
                            <i class="bi bi-gear me-1"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <?php if (empty($pegawai)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon mb-3">
                                        <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">
                                        <?= $search ? 'Tidak Ada Hasil' : 'Belum Ada Data' ?>
                                    </h5>
                                    <p class="text-muted mb-3">
                                        <?= $search ? 'Tidak ada pegawai yang cocok dengan pencarian Anda.' : 'Belum ada data pegawai yang terdaftar.' ?>
                                    </p>
                                    <?php if (!$search): ?>
                                        <a href="<?= base_url('admin/data_pegawai/create') ?>" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>Tambah Pegawai Pertama
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $no = 1;
                        if (isset($pager) && $pager) {
                            $currentPage = (int) (service('request')->getGet('page') ?? 1);
                            $perPage = 10;
                            $no = (($currentPage - 1) * $perPage) + 1;
                        }
                        foreach ($pegawai as $peg) : 
                        ?>
                            <tr class="align-middle">
                                <td class="text-center">
                                    <span class="badge bg-light text-dark fw-normal"><?= $no++ ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6 font-monospace"><?= esc($peg['nip']) ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-container me-3">
                                            <?php if (!empty($peg['foto'])): ?>
                                                <img src="<?= base_url('profile/' . $peg['foto']) ?>" 
                                                     class="rounded-circle border border-2 border-light shadow-sm" 
                                                     width="45" height="45" 
                                                     alt="Foto <?= esc($peg['nama']) ?>"
                                                     style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-gradient-secondary rounded-circle border border-2 border-light shadow-sm d-flex align-items-center justify-content-center" 
                                                     style="width: 45px; height: 45px;">
                                                    <i class="bi bi-person-fill text-white fs-5"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark"><?= esc($peg['nama']) ?></div>
                                            <small class="text-muted">
                                                <i class="bi bi-gender-<?= strtolower($peg['jenis_kelamin']) === 'laki-laki' ? 'male' : 'female' ?> me-1"></i>
                                                <?= esc($peg['jenis_kelamin']) ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-gradient text-white fs-6">
                                        <?= esc($peg['jabatan']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success bg-gradient text-white fs-6">
                                        <?= esc($peg['divisi']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($peg['role'] === 'admin'): ?>
                                        <span class="badge bg-danger bg-gradient fs-6">
                                            <i class="bi bi-shield-fill-check me-1"></i>Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary bg-gradient fs-6">
                                            <i class="bi bi-person-badge me-1"></i>Pegawai
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="<?= base_url('admin/data_pegawai/detail/'.$peg['id']) ?>" 
                                           class="btn btn-outline-info btn-sm" 
                                           title="Lihat Detail"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="<?= base_url('admin/data_pegawai/edit/'.$peg['id']) ?>" 
                                           class="btn btn-outline-warning btn-sm" 
                                           title="Edit Data"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="<?= base_url('admin/data_pegawai/delete/'.$peg['id']) ?>" 
                                           class="btn btn-outline-danger btn-sm tombol-hapus" 
                                           title="Hapus Data"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination Section -->
<?php if (isset($pager) && $pager && !$search): ?>
    <div class="card shadow border-0 mt-5">
        <div class="card-body py-4">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="bi bi-info-circle text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Informasi Data</p>
                            <p class="mb-0 fw-semibold">
                                Menampilkan <span class="text-primary"><?= count($pegawai) ?></span> dari 
                                <span class="text-success"><?= $pager->getTotal() ?></span> total pegawai
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Pagination Navigation" class="d-flex justify-content-md-end justify-content-center">
                        <div class="pagination-wrapper">
                            <?php if (isset($pager)): ?>
                                <?= $pager->links() ?>
                            <?php endif; ?>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Custom Styles -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
}

/* Enhanced search input styling */
.input-group-lg .form-control {
    border-radius: 0.5rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.input-group-lg .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.input-group-lg .input-group-text {
    border: 2px solid #e9ecef;
    border-radius: 0.5rem 0 0 0.5rem;
    background-color: #f8f9fa;
}

/* Pagination wrapper styling */
.pagination-wrapper {
    margin-bottom: 0;
}

.pagination-wrapper .pagination {
    margin-bottom: 0;
}

.pagination-wrapper .page-link {
    border-radius: 0.5rem;
    margin: 0 2px;
    border: 1px solid #dee2e6;
    color: #495057;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-link:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    transform: translateY(-1px);
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
}

/* Card spacing improvements */
.card {
    border-radius: 1rem;
    border: none;
}

.card-body {
    padding: 1.5rem;
}

.card.shadow {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.card.shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    transition: box-shadow 0.3s ease-in-out;
}

.empty-state {
    padding: 2rem 1rem;
}

.empty-state-icon {
    opacity: 0.6;
}

.avatar-container img,
.avatar-container div {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.avatar-container img:hover,
.avatar-container div:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05) !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.card {
    border-radius: 0.75rem;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
}

.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
}

.table thead th {
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-responsive table,
    .table-responsive thead,
    .table-responsive tbody,
    .table-responsive th,
    .table-responsive td,
    .table-responsive tr {
        display: block;
    }
    
    .table-responsive thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    
    .table-responsive tr {
        border: 1px solid #ccc;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table-responsive td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    
    .table-responsive td:before {
        content: attr(data-label);
        position: absolute;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        color: #333;
    }
}

/* Tooltip styling */
.tooltip {
    font-size: 0.75rem;
}

/* Animation for loading states */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.table tbody tr {
    animation: fadeIn 0.3s ease-in-out;
}
</style>

<!-- JavaScript for enhanced interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add data-label attributes for responsive table
    const table = document.querySelector('#datatables');
    if (table) {
        const headers = table.querySelectorAll('thead th');
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    cell.setAttribute('data-label', headers[index].textContent.trim());
                }
            });
        });
    }
    
    // Smooth scroll to top when pagination changes
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }, 100);
        });
    });
});
</script>

<?= $this->endSection()?>