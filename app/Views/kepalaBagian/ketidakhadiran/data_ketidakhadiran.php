<?= $this->extend('kepalaBagian/layout.php')?>
<?= $this->section('content')?>
<div class="mb-3">

<a href="<?= base_url('kepala_bagian/ketidakhadiran/create')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>ajukan</a>
<!-- <a href="<?= base_url('kepala_bagian/ketidakhadiran/izin')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>izin</a>
<a href="<?= base_url('kepala_bagian/ketidakhadiran/cuti')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>cuti</a> -->
</div>

<table class="table table-striped" id ="datatables">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Deskripsi</th>
            <th>File</th>
            <th>Status Verivikasi</th>
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
                <td><?= $ketidakhadiran['keterangan'] ?></td>
                <td><?= $ketidakhadiran['deskripsi'] ?></td>
                <td>
                    <?php if (!empty($ketidakhadiran['file'])): ?>
                        <a href="<?= base_url('ketidakhadiran/download/' . $ketidakhadiran['file']) ?>" class="badge bg-primary">Download</a>
                    <?php else: ?>
                        <span class="badge bg-secondary">No File</span>
                    <?php endif; ?>
                </td>
                <td><?= $ketidakhadiran['sttatus_pengajuan'] ?></td>
                <td>
                    <a href="<?= base_url('kepala_bagian/ketidakhadiran/edit/' . $ketidakhadiran['id']) ?>" class="badge bg-primary">Edit</a>
                    <a href="<?= base_url('kepala_bagian/ketidakhadiran/delete/' . $ketidakhadiran['id']) ?>" class="badge bg-danger tombol-hapus">Delete</a>
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