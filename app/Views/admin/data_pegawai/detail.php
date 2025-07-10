<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>


<div class="card col-md-8">
    <div class="card-body">
        <div class="mt-3 mb-4">
            <img style="border-radius: 10px;" width="120px" src="<?= base_url('profile/' . $pegawai['foto']) ?>" alt="foto profile">
        </div>
        <table class="table">
            <tr>
                <td>ID Pegawai</td>
                <td>:</td>
                <td> <?=$pegawai['nip'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td> <?=$pegawai['nama'] ?> </td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td> <?=$pegawai['username'] ?> </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td> <?=$pegawai['jenis_kelamin'] ?> </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td> <?=$pegawai['alamat'] ?> </td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td> <?=$pegawai['tanggal_lahir'] ?> </td>
            </tr>
            <tr>
                <td>No Handphone</td>
                <td>:</td>
                <td> <?=$pegawai['no_handphone'] ?> </td>
            </tr>
            <tr>
                <td>Tanggal Masuk</td>
                <td>:</td>
                <td> <?=$pegawai['tanggal_masuk'] ?> </td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td> <?=$pegawai['jabatan'] ?> </td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>:</td>
                <td> <?=$pegawai['divisi'] ?> </td>
            </tr>
            <tr>
                <td>Status Kepegawaian</td>
                <td>:</td>
                <td> <?=$pegawai['status'] ?> </td>
            </tr>
            <tr>
                <td>Zona Waktu Absensi</td>
                <td>:</td>
                <td> <?=$pegawai['clock_in_out_location'] ?> </td>
            </tr>
            <tr>
                <td>Role</td>
                <td>:</td>
                <td> <?=$pegawai['role'] ?> </td>
            </tr>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

