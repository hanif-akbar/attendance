<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
    
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Welcome to Admin Dashboard</h1>
            <div class="row">
                <!-- Card 1 - Total Pegawai -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Pegawai</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people text-primary"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>145</h6>
                                    <span class="text-muted small pt-2">Pegawai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 - Hadir Hari Ini -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card success-card">
                        <div class="card-body">
                            <h5 class="card-title">Alpa</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-check text-success"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>120</h6>
                                    <span class="text-muted small pt-2">Pegawai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 - Terlambat -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card warning-card">
                        <div class="card-body">
                            <h5 class="card-title">Terlambat</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clock-history text-warning"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>15</h6>
                                    <span class="text-muted small pt-2">Pegawai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 - Tidak Hadir -->
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card danger-card">
                        <div class="card-body">
                            <h5 class="card-title">Sakit/Izin/Sakit</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-x text-danger"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>10</h6>
                                    <span class="text-muted small pt-2">Pegawai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>