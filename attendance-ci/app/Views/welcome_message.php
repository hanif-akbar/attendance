<?= $this->extend('layout.php') ?>

<?= $this->section('content') ?>
    

<?= $this->endSection() ?>

<style>
    .parent-clock{
        display: grid;
        grid-template-columns: auto auto auto auto auto;
        font-size: 25px;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-2">1</div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Presensi Masuk</div>
            <div class="card-body text-center">
                <div class="tanggal fw-bold"><?= date('d F Y')?></div>
                <div class="parent-clock">
                    <div id="jam-masuk">00</div>
                    <div>:</div>
                    <div id="menit-masuk">00</div>
                    <div>:</div>
                    <div id="detik-masuk">00</div>
                </div>
                <button onclick="getLocation()">Try It</button>

                <p id="masuk"></p>
                <form action="">
                    <button class="btn btn-primary">Masuk</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Presensi Masuk</div>
            <div class="card-body text-center">
                <div class="tanggal fw-bold"><?= date('d F Y')?></div>
                <div class="parent-clock">
                    <div id="jam-keluar">00</div>
                    <div>:</div>
                    <div id="menit-keluar">00</div>
                    <div>:</div>
                    <div id="detik-keluar">00</div>
                </div>
                <button onclick="getLocation()">Try It</button>

                <p id="keluar"></p>
                <form action="">
                    <button class="btn btn-primary">Keluar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2">4</div>
</div>

<script>
    function updateClock() {
        const time = new Date();
        document.getElementById("jam-masuk").innerHTML = (time.getHours());
        document.getElementById("menit-masuk").innerHTML = (time.getMinutes());
        document.getElementById("detik-masuk").innerHTML = (time.getSeconds());
    }
    // Update clock check every second
    setInterval(updateClock, 1000);
    // Initial call to display time immediately
    updateClock();


    const x = document.getElementById("masuk");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success, error);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function success(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;
}

function error() {
  alert("Sorry, no position available.");
}
</script>