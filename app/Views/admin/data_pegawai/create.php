<?= $this->extend('admin/layout.php')?>
<?= $this->section('content')?>
<div class="card col-md-6">
    <div class="card-body ">
    <form method="POST" action="<?= base_url('admin/data_pegawai/store')?>" enctype="multipart/form-data">
    
    <?= csrf_field() ?>
    
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">ID Pegawai</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('nip')) ? 'is-invalid' : '' ?>" placeholder="ID Pegawai" name="nip" value="<?= set_value('nip') ?>" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('nip')?></div>
            </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" placeholder="Nama" name="nama" value="<?= set_value('nama') ?>" id="inputText" >
                <div class="invalid-feedback"><?= $validation->getError('nama')?></div>
            </div>
    </div>
    <div class="input-style-1">
    <label>Jenis Kelamin</label>
    <div class="col-sm-10">
        <select name="jenis_kelamin" class="form-control <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '' ?>">
            <option value="">--Pilih Jenis Kelamin--</option>
            <option value="Laki-laki" <?= set_value('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
            <option value="Perempuan" <?= set_value('jenis_kelamin') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
        </select>
        <div class="invalid-feedback"><?= $validation->getError('jenis_kelamin')?></div>
        </div>
    </div>
    <div class="input-style-1">
    <label for="inputText" class="col-form-label">Alamat</label>
    <div class="col-sm-10">
        <textarea class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" 
                  placeholder="Alamat" 
                  name="alamat"
                  <?= set_value('alamat') ?> 
                  id="inputText"></textarea>
            <div class="invalid-feedback"><?= $validation->getError('alamat')?></div>
        </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">No.Handpone</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('no_handphone')) ? 'is-invalid' : '' ?>" placeholder="No Handpone" name="no_handphone" value="<?= set_value('no_handpone') ?>" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('no_handphone')?></div>
            </div>
    </div>
    <div class="input-style-1">
    <label>Jabatan</label>
    <div class="col-sm-10">
        <select name="jabatan" class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : '' ?>">
            <option value="">--Pilih Jabatan--</option>
            <?php foreach ($jabatan as $jab) : ?>
                <option value="<?= $jab['jabatan'] ?>"><?= $jab['jabatan'] ?></option>
                <?php endforeach ?>
        </select>
        <div class="invalid-feedback"><?= $validation->getError('jabatan')?></div>
        </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Foto</label>
            <div class="col-sm-10">
                <input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" name="foto" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('foto')?></div>
            </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Tanggal Lahir</label>
            <div class="col-sm-10">
                <input type="date" class="form-control <?= ($validation->hasError('tanggal_lahir')) ? 'is-invalid' : '' ?>" name="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('tanggal_lahir')?></div>
            </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Tanggal Masuk</label>
            <div class="col-sm-10">
                <input type="date" class="form-control <?= ($validation->hasError('tanggal_masuk')) ? 'is-invalid' : '' ?>" name="tanggal_masuk" value="<?= set_value('tanggal_masuk') ?>" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('tanggal_masuk')?></div>
            </div>
    </div>
    <div class="input-style-1">
    <label>Status Kepegawaian</label>
    <div class="col-sm-10">
    <select name="status" class="form-control <?= ($validation->hasError('status')) ? 'is-invalid' : '' ?>">
            <option value="">--Pilih Satus Kepegawaian--</option>
            <option value="Kontrak" <?= set_value('status') == 'Kontrak' ? 'selected' : '' ?>>Kontrak</option>
            <option value="Tetap" <?= set_value('status') == 'Tetap' ? 'selected' : '' ?>>Tetap</option>
            <option value="Non-Aktif"<?= set_value('status') == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
        </select>
        <div class="invalid-feedback"><?= $validation->getError('status')?></div>
        </div>
    </div>
    <div class="input-style-1">
    <label>Zona waktu Absensi</label>
    <div class="col-sm-10">
        <select name="clock_in_out_location" class="form-control <?= ($validation->hasError('clock_in_out_location')) ? 'is-invalid' : '' ?>">
            <option value="">--Pilih Jabatan--</option>
            <?php foreach ($clock_in_out_location as $clock) : ?>
                <option value="<?= $clock['id'] ?>"><?= $clock['id'] ?></option>
                <?php endforeach ?>
        </select>
        <div class="invalid-feedback"><?= $validation->getError('clock_in_out_location')?></div>
        </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" placeholder="Username" name="username" value="<?= set_value('username') ?>" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('username')?></div>
            </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" placeholder="Password" name="password" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('password')?></div>
            </div>
    </div>
    <div class="input-style-1">
        <label for="inputText" class="col-form-label">Konfirmasi Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>" placeholder="Konfirmasi Password" name="konfirmasi_password" id="inputText" >
                <div class = "invalid-feedback"><?= $validation->getError('konfirmasi_password')?></div>
            </div>
    </div>
    <div class="input-style-1">
    <label>Role</label>
    <div class="col-sm-10">
        <select name="role" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>">
            <option value="">--Pilih Role--</option>
            <option value="Pegawai" <?= set_value('role') == 'Pegawai' ? 'selected' : '' ?> >Pegawai</option>
            <option value="Admin" <?= set_value('role') == 'Admin' ? 'selected' : '' ?> >Admin</option>
        </select>
        <div class="invalid-feedback"><?= $validation->getError('role')?></div>
        </div>
    </div>

    <div class="mt-3 mb-4"><button class="btn btn-primary ">Simpan</button></div>
    </form>
    </div>
</div>

<?= $this->endSection()?>