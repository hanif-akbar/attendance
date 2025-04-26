<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<style>
    .parent-clock{
        display: grid;
        grid-template-columns: auto auto auto auto auto;
        font-size: 35px;
        font-weight: bold;
        justify-content: center;
    }
    #map { 
        height: 500px;
        /* width: 500px; */
        margin: auto;
    }

</style>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Presensi Masuk</div>
            <?php if($checkPresensi < 1) : ?>
            <div class="card-body text-center">
                <div class="tanggal fw-bold"><?= date('d F Y')?></div>
                <div class="parent-clock">
                    <div id="jam-masuk"></div>
                    <div>:</div>
                    <div id="menit-masuk"></div>
                    <div>:</div>
                    <div id="detik-masuk"></div>
                </div>
                <!-- <input type="text" name="latitude_pegawai" id="latitude_pegawai">
                <input type="text" name="longitude_pegawai" id="longitude_pegawai" > -->
                <form method="POST" action="<?= base_url('pegawai/presensi_masuk') ?>">
                    <?php 
                    if ($clockInOut['zona_waktu'] == 'WIB'){
                        date_default_timezone_set('Asia/Jakarta');
                    }elseif ($clockInOut['zona_waktu'] == 'WITA'){
                        date_default_timezone_set('Asia/Makassar');
                    }elseif ($clockInOut['zona_waktu'] == 'WIT'){
                        date_default_timezone_set('Asia/Jayapura');
                    }
                    ?>


                    <input type="hidden" name="tanggal_masuk" value="<?= date('Y-m-d')?>">
                    <input type="hidden" name="jam_masuk" value="<?= date('H:i:s')?>">
                    <input type="hidden" name="id_pegawai" value="<?= session()->get('id_pegawai') ?>">
                    <input type="hidden" name="latitude_masuk" id="latitude_pegawai_masuk">
                    <input type="hidden" name="longitude_masuk" id="longitude_pegawai_masuk" >
                    <button class = "btn btn-primary mt-3"  >Masuk</button>
                </form>
            </div>
            <?php else : ?>
                <div class="card-body"><h4 class="text-center">Anda telah melakukan presensi masuk</h4></div>
            <?php endif; ?>
        </div>
    </div>
    <!-- <div class="col-md-4"><div class="card">
            <div class="card-header">Presensi Keluar</div>
            <div class="card-body text-center">
                <div class="tanggal fw-bold"><?= date('d F Y')?></div>
                <div class="parent-clock">
                    <div id="jam-keluar"></div>
                    <div>:</div>
                    <div id="menit-keluar"></div>
                    <div>:</div>
                    <div id="detik-keluar"></div>
                </div>
                <form method="POST" action="<?= base_url('pegawai/presensi_keluar/') ?>">
            

                    <input type="text" name="tanggal_keluar" value="<?= date('Y-m-d')?>">
                    <input type="text" name="jam_keluar" value="<?= date('H:i:s')?>">
                    <input type="text" name="id_pegawai" value="<?= session()->get('id_pegawai') ?>">
                    <input type="text" name="latitude_keluar" id="latitude_pegawai_keluar">
                    <input type="text" name="longitude_keluar" id="longitude_pegawai_keluar" >
                
                    <button class = "btn btn-danger mt-3"  >Keluar</button>
                </form>
            </div>
        </div></div> -->
    <div class="col-md-2"></div>
    <div class="col-md-8" id="map"></div>
</div>



<script>
    window.setInterval(waktuMasuk, 1000);

    function waktuMasuk(){
        const waktu = new Date();
        document.getElementById('jam-masuk').innerHTML = formatWaktu(waktu.getHours());
        document.getElementById('menit-masuk').innerHTML = formatWaktu(waktu.getMinutes());
        document.getElementById('detik-masuk').innerHTML = formatWaktu(waktu.getSeconds());
    }

    window.setInterval(waktuKeluar, 1000);

    function waktuKeluar(){
        const waktu = new Date();
        document.getElementById('jam-keluar').innerHTML = formatWaktu(waktu.getHours());
        document.getElementById('menit-keluar').innerHTML = formatWaktu(waktu.getMinutes());
        document.getElementById('detik-keluar').innerHTML = formatWaktu(waktu.getSeconds());
    }

    function formatWaktu(waktu){
        if(waktu < 10){
            return "0" + waktu;
        }else{
            return waktu;
        }
    }

    getLocation();

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        document.getElementById("latitude_pegawai_masuk").value = position.coords.latitude;
        document.getElementById("longitude_pegawai_masuk").value = position.coords.longitude;
        // document.getElementById("latitude_pegawai_keluar").value = position.coords.latitude;
        // document.getElementById("longitude_pegawai_keluar").value = position.coords.longitude;

        var map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map);
    }

</script>

<?= $this->endSection() ?>