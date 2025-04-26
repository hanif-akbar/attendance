<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>
<div class="card col-md-6">
    <div class="card-body ">
    <form method="POST" action="<?= base_url('admin/jabatan/update/'. $jabatan['id']) ?>">
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Nama Jabatan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : '' ?>" placeholder="Nama Jabatan" name="jabatan" value="<?= $jabatan['jabatan']?>" >
            </div>
            <div class = "invalid-feedback"><?= $validation->getError('jabatan')?></div>
    </div>

    <button class="btn btn-primary ">Update</button>
    </form>
    </div>
</div>

<?= $this->endSection()?>