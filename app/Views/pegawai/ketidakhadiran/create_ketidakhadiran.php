<?= $this->extend('pegawai/layout.php')?>
<?= $this->section('content')?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-times me-2"></i>
                        Form Pengajuan Ketidakhadiran
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= base_url('pegawai/ketidakhadiran/store')?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <input type="hidden" value="<?= session()->get('id_pegawai') ?>" name="id_pegawai">
                        
                        <!-- Jenis Ketidakhadiran -->
                        <div class="mb-3">
                            <label for="jenis_ketidakhadiran" class="form-label">
                                <i class="fas fa-list-alt me-1"></i>
                                Jenis Ketidakhadiran <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_ketidakhadiran" id="jenis_ketidakhadiran" class="form-select <?= ($validation->hasError('jenis_ketidakhadiran')) ? 'is-invalid' : '' ?>">
                                <option value="">--Pilih Jenis--</option>
                                <option value="sakit" <?= set_value('jenis_ketidakhadiran') == 'sakit' ? 'selected' : '' ?>>Sakit</option>
                                <option value="izin" <?= set_value('jenis_ketidakhadiran') == 'izin' ? 'selected' : '' ?>>Izin</option>
                                <option value="cuti" <?= set_value('jenis_ketidakhadiran') == 'cuti' ? 'selected' : '' ?>>Cuti</option>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('jenis_ketidakhadiran')?></div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">
                                <i class="fas fa-info-circle me-1"></i>
                                Keterangan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="keterangan" 
                                   name="keterangan" 
                                   class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : '' ?>" 
                                   value="<?= set_value('keterangan') ?>"
                                   placeholder="Contoh: Demam tinggi, Keperluan keluarga, dll">
                            <div class="invalid-feedback"><?= $validation->getError('keterangan')?></div>
                        </div>
                        
                        <!-- Tanggal Ketidakhadiran -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">
                                <i class="fas fa-calendar me-1"></i>
                                Tanggal Ketidakhadiran <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   id="tanggal" 
                                   name="tanggal" 
                                   class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : '' ?>" 
                                   value="<?= set_value('tanggal') ?>">
                            <div class="invalid-feedback"><?= $validation->getError('tanggal')?></div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">
                                <i class="fas fa-edit me-1"></i>
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>" 
                                      rows="4" 
                                      placeholder="Jelaskan alasan ketidakhadiran Anda..."><?= set_value('deskripsi') ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('deskripsi')?></div>
                        </div>
                        
                        <!-- File Upload -->
                        <div class="mb-4">
                            <label for="file" class="form-label">
                                <i class="fas fa-file-upload me-1"></i>
                                File Pendukung
                            </label>
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   class="form-control <?= ($validation->hasError('file')) ? 'is-invalid' : '' ?>" 
                                   accept=".jpg,.jpeg,.png">
                            <div class="invalid-feedback"><?= $validation->getError('file')?></div>
                            <div class="form-text">
                                <i class="fas fa-info-circle text-info"></i> 
                                Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran 2MB.
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Ajukan Ketidakhadiran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>