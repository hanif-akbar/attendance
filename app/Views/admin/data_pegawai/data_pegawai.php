<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>

<a href="<?= base_url('admin/data_pegawai/create')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Tambah Data</a>

<table class="table table-striped" id ="datatables">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Pegawai</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php $no = 1; foreach ($pegawai as $peg) : ?>
        <tbody>
            <tr>
                <td>
                    <?= $no++ ?>
                </td>
                <td><?= $peg['nip'] ?></td>
                <td><?= $peg['nama']?></td>
                <td><?= $peg['jabatan']?></td>
                <td><?= $peg['role']?></td>
                <td>
                    <a href="<?= base_url('admin/data_pegawai/detail/'.$peg['id'])?>" class="badge bg-primary">Detail</a>
                    <a href="<?= base_url('admin/data_pegawai/edit/'.$peg['id'])?>" class="badge bg-primary">Edit Data</a>
                    <a href="<?= base_url('admin/data_pegawai/delete/'.$peg['id'])?>" class="badge bg-danger tombol-hapus">Delete Data</a>
                </td>
            </tr>
        </tbody>
        <?php endforeach ?>
</table>

<?= $this->endSection()?>