<div class="row">
    <div class="col-md-6">
        <h6 class="text-primary border-bottom pb-2">Informasi Pegawai</h6>
        <table class="table table-borderless">
            <tr>
                <td width="40%"><strong>Nama</strong></td>
                <td><?= $ketidakhadiran['nama_pegawai'] ?></td>
            </tr>
            <tr>
                <td><strong>NIP</strong></td>
                <td><?= $ketidakhadiran['nip'] ?></td>
            </tr>
            <tr>
                <td><strong>Divisi</strong></td>
                <td><?= $ketidakhadiran['divisi'] ?></td>
            </tr>
            <tr>
                <td><strong>Jabatan</strong></td>
                <td><?= $ketidakhadiran['jabatan'] ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6 class="text-primary border-bottom pb-2">Informasi Ketidakhadiran</h6>
        <table class="table table-borderless">
            <tr>
                <td width="40%"><strong>Jenis</strong></td>
                <td><span class="badge bg-info"><?= ucfirst($ketidakhadiran['jenis_ketidakhadiran'] ?? 'izin') ?></span></td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td><?= date('d F Y', strtotime($ketidakhadiran['tanggal'])) ?></td>
            </tr>
            <tr>
                <td><strong>Keterangan</strong></td>
                <td><?= $ketidakhadiran['keterangan'] ?></td>
            </tr>
            <tr>
                <td><strong>Deskripsi</strong></td>
                <td><?= $ketidakhadiran['deskripsi'] ?></td>
            </tr>
            <?php if (!empty($ketidakhadiran['file'])): ?>
            <tr>
                <td><strong>File Lampiran</strong></td>
                <td>
                    <a href="<?= base_url('ketidakhadiran/download/' . $ketidakhadiran['file']) ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-download"></i> Download
                    </a>
                </td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-primary border-bottom pb-2">Status Verifikasi</h6>
        
        <!-- Status Kepala Bagian -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <strong>Verifikasi Kepala Bagian</strong>
                    </div>
                    <div class="col-md-2">
                        <?php 
                        $statusKepala = $ketidakhadiran['status_verifikasi_kepala'] ?? 'pending';
                        $badgeClass = $statusKepala == 'approved' ? 'bg-success' : ($statusKepala == 'rejected' ? 'bg-danger' : 'bg-warning');
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($statusKepala) ?></span>
                    </div>
                    <div class="col-md-3">
                        <?php if ($ketidakhadiran['verifikasi_kepala_nama']): ?>
                            <small class="text-muted">oleh: <?= $ketidakhadiran['verifikasi_kepala_nama'] ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php if ($ketidakhadiran['verifikasi_kepala_at']): ?>
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($ketidakhadiran['verifikasi_kepala_at'])) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($ketidakhadiran['catatan_kepala']): ?>
                <div class="row mt-2">
                    <div class="col-12">
                        <small><strong>Catatan:</strong> <?= $ketidakhadiran['catatan_kepala'] ?></small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Direktur -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <strong>Verifikasi Direktur</strong>
                    </div>
                    <div class="col-md-2">
                        <?php 
                        $statusDirektur = $ketidakhadiran['status_verifikasi_direktur'] ?? 'pending';
                        $badgeClass = $statusDirektur == 'approved' ? 'bg-success' : ($statusDirektur == 'rejected' ? 'bg-danger' : 'bg-warning');
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($statusDirektur) ?></span>
                    </div>
                    <div class="col-md-3">
                        <?php if ($ketidakhadiran['verifikasi_direktur_nama']): ?>
                            <small class="text-muted">oleh: <?= $ketidakhadiran['verifikasi_direktur_nama'] ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php if ($ketidakhadiran['verifikasi_direktur_at']): ?>
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($ketidakhadiran['verifikasi_direktur_at'])) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($ketidakhadiran['catatan_direktur']): ?>
                <div class="row mt-2">
                    <div class="col-12">
                        <small><strong>Catatan:</strong> <?= $ketidakhadiran['catatan_direktur'] ?></small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Akhir -->
        <div class="alert alert-info">
            <strong>Status Akhir: </strong>
            <?php 
            $statusAkhir = $ketidakhadiran['sttatus_pengajuan'];
            $badgeClass = strpos(strtolower($statusAkhir), 'disetujui') !== false ? 'bg-success' : 
                         (strpos(strtolower($statusAkhir), 'ditolak') !== false ? 'bg-danger' : 'bg-warning');
            ?>
            <span class="badge <?= $badgeClass ?>"><?= $statusAkhir ?></span>
        </div>
    </div>
</div>
