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


<input type="hidden"id="jam_keluar" name="jam_keluar" value="<?= $jam_keluar ?>">
<input type="hidden"id="tanggal_keluar" name="tanggal_keluar" value="<?= $tanggal_keluar ?>">
<input type="hidden"id="latitude_keluar" name="latitude_keluar" value="<?= $latitude_keluar ?>">
<input type="hidden"id="longitude_keluar" name="longitude_keluar" value="<?= $longitude_keluar ?>">

<div id = "my_camera"></div>
<div style="display: none" id = "my_result"></div>

<button class="btn btn-danger" id="ambil-foto-keluar">Keluar</button>

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

    document.getElementById('ambil-foto-keluar').addEventListener('click', function() {
        let jam_keluar = document.getElementById('jam_keluar').value;
        let tanggal_keluar = document.getElementById('tanggal_keluar').value;
        let latitude_keluar = document.getElementById('latitude_keluar').value;
        let longitude_keluar = document.getElementById('longitude_keluar').value;

        // console.log(id_pegawai, jam_masuk, tanggal_masuk, latitude_masuk, longitude_masuk);

        Webcam.snap(function(data_uri) {
            document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"/>';

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    window.location.href = "<?= base_url('kepala_bagian/dashboard') ?>"; // Fixed typo in window
                }
            };

            xhr.open("POST", "<?= base_url('kepala_bagian/presensi_keluar_aksi/' . $id_presensi) ?>", true); // Fixed PHP tag
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(
                'foto_keluar=' + encodeURIComponent(data_uri) +
                '&jam_keluar=' + jam_keluar +
                '&tanggal_keluar=' + tanggal_keluar +
                '&latitude_keluar=' + latitude_keluar +
                '&longitude_keluar=' + longitude_keluar
            );
            console.log(encodeURIComponent(data_uri));
        });
    });
</script>

<?= $this->endSection() ?>
