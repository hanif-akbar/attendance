<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Divisi</h4>
    <a href="<?= base_url('admin/divisi/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Data
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle" id ="datatables">
        <thead class="table-dark">
            <tr>
                <th scope="col" style="width: 5%;">No</th>
                <th scope="col">Nama Divisi</th>
                <th scope="col" style="width: 20%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($divisi as $div) : ?>
                <tr>
                    <td class="text-center">
                        <?= $no++ ?>
                    </td>
                    <td>
                        <?= esc($div['divisi']) ?>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="<?= base_url('admin/divisi/edit/'.$div['id']) ?>" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="<?= base_url('admin/divisi/delete/'.$div['id']) ?>" 
                               class="btn btn-sm btn-danger tombol-hapus" title="Hapus">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection()?>