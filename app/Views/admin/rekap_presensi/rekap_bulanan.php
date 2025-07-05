<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<form class="row g-3">
  <div class="col-auto">
    <input type="month" class="form-control" name="filter_bulan" value="<?= isset($_GET['filter_bulan']) ? $_GET['filter_bulan'] : date('Y-m') ?>" id="filter_bulan" placeholder="Tanggal" >
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Tampilkan</button>
  </div>
</form>
    
<table class = "table table-striped table-bordered">
    <tr>
        <th>No</th>
        <th>Nama pegawai</th>
        <th>Tanggal</th>
        <th>Total Jam Kerja</th>
        <th>Total Keterlambatan</th>
        <th>Koordinat Masuk</th>
        <th>Koordinat Keluar</th>
    </tr>

    <?php if ($rekap_bulanan) : ?>
    <?php $no=1; foreach ($rekap_bulanan as $rekap) : ?>
        <?php
            //Menghitung Total Jam Kerja
            $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk']. $rekap['jam_masuk']);
            $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar']. $rekap['jam_keluar']);

            $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
            $jam = floor($selisih / 3600);
            $selisih -= $jam * 3600;
            $menit = floor($selisih / 60);

            // Menghitug Total Keterlambatan
            $jam_masuk_real = strtotime($rekap['jam_masuk']);
            $jam_masuk_kantor = strtotime($rekap['jam_masuk_office']);
            $selisih_keterlambatan = $jam_masuk_real - $jam_masuk_kantor;
            $jam_terlambat = floor($selisih_keterlambatan / 3600);
            $selisih_keterlambatan -= $jam_terlambat * 3600;
            $menit_terlambat = floor($selisih_keterlambatan / 60);
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $rekap['nama'] ?></td>
            <td><?= date('d F Y',strtotime($rekap['tanggal_masuk'])) ?></td>
            <td><?php if ($rekap['jam_keluar'] == '00:00:00') :?>
                    0 Jam 0 Menit
                <?php else : ?>
                    <?= $jam .' Jam '. $menit.' Menit ' ?>
                <?php endif; ?></td>
            <td><?php if ($jam_terlambat<0 || $menit_terlambat<0) :?>
                    <span class="text-success">Tidak Terlambat</span>
                <?php else : ?>
                    <span class="text-danger"><?= sprintf('%02d Jam %02d Menit', abs($jam_terlambat), abs($menit_terlambat)) ?></span>
                <?php endif; ?></td>
            <td><?= $rekap['latitude_masuk']?>,<?= $rekap['longitude_masuk']?></td>
            <td><?= $rekap['latitude_keluar']?>,<?= $rekap['longitude_keluar']?></td>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7" class="text-center">Data tidak ditemukan</td>
        </tr>
    <?php endif; ?>
    </table>
    

<?= $this->endSection() ?>