<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>
<div class="card col-md-6">
    <div class="card-body ">
    <form method="POST" action="<?= base_url('admin/divisi/store') ?>">
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Nama Divisi</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('divisi')) ? 'is-invalid' : '' ?>" placeholder="Nama Divisi" name="divisi" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('divisi')?></div>
            </div>
    </div>

    <div class="mt-3 mb-4">
        <button class="btn btn-primary ">Simpan</button>
    </div>
    
    </form>
    </div>
</div>

<?= $this->endSection()?>