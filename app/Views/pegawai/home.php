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
                    <input type="text" name="latitude_masuk" id="latitude_pegawai" required hidden>
                    <input type="text" name="longitude_masuk" id="longitude_pegawai" required hidden>
                    <button class = "btn btn-primary mt-3"  >Masuk</button>
                </form>
            </div>
            <?php else : ?>
                <div class="text-center"><svg style="color:green" xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                </div>
                <div class="card-body"><h4 class="text-center">Anda telah melakukan presensi masuk</h4></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-4"><div class="card">
            <div class="card-header">Presensi Keluar</div>
            <?php if($checkPresensi< 1 ) : ?>
                <div class="text-center"><svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                        <path d="M8.78362 8.78412C8.49073 9.07702 8.49073 9.55189 8.78362 9.84478L10.9388 12L8.78362 14.1552C8.49073 14.4481 8.49073 14.923 8.78362 15.2159C9.07652 15.5088 9.55139 15.5088 9.84428 15.2159L11.9995 13.0607L14.1546 15.2158C14.4475 15.5087 14.9224 15.5087 15.2153 15.2158C15.5082 14.9229 15.5082 14.448 15.2153 14.1551L13.0602 12L15.2153 9.84485C15.5082 9.55196 15.5082 9.07708 15.2153 8.78419C14.9224 8.4913 14.4475 8.4913 14.1546 8.78419L11.9995 10.9393L9.84428 8.78412C9.55139 8.49123 9.07652 8.49123 8.78362 8.78412Z" fill="#da486f"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM3.5 12C3.5 7.30558 7.30558 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C7.30558 20.5 3.5 16.6944 3.5 12Z" fill="#da486f"/>
                        </svg>
                </div>
                <div class="card-body"><h4 class="text-center">Anda belum melakukan presensi masuk</h4></div>
            <?php elseif($checkPresensiKeluar) : ?>
                <div class="text-center"><svg style="color:green" xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg></div>
                <div class="card-body"><h4 class="text-center">Anda telah melakukan presensi keluar</h4></div>
            <?php else : ?>
                <div class="card-body text-center">
                <div class="tanggal fw-bold"><?= date('d F Y')?></div>
                <div class="parent-clock">
                    <div id="jam-keluar"></div>
                    <div>:</div>
                    <div id="menit-keluar"></div>
                    <div>:</div>
                    <div id="detik-keluar"></div>
                </div>
                <form method="POST" action="<?= base_url('pegawai/presensi_keluar/' . $ambilPresensiMasuk['id']) ?>">
                    <?php 
                    if ($clockInOut['zona_waktu'] == 'WIB'){
                        date_default_timezone_set('Asia/Jakarta');
                    }elseif ($clockInOut['zona_waktu'] == 'WITA'){
                        date_default_timezone_set('Asia/Makassar');
                    }elseif ($clockInOut['zona_waktu'] == 'WIT'){
                        date_default_timezone_set('Asia/Jayapura');
                    }
                    ?>
                    <input type="hidden" name="tanggal_keluar" value="<?= date('Y-m-d')?>">
                    <input type="hidden" name="jam_keluar" value="<?= date('H:i:s')?>">
                    <input type="text" name="latitude_keluar" id="latitude_pegawai" required hidden>
                    <input type="text" name="longitude_keluar" id="longitude_pegawai"  required hidden>
                    <button class = "btn btn-danger mt-3"  >Keluar</button>
                </form>
                </div>
            <?php endif; ?>
        </div></div>
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

        

        // document.getElementById("latitude_pegawai_keluar").value = position.coords.latitude;
        // document.getElementById("longitude_pegawai_keluar").value = position.coords.longitude;
       
        document.getElementById("latitude_pegawai").value = position.coords.latitude;
        document.getElementById("longitude_pegawai").value = position.coords.longitude;
        
        var map = L.map('map').setView([latitude, longitude], 13);
        

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map);
    }

</script>

<?= $this->endSection() ?>