<?= $this->extend('direktur/layout.php') ?>

<?= $this->section('content') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
    #my_camera {
        width: 320px;
        height: 240px;
        border: 1px solid #ccc;
        margin: 20px auto;
    }
        /* #my_result {
            width: 320px;
            height: 240px;
            margin: 20px auto;
        } */
</style>

<input type="hidden"id="id_pegawai" name="id_pegawai" value="<?= $id_pegawai ?>">
<input type="hidden"id="jam_masuk" name="jam_masuk" value="<?= $jam_masuk ?>">
<input type="hidden"id="tanggal_masuk" name="tanggal_masuk" value="<?= $tanggal_masuk ?>">
<input type="hidden"id="latitude_masuk" name="latitude_masuk" value="<?= $latitude_masuk ?>">
<input type="hidden"id="longitude_masuk" name="longitude_masuk" value="<?= $longitude_masuk ?>">

<div id = "my_camera"></div>
<div style="display: none" id = "my_result"></div>

<button class="btn btn-primary" id="ambil-foto">masuk</button>

<script>
    // Initialize webcam
    Webcam.set({
        width: 320,
        height: 240,
        dest_width: 320,
        dest_height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90,
        force_flash: false
    });

    // Make sure camera is attached after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        Webcam.attach('#my_camera');
    });

    document.getElementById('ambil-foto').addEventListener('click', function() {
        let id_pegawai = document.getElementById('id_pegawai').value;
        let jam_masuk = document.getElementById('jam_masuk').value;
        let tanggal_masuk = document.getElementById('tanggal_masuk').value;
        let latitude_masuk = document.getElementById('latitude_masuk').value;
        let longitude_masuk = document.getElementById('longitude_masuk').value;

        // console.log(id_pegawai, jam_masuk, tanggal_masuk, latitude_masuk, longitude_masuk);

        Webcam.snap(function(data_uri) {
            document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"/>';

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    window.location.href = "<?= base_url('direktur/dashboard') ?>"; // Fixed typo in window
                }
            };

            xhr.open("POST", "<?= base_url('direktur/presensi_masuk_aksi') ?>", true); // Fixed PHP tag
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(
                'foto_masuk=' + encodeURIComponent(data_uri) +
                '&id_pegawai=' + id_pegawai + // Fixed variable name
                '&jam_masuk=' + jam_masuk +
                '&tanggal_masuk=' + tanggal_masuk +
                '&latitude_masuk=' + latitude_masuk +
                '&longitude_masuk=' + longitude_masuk
            );
            console.log(encodeURIComponent(data_uri));
        });
    });
</script>

<?= $this->endSection() ?>
