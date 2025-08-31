<?= $this->extend('direktur/layout.php') ?>

<?= $this->section('content') ?>

<form class="row g-3">
  <div class="col-auto">
    <input type="date" class="form-control" name="filter_tanggal" value="<?= isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : date('Y-m-d') ?>" id="filter_tanggal" placeholder="Tanggal" >
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Tampilkan</button>
  </div>
</form>

<div class="card col-md-8 mx-auto">
    <div class="card-body">
        <h5 class="card-title mb-3">Detail Presensi</h5> <table class="table table-bordered table-striped" style="margin-top: 20px;"> <tbody>
                <?php if ($rekap_presensi) : ?>
                    <?php foreach ($rekap_presensi as $rekap) : ?>
                        <?php
                           

                            // Menghitung Total Keterlambatan
                            $jam_masuk_real = strtotime($rekap['jam_masuk']);
                            $jam_masuk_kantor = strtotime($rekap['jam_masuk_office']);
                            $selisih_keterlambatan = $jam_masuk_real - $jam_masuk_kantor;
                            $jam_terlambat = floor($selisih_keterlambatan / 3600);
                            $menit_terlambat = floor(($selisih_keterlambatan % 3600) / 60);
                        ?>

                        <tr>
                            <td style="width: 30%; font-weight: bold;">Tanggal</td>
                            <td style="width: 5%; font-weight: bold;">:</td>
                            <td><?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Jam Masuk</td>
                            <td style="font-weight: bold;">:</td>
                            <td><?= $rekap['jam_masuk'] ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Jam Keluar</td>
                            <td style="font-weight: bold;">:</td>
                            <td><?= $rekap['jam_keluar'] ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Keterlambatan</td>
                            <td style="font-weight: bold;">:</td>
                            <td>
                                <?php if ($selisih_keterlambatan > 0) : ?>
                                    <span class="text-danger"><?= sprintf('%02d Jam %02d Menit', abs($jam_terlambat), abs($menit_terlambat)) ?></span>
                                <?php else : ?>
                                    <span class="text-success">Tidak Terlambat</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Koordinat Masuk</td>
                            <td style="font-weight: bold;">:</td>
                            <td><?= $rekap['latitude_masuk'] ?>, <?= $rekap['longitude_masuk'] ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Koordinat Keluar</td>
                            <td style="font-weight: bold;">:</td>
                            <td><?= $rekap['latitude_keluar'] ?>, <?= $rekap['longitude_keluar'] ?></td>
                        </tr>
                        <?php if (next($rekap_presensi)) : ?>
                            <tr><td colspan="3"><hr style="border-top: 1px dashed #ccc;"></td></tr> <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3" class="text-center py-4">Data presensi tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
    

<?= $this->endSection() ?>