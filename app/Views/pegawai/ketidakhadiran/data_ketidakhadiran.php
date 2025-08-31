<?= $this->extend('pegawai/layout.php')?>
<?= $this->section('content')?>
<div class="mb-3">

<a href="<?= base_url('pegawai/ketidakhadiran/create')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>ajukan</a>
<!-- <a href="<?= base_url('pegawai/ketidakhadiran/izin')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>izin</a>
<a href="<?= base_url('pegawai/ketidakhadiran/cuti')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>cuti</a> -->
</div>

<table class="table table-striped" id ="datatables">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Deskripsi</th>
            <th>File</th>
            <th>Status Kepala Bagian</th>
            <th>Status Direktur</th>
            <th>Status Akhir</th>
            <th>Aksi</th>
        </tr>
    </thead>
        <tbody>
            <?php if($ketidakhadiran) : ?>
            <?php $no = 1; foreach ($ketidakhadiran as $ketidakhadiran): ?>
            <tr>
                <td>
                  <?= $no++ ?>  
                </td>
                <td><?= $ketidakhadiran['tanggal'] ?></td>
                <td>
                    <span class="badge bg-info"><?= ucfirst($ketidakhadiran['jenis_ketidakhadiran'] ?? 'izin') ?></span>
                </td>
                <td><?= $ketidakhadiran['keterangan'] ?></td>
                <td><?= $ketidakhadiran['deskripsi'] ?></td>
                <td>
                    <?php if (!empty($ketidakhadiran['file'])): ?>
                        <a href="<?= base_url('ketidakhadiran/download/' . $ketidakhadiran['file']) ?>" class="badge bg-primary">Download</a>
                        <?php else: ?>
                            <span class="badge bg-secondary">No File</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $statusKepala = $ketidakhadiran['status_verifikasi_kepala'] ?? 'pending';
                            $badgeClass = $statusKepala == 'approved' ? 'bg-success' : ($statusKepala == 'rejected' ? 'bg-danger' : 'bg-warning');
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($statusKepala) ?></span>
                            <?php if ($ketidakhadiran['verifikasi_kepala_at']): ?>
                                <br><small class="text-muted"><?= date('d/m/Y H:i', strtotime($ketidakhadiran['verifikasi_kepala_at'])) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $statusDirektur = $ketidakhadiran['status_verifikasi_direktur'] ?? 'pending';
                            $badgeClass = $statusDirektur == 'approved' ? 'bg-success' : ($statusDirektur == 'rejected' ? 'bg-danger' : 'bg-warning');
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($statusDirektur) ?></span>
                            <?php if ($ketidakhadiran['verifikasi_direktur_at']): ?>
                                <br><small class="text-muted"><?= date('d/m/Y H:i', strtotime($ketidakhadiran['verifikasi_direktur_at'])) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $statusAkhir = $ketidakhadiran['sttatus_pengajuan'];
                            $badgeClass = strpos(strtolower($statusAkhir), 'disetujui') !== false ? 'bg-success' : 
                                         (strpos(strtolower($statusAkhir), 'ditolak') !== false ? 'bg-danger' : 'bg-warning');
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $statusAkhir ?></span>
                        </td>
                <td>
                    <a href="<?= base_url('pegawai/ketidakhadiran/edit/' . $ketidakhadiran['id']) ?>" class="badge bg-primary">Edit</a>
                    <a href="<?= base_url('pegawai/ketidakhadiran/delete/' . $ketidakhadiran['id']) ?>" class="badge bg-danger tombol-hapus">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                        <td colspan="10" class="text-center py-7">Belum ada data Pengajuan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        
</table>

<?= $this->endSection()?>