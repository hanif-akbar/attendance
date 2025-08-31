<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        Verifikasi Ketidakhadiran
                    </h5>
                    <?php if ($role === 'admin'): ?>
                    <a href="<?= base_url('admin/kepala-bagian') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-users-cog me-1"></i>
                        Kelola Kepala Bagian
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="datatables">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>NIP</th>
                                    <th>Divisi</th>
                                    <th>Jabatan</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Status Kepala</th>
                                    <th>Status Direktur</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($ketidakhadiran): ?>
                                    <?php $no = 1; foreach ($ketidakhadiran as $item): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $item['nama_pegawai'] ?></td>
                                        <td><?= $item['nip'] ?></td>
                                        <td><?= $item['divisi'] ?></td>
                                        <td><?= $item['jabatan'] ?></td>
                                        <td>
                                            <span class="badge bg-info"><?= ucfirst($item['jenis_ketidakhadiran'] ?? 'izin') ?></span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                                        <td><?= $item['keterangan'] ?></td>
                                        <td>
                                            <?php 
                                            $statusKepala = $item['status_verifikasi_kepala'] ?? 'pending';
                                            $badgeClass = $statusKepala == 'approved' ? 'bg-success' : ($statusKepala == 'rejected' ? 'bg-danger' : 'bg-warning');
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($statusKepala) ?></span>
                                        </td>
                                        <td>
                                            <?php 
                                            $statusDirektur = $item['status_verifikasi_direktur'] ?? 'pending';
                                            $badgeClass = $statusDirektur == 'approved' ? 'bg-success' : ($statusDirektur == 'rejected' ? 'bg-danger' : 'bg-warning');
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($statusDirektur) ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-info btn-sm" onclick="showDetail(<?= $item['id'] ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <?php if (($role === 'kepala_bagian' && $statusKepala === 'pending') || 
                                                         ($role === 'direktur' && $statusDirektur === 'pending') ||
                                                         ($role === 'admin' && $statusDirektur === 'pending')): ?>
                                                <button type="button" class="btn btn-success btn-sm" onclick="showVerifikasiModal(<?= $item['id'] ?>, 'approved')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="showVerifikasiModal(<?= $item['id'] ?>, 'rejected')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="11" class="text-center py-4">Tidak ada data untuk diverifikasi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Ketidakhadiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/verifikasi-ketidakhadiran/verifikasi') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id" id="verifikasi_id">
                    <input type="hidden" name="status" id="verifikasi_status">
                    <?php if ($role === 'admin'): ?>
                    <input type="hidden" name="verifikasi_type" value="direktur">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Verifikasi</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan verifikasi..."></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <p class="mb-0" id="verifikasi_message"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="verifikasi_submit">Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Ketidakhadiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detail_content">
                    <!-- Detail content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showVerifikasiModal(id, status) {
    document.getElementById('verifikasi_id').value = id;
    document.getElementById('verifikasi_status').value = status;
    
    const message = status === 'approved' ? 
        'Anda akan menyetujui pengajuan ketidakhadiran ini.' : 
        'Anda akan menolak pengajuan ketidakhadiran ini.';
    
    document.getElementById('verifikasi_message').textContent = message;
    document.getElementById('verifikasi_submit').textContent = status === 'approved' ? 'Setujui' : 'Tolak';
    document.getElementById('verifikasi_submit').className = status === 'approved' ? 'btn btn-success' : 'btn btn-danger';
    
    new bootstrap.Modal(document.getElementById('verifikasiModal')).show();
}

function showDetail(id) {
    fetch(`<?= base_url('admin/verifikasi-ketidakhadiran/detail') ?>/${id}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('detail_content').innerHTML = data;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading detail');
        });
}
</script>

<?= $this->endSection()?>
