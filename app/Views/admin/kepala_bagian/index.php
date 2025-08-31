<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users-cog me-2"></i>
                        Kelola Kepala Bagian
                    </h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKepalaBagianModal">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Kepala Bagian
                    </button>
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
                                    <th>Jabatan</th>
                                    <th>Divisi yang Dipimpin</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($kepala_bagian): ?>
                                    <?php $no = 1; foreach ($kepala_bagian as $item): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $item['nama'] ?></td>
                                        <td><?= $item['nip'] ?></td>
                                        <td><?= $item['jabatan'] ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= $item['divisi'] ?></span>
                                        </td>
                                        <td>
                                            <?php if ($item['is_active']): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/kepala-bagian/remove/' . $item['id_pegawai']) ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus kepala bagian ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">Belum ada kepala bagian yang ditetapkan.</td>
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

<!-- Modal Tambah Kepala Bagian -->
<div class="modal fade" id="tambahKepalaBagianModal" tabindex="-1" aria-labelledby="tambahKepalaBagianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKepalaBagianModalLabel">Tambah Kepala Bagian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/kepala-bagian/set') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_pegawai" class="form-label">Pilih Pegawai</label>
                        <select class="form-select" id="id_pegawai" name="id_pegawai" required>
                            <option value="">-- Pilih Pegawai --</option>
                            <?php foreach ($pegawai as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?> (<?= $p['nip'] ?>) - <?= $p['jabatan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="divisi" class="form-label">Divisi yang Dipimpin</label>
                        <select class="form-select" id="divisi" name="divisi" required>
                            <option value="">-- Pilih Divisi --</option>
                            <?php foreach ($divisi as $d): ?>
                                <option value="<?= $d['divisi'] ?>"><?= $d['divisi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            <strong>Catatan:</strong> Jika divisi sudah memiliki kepala bagian, maka kepala bagian lama akan diganti dengan yang baru.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection()?>
