<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Hasil Evaluasi Ujian - Solvamatika</title>
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet">
  <style>
    body { background-color: #f4f6f9; }
    .score-circle { width: 120px; height: 120px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 2.2rem; font-weight: 800; border: 6px solid #0d6efd; background-color: #e7f1ff; color: #0d6efd; }
  </style>
</head>
<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top shadow-sm">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="<?= base_url(); ?>" class="logo d-flex align-items-center me-auto text-decoration-none">
        <h1 class="sitename">Solvamatika</h1><span>.</span>
      </a>
      <a href="<?= base_url(); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-house me-1"></i> Kembali ke Beranda</a>
    </div>
  </header>

  <main class="main my-5">
    <div class="container">
      
      <div class="card shadow shadow-sm border-0 rounded-3 text-center bg-white mx-auto" style="max-width: 650px;">
        <div class="card-body p-5">
          <i class="bi bi-trophy text-warning display-3 mb-3 d-block"></i>
          <h2 class="fw-bold text-dark mb-1">Hasil Evaluasi Belajar Selesai</h2>
          <p class="text-muted mb-4">Ujian: <strong><?= esc($ujian['nama_ujian']); ?></strong></p>
          
          <div class="row justify-content-center mb-4">
            <div class="col-10 bg-light p-3 rounded-3 border">
              <table class="table table-sm table-borderless text-start mb-0 align-middle">
                <tr><td width="35%" class="fw-semibold text-muted">Nama Siswa</td><td>: <strong class="text-dark"><?= $review['nama']; ?></strong></td></tr>
                <tr><td class="fw-semibold text-muted">Kelas / Ruang</td><td>: <strong class="text-dark"><?= $review['kelas']; ?></strong></td></tr>
                <tr><td class="fw-semibold text-muted">Total Soal</td><td>: <?= $review['total_soal']; ?> Butir Pertanyaan</td></tr>
                <tr><td class="fw-semibold text-muted">Jawaban Benar</td><td>: <span class="text-success fw-bold"><?= $review['benar']; ?></span></td></tr>
                <tr><td class="fw-semibold text-muted">Jawaban Salah</td><td>: <span class="text-danger fw-bold"><?= $review['salah']; ?></span></td></tr>
              </table>
            </div>
          </div>

          <div class="score-circle mb-3 shadow-sm">
            <?= $review['nilai']; ?>
          </div>
          <div class="fw-bold text-secondary">SKOR NILAI AKHIR</div>
        </div>
      </div>

    </div>
  </main>

  <footer id="footer" class="footer light-background py-4 text-center border-top">
    <div class="container small text-muted">
      © Copyright <strong>Solvamatika CBT</strong> 2026. All Rights Reserved.
    </div>
  </footer>

  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/aos/aos.js'); ?>"></script>
  <script>AOS.init();</script>
</body>
</html>