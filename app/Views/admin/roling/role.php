<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Atasan & Bawahan</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal">
            <i class="fas fa-plus"></i> Tambah Relasi
        </button>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="row">
        <!-- Current Relationships -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Relasi Atasan - Bawahan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Atasan</th>
                                    <th>Jabatan Atasan</th>
                                    <th>Bawahan</th>
                                    <th>Jabatan Bawahan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($roles) && !empty($roles)): ?>
                                    <?php $no = 1; foreach ($roles as $role): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <div class="icon-circle bg-primary">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold"><?= esc($role['nama_atasan']) ?></div>
                                                        <div class="text-muted small">NIP: <?= esc($role['nip_atasan']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= esc($role['jabatan_atasan']) ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <div class="icon-circle bg-success">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold"><?= esc($role['nama_bawahan']) ?></div>
                                                        <div class="text-muted small">NIP: <?= esc($role['nip_bawahan']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= esc($role['jabatan_bawahan']) ?></td>
                                            <td>
                                                <?php if ($role['status'] == 'aktif'): ?>
                                                    <span class="badge badge-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editRole(<?= $role['id'] ?>)" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteRole(<?= $role['id'] ?>)" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data relasi atasan-bawahan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Relasi Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($stats['total_aktif']) ? $stats['total_aktif'] : 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Atasan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($stats['total_atasan']) ? $stats['total_atasan'] : 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>

                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Bawahan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($stats['total_bawahan']) ? $stats['total_bawahan'] : 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <button class="btn btn-outline-primary btn-block mb-2" onclick="viewPendingApprovals()">
                        <i class="fas fa-clock"></i> Lihat Persetujuan Pending
                    </button>
                    <button class="btn btn-outline-success btn-block mb-2" onclick="exportData()">
                        <i class="fas fa-download"></i> Export Data
                    </button>
                    <button class="btn btn-outline-info btn-block" onclick="importData()">
                        <i class="fas fa-upload"></i> Import Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Relasi Atasan - Bawahan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addRoleForm" action="<?= base_url('admin/role/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="atasan_id"><strong>Pilih Atasan</strong></label>
                                <select class="form-control select2" id="atasan_id" name="atasan_id" required>
                                    <option value="">-- Pilih Atasan --</option>
                                    <?php if (isset($pegawai_atasan)): ?>
                                        <?php foreach ($pegawai_atasan as $atasan): ?>
                                            <option value="<?= $atasan['id'] ?>">
                                                <?= esc($atasan['nama']) ?> - <?= esc($atasan['jabatan']) ?> (<?= esc($atasan['nip']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bawahan_id"><strong>Pilih Bawahan</strong></label>
                                <select class="form-control select2" id="bawahan_id" name="bawahan_id[]" multiple required>
                                    <option value="">-- Pilih Bawahan --</option>
                                    <?php if (isset($pegawai_bawahan)): ?>
                                        <?php foreach ($pegawai_bawahan as $bawahan): ?>
                                            <option value="<?= $bawahan['id'] ?>">
                                                <?= esc($bawahan['nama']) ?> - <?= esc($bawahan['jabatan']) ?> (<?= esc($bawahan['nip']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <small class="form-text text-muted">Anda dapat memilih lebih dari satu bawahan</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_mulai"><strong>Tanggal Mulai</strong></label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_selesai"><strong>Tanggal Selesai</strong></label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                                <small class="form-text text-muted">Kosongkan jika tidak ada batas waktu</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan"><strong>Keterangan</strong></label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Masukkan keterangan relasi (opsional)"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                            <label class="custom-control-label" for="status">Aktifkan relasi</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Relasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Relasi Atasan - Bawahan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editRoleForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_role_id" name="role_id">
                    <!-- Form fields similar to add modal -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_atasan_id"><strong>Pilih Atasan</strong></label>
                                <select class="form-control" id="edit_atasan_id" name="atasan_id" required>
                                    <!-- Options will be populated via AJAX -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_bawahan_id"><strong>Pilih Bawahan</strong></label>
                                <select class="form-control" id="edit_bawahan_id" name="bawahan_id" required>
                                    <!-- Options will be populated via AJAX -->
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="edit_status" name="status" value="1">
                            <label class="custom-control-label" for="edit_status">Aktifkan relasi</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Relasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Initialize Select2
    $('.select2').select2({
        dropdownParent: $('#addRoleModal')
    });
});

function editRole(roleId) {
    // AJAX call to get role data
    $.ajax({
        url: '<?= base_url('admin/role/get/') ?>' + roleId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#edit_role_id').val(response.data.id);
                $('#edit_atasan_id').val(response.data.atasan_id);
                $('#edit_bawahan_id').val(response.data.bawahan_id);
                $('#edit_status').prop('checked', response.data.status == 1);
                $('#editRoleForm').attr('action', '<?= base_url('admin/role/update/') ?>' + roleId);
                $('#editRoleModal').modal('show');
            }
        },
        error: function() {
            Swal.fire('Error!', 'Gagal mengambil data role', 'error');
        }
    });
}

function deleteRole(roleId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Relasi ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('admin/role/delete/') ?>' + roleId,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', 'Relasi berhasil dihapus', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Gagal menghapus relasi', 'error');
                }
            });
        }
    });
}

function viewPendingApprovals() {
    window.location.href = '<?= base_url('admin/approval/pending') ?>';
}

function exportData() {
    window.location.href = '<?= base_url('admin/role/export') ?>';
}

function importData() {
    // Implement import functionality
    Swal.fire('Info', 'Fitur import sedang dalam pengembangan', 'info');
}

// Form validation
$('#addRoleForm').on('submit', function(e) {
    const atasanId = $('#atasan_id').val();
    const bawahanId = $('#bawahan_id').val();
    
    if (atasanId && bawahanId && atasanId === bawahanId) {
        e.preventDefault();
        Swal.fire('Error!', 'Atasan dan bawahan tidak boleh sama', 'error');
        return false;
    }
});
</script>

<?= $this->endSection()?>