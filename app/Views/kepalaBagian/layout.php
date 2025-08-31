<!DOCTYPE html>
<html lang="en">

<html>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $title?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/favicon-rpm.png') ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/quill/quill.snow.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/quill/quill.bubble.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/remixicon/remixicon.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/simple-datatables/style.css')?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

  <!-- Leaflate CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

  <!-- Learlate js -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>


     
  
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?= base_url('') ?>" class="logo d-flex align-items-center">
        <img src="<?= base_url('assets/img/logo-rpm.png') ?>" alt="">
        <span class="d-none d-lg-block">PT.RIAPUTRA METALINDO</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class=""></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?= base_url('assets/img/profile-img.jpg') ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= session()->get('nama') ? session()->get('nama') : session()->get('username') ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= session()->get('username') ?></h6>
              <span><?= session()->get('role') ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('kepala_bagian/ubah_username') ?>">
                <i class="bi bi-person-fill"></i>
                <span>Ubah Username</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('kepala_bagian/ubah_password') ?>">
                <i class="bi bi-gear"></i>
                <span>Ubah Password</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout') ?> ">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?= base_url('kepala_bagian/dashboard')?>">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      
      <!-- <li class="nav-heading">Presensi</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-database"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Data Jabatan</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Data Pegawai</span>
            </a>
          </li> -->
          <!-- <li>
            <a href="components-badges.html">
              <i class="bi bi-circle"></i><span>Data lokasi Presensi</span>
            </a>
          </li> -->
        <!-- </ul>
      </li> -->
      <!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-table"></i><span>Rekap Presensi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= base_url('kepala_bagian/rekap_presensi') ?>">
              <i class="bi bi-circle"></i><span>Rekap Presensi</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('kepala_bagian/ketidakhadiran') ?>">
              <i class="bi bi-circle"></i><span>Ketidakhadiran</span>
            </a>
          </li>
          <!-- <li>
            <a href="forms-editors.html">
              <i class="bi bi-circle"></i><span>Rekap Bulanan</span>
            </a>
          </li> -->
        </ul>
      </li>
      <!-- End Forms Nav -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-x-fill"></i></i><span>Ketidakhadiran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="tables-general.html">
              <i class="bi bi-circle"></i><span>Sakit & Izin</span>
            </a>
          </li>
          <li>
            <a href="tables-data.html">
              <i class="bi bi-circle"></i><span>Cuti</span>
            </a>
          </li>
        </ul>
      </li> -->
      <!-- End Tables Nav -->

      <!-- <li class="nav-heading">Laporan</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-clipboard2-fill"></i>
          <span>Laporan</span>
        </a>
      </li> -->
      <!-- End Profile Page Nav -->

      <li class="nav-heading">Sign Out</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?= base_url('logout')?>">
          <i class="bi bi-box-arrow-right"></i>
          <span>Sign Out</span>
        </a>
      </li><!-- End Profile Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?= $title ?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url('kepala_bagian/dashboard') ?>">Kepala Bagian</a></li>
          <li class="breadcrumb-item active"><?= $title ?></li>
        </ol>
      </nav>
    </div><!--SA End Page Title -->

    <?= $this->renderSection('content') ?><!-- @yield('content')yield content -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>PT.Riaputra Metalindo</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?= base_url('assets/vendor/apexcharts/apexcharts.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/chart.js/chart.umd.js')?>"></script>
<script src="<?= base_url('assets/vendor/echarts/echarts.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/quill/quill.js')?>"></script>
<script src="<?= base_url('assets/vendor/simple-datatables/simple-datatables.js')?>"></script>
<script src="<?= base_url('assets/vendor/tinymce/tinymce.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/php-email-form/validate.js')?>"></script>

<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url('assets/js/main.js')?>"></script>

  <!-- sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// sweet alert
    $(function(){
      <?php if(session()->has('success')) { ?>
        const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});
Toast.fire({
  icon: "success",
  title: "<?= session()->getFlashdata('success') ?>"
});
        <?php } ?>
    })

    // sweet alert konvirmation delete

    $('.ubah-password').on('click', function(){
      var getLink = $(this).attr('href');

      Swal.fire({
  title: "Yakin Ubah Password?",
  text: "Password yang sudah di ubah harap di ingat!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, change it!"
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = getLink
  }
});
    return false;
    })


    // sweet alert konvirmation delete

$(document).ready(function() {
    $('.tombol-hapus').on('click', function() {
        var getLink = $(this).attr('href');

        Swal.fire({
            title: "Yakin Hapus?",
            text: "Data yang sudah di hapus tidak bisa di kembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = getLink;
            }
        });
        return false;
    });
});

</script>


</body>
</html>