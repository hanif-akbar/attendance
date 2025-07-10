<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>

<a href="<?= base_url('admin/divisi/create')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Tambah Data</a>

<table class="table table-striped" id ="datatables">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Divisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php $no = 1; foreach ($divisi as $div) : ?>
        <tbody>
            <tr>
                <td>
                    <?= $no++ ?>
                </td>
                <td>
                    <?= $div['divisi'] ?>
                </td>
                <td>
                    <a href="<?= base_url('admin/divisi/edit/'.$div['id'])?>" class="badge bg-primary">Edit Data</a>
                    <a href="<?= base_url('admin/divisi/delete/'.$div['id'])?>" class="badge bg-danger tombol-hapus">Delete Data</a>
                </td>
            </tr>
        </tbody>
        <?php endforeach ?>
</table>

<?= $this->endSection()?>