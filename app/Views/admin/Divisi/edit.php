<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>
<div class="card col-md-6">
    <div class="card-body ">
    <form method="POST" action="<?= base_url('admin/divisi/update/'. $divisi['id']) ?>">
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Nama Divisi</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('divisi')) ? 'is-invalid' : '' ?>" placeholder="Nama Divisi" name="divisi" value="<?= $divisi['divisi']?>" >
            </div>
            <div class = "invalid-feedback"><?= $validation->getError('divisi')?></div>
    </div>

    <button class="btn btn-primary ">Update</button>
    </form>
    </div>
</div>

<?= $this->endSection()?>