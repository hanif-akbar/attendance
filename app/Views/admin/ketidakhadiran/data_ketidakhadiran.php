<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>
<table class="table table-striped" id ="datatables">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Pegawai</th>
            <th>Nama Pegawai</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Deskripsi</th>
            <th>File</th>
            <th>Status Verifikasi Atasan</th>
            <th>Status Verivikasi HR</th>
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
                <td><?= $ketidakhadiran['nip'] ?></td>
                <td><?= $ketidakhadiran['nama_pegawai'] ?></td>
                <td><?= $ketidakhadiran['tanggal'] ?></td>
                <td><?= $ketidakhadiran['keterangan'] ?></td>
                <td><?= $ketidakhadiran['deskripsi'] ?></td>
                <td>
                    <?php if (!empty($ketidakhadiran['file'])): ?>
                        <a href="<?= base_url('ketidakhadiran/download/' . $ketidakhadiran['file']) ?>" class="badge bg-primary">Download</a>
                        <?php else: ?>
                            <span class="badge bg-secondary">No File</span>
                            <?php endif; ?>
                        </td>
                <td></td>
                <td><?php if ($ketidakhadiran['sttatus_pengajuan'] == "Pending") :?>
                    <span class="badge bg-warning">Pending</span>
                <?php elseif ($ketidakhadiran['sttatus_pengajuan'] == "Disetujui") : ?>
                    <span class="badge bg-success">Disetujui</span>
                <?php elseif ($ketidakhadiran['sttatus_pengajuan'] == "Ditolak") : ?>
                <span class="badge bg-danger">Ditolak</span>
                <?php endif; ?></td>
                <td>
                    <a href="<?= base_url('admin/approved_ketidakhadiran/' . $ketidakhadiran['id']) ?>" class="badge bg-success">Approve</a>
                    <a href="<?= base_url('admin/rejected_ketidakhadiran/' . $ketidakhadiran['id']) ?>" class="badge bg-danger">Reject</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                        <td colspan="7" class="text-center py-7">Belum ada data Pengajuan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        
</table>

<?= $this->endSection()?>