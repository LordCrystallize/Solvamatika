<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Konfirmasi Peserta Ujian - Solvamatika</title>
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet">
  <style>
    body { background-color: #f4f6f9; }
    .login-container { max-width: 450px; margin-top: 10%; }
  </style>
</head>
<body>

  <div class="container d-flex justify-content-center">
    <div class="card shadow border-0 rounded-3 login-container bg-white w-100">
      <div class="card-body p-4">
        
        <div class="text-center mb-4">
          <h3 class="fw-bold text-dark mb-1">Solvamatika</h3>
          <p class="text-muted small">Login Peserta Ujian</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
          <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="bg-light p-3 rounded-3 border mb-4">
          <table class="table table-sm table-borderless mb-0 small text-dark">
            <tr><td width="35%" class="text-muted">Paket Ujian</td><td>: <strong><?= esc($ujian['nama_ujian']); ?></strong></td></tr>
            <tr><td class="text-muted">Durasi</td><td>: <?= esc($ujian['durasi']); ?> Menit</td></tr>
            <tr><td class="text-muted">Batas Soal</td><td>: <?= esc($ujian['jumlah_soal']); ?> Butir</td></tr>
          </table>
        </div>

        <form method="post" action="<?= base_url('ragam-ujian/validasi'); ?>">
          <input type="hidden" name="id_ujian" value="<?= $ujian['id_ujian']; ?>">

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">NISN Siswa</label>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-card-text"></i></span>
              <input type="text" name="nisn" maxlength="10" class="form-control border-start-0 ps-0" placeholder="Masukkan 10 digit NISN" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label small fw-semibold text-secondary">Password Akses</label>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Masukkan NISN lagi" required>
            </div>
            <div class="form-text text-muted" style="font-size: 0.72rem;">
              Password default sama dengan NISN siswa.
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
            Masuk Ruang Ujian
          </button>
          
          <a href="<?= base_url(); ?>" class="btn btn-light w-100 py-2 small mt-2 border text-muted">
            Batal
          </a>
        </form>

      </div>
    </div>
  </div>

  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>