<style>
  .home-hero {
    position: relative;
    overflow: hidden;
    padding: 90px 0 70px;
    background: linear-gradient(135deg, #0d6efd 0%, #5b8def 45%, #f8fbff 45%, #ffffff 100%);
  }
  .home-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
      radial-gradient(circle at 18% 18%, rgba(255,255,255,.28), transparent 28%),
      radial-gradient(circle at 80% 22%, rgba(13,110,253,.14), transparent 24%);
    pointer-events: none;
  }
  .hero-panel, .exam-card, .feature-box {
    position: relative;
    border: 1px solid rgba(13, 110, 253, .10);
    box-shadow: 0 18px 55px rgba(15, 23, 42, .10);
  }
  .hero-panel {
    background: rgba(255,255,255,.93);
    backdrop-filter: blur(10px);
    border-radius: 28px;
    padding: 34px;
  }
  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(13,110,253,.10);
    color: #0d6efd;
    border: 1px solid rgba(13,110,253,.16);
    border-radius: 999px;
    padding: 8px 14px;
    font-weight: 700;
    font-size: .84rem;
  }
  .hero-title {
    font-size: clamp(2rem, 4vw, 3.7rem);
    line-height: 1.08;
    letter-spacing: -.04em;
    font-weight: 900;
    color: #101828;
  }
  .hero-title span { color: #0d6efd; }
  .hero-subtitle {
    color: #667085;
    font-size: 1.05rem;
    line-height: 1.75;
  }
  .feature-box {
    background: #fff;
    border-radius: 22px;
    padding: 18px;
    height: 100%;
  }
  .feature-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(13,110,253,.10);
    color: #0d6efd;
    font-size: 1.2rem;
    margin-bottom: 12px;
  }
  .exam-section { padding: 76px 0; background: #f7faff; }
  .exam-card {
    background: #fff;
    border-radius: 24px;
    padding: 24px;
    height: 100%;
    transition: .22s ease;
  }
  .exam-card:hover { transform: translateY(-6px); box-shadow: 0 24px 70px rgba(15, 23, 42, .14); }
  .exam-icon {
    width: 52px;
    height: 52px;
    border-radius: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(13,110,253,.12);
    color: #0d6efd;
    font-size: 1.45rem;
  }
  .exam-meta {
    background: #f8fafc;
    border: 1px solid #eef2f7;
    border-radius: 16px;
    padding: 14px;
  }
  .empty-state {
    background: #fff;
    border: 1px dashed #b7c6da;
    border-radius: 24px;
    padding: 38px;
  }
</style>

<main class="main">
  <section id="hero" class="home-hero">
    <div class="container position-relative" data-aos="fade-up">
      <div class="row align-items-center gy-4">
        <div class="col-lg-7">
          <div class="hero-panel">
            <div class="hero-badge mb-4">
              <i class="bi bi-shield-check"></i>
              Solvamatika CBT Platform
            </div>
            <h1 class="hero-title mb-3">Ujian online lebih rapi, cepat, dan <span>terukur.</span></h1>
            <p class="hero-subtitle mb-4">
              Pilih ujian yang sedang berlangsung, login menggunakan NISN, lalu kerjakan soal sesuai jadwal kelas Anda. Hasil ujian akan otomatis masuk ke dashboard admin.
            </p>
            <div class="d-flex flex-wrap gap-2">
              <a href="#services" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-pencil-square me-2"></i>Masuk Ujian
              </a>
              <a href="<?= base_url('login'); ?>" class="btn btn-light btn-lg rounded-pill px-4 fw-bold border">
                <i class="bi bi-person-lock me-2"></i>Login Admin
              </a>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="row g-3">
            <div class="col-6">
              <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-card-checklist"></i></div>
                <h6 class="fw-bold mb-1">Terjadwal</h6>
                <p class="small text-muted mb-0">Ujian hanya terbuka saat waktu berlangsung.</p>
              </div>
            </div>
            <div class="col-6">
              <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-key"></i></div>
                <h6 class="fw-bold mb-1">Login NISN</h6>
                <p class="small text-muted mb-0">NISN dipakai sebagai username dan password.</p>
              </div>
            </div>
            <div class="col-6">
              <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-stopwatch"></i></div>
                <h6 class="fw-bold mb-1">Timer Otomatis</h6>
                <p class="small text-muted mb-0">Jawaban bisa dikirim saat waktu habis.</p>
              </div>
            </div>
            <div class="col-6">
              <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                <h6 class="fw-bold mb-1">Hasil Admin</h6>
                <p class="small text-muted mb-0">Nilai masuk ke daftar hasil ujian.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="services" class="exam-section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Daftar Ujian Tersedia</h2>
      <p>Pilih ujian yang statusnya <strong>Berlangsung</strong>, kemudian masuk menggunakan NISN dan password yang sama dengan NISN.</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-4">
        <?php if (empty($sidebar_ujian)) : ?>
          <div class="col-12 text-center py-4">
            <div class="empty-state d-inline-block">
              <i class="bi bi-calendar2-x text-muted display-4 d-block mb-3"></i>
              <h5 class="fw-bold text-secondary">Belum Ada Ujian yang Dirilis</h5>
              <p class="text-muted mb-0 small">Silakan hubungi guru bidang studi untuk informasi jadwal ujian terbaru.</p>
            </div>
          </div>
        <?php else : ?>
          <?php
            date_default_timezone_set('Asia/Jakarta');
            $waktu_sekarang = time();
            $delay = 100;
          ?>

          <?php foreach ($sidebar_ujian as $ujian) : ?>
            <?php
              $mulai   = strtotime($ujian['waktu_mulai']);
              $selesai = strtotime($ujian['waktu_selesai']);

              if ($waktu_sekarang < $mulai) {
                  $status_teks  = 'Belum Mulai';
                  $status_badge = 'bg-secondary text-white';
                  $icon_status  = 'bi-hourglass-split';
                  $btn_class    = 'btn-light text-muted border';
                  $btn_label    = 'Belum Dibuka';
              } elseif ($waktu_sekarang >= $mulai && $waktu_sekarang <= $selesai) {
                  $status_teks  = 'Berlangsung';
                  $status_badge = 'bg-success text-white';
                  $icon_status  = 'bi-play-circle-fill';
                  $btn_class    = 'btn-primary text-white fw-bold';
                  $btn_label    = 'Masuk Ujian';
              } else {
                  $status_teks  = 'Selesai';
                  $status_badge = 'bg-danger text-white';
                  $icon_status  = 'bi-check-circle-fill';
                  $btn_class    = 'btn-light text-muted border';
                  $btn_label    = 'Sudah Ditutup';
              }
            ?>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
              <div class="exam-card d-flex flex-column justify-content-between">
                <div>
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="exam-icon"><i class="bi bi-journal-text"></i></div>
                    <span class="badge <?= $status_badge; ?> px-3 py-2 rounded-pill small">
                      <i class="bi <?= $icon_status; ?> me-1"></i><?= $status_teks; ?>
                    </span>
                  </div>

                  <h3 class="h5 fw-bold text-dark mb-3"><?= esc($ujian['nama_ujian']); ?></h3>
                  <div class="exam-meta small text-muted mb-4">
                    <div class="d-flex align-items-center mb-2">
                      <i class="bi bi-collection-play me-2 text-primary"></i>
                      <span>Jumlah soal: <strong><?= esc($ujian['jumlah_soal']); ?></strong></span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <i class="bi bi-clock me-2 text-success"></i>
                      <span>Durasi: <strong><?= esc($ujian['durasi']); ?> menit</strong></span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <i class="bi bi-calendar-event me-2 text-secondary"></i>
                      <span>Mulai: <?= date('d M Y, H:i', $mulai); ?> WIB</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-calendar-check me-2 text-danger"></i>
                      <span>Selesai: <?= date('d M Y, H:i', $selesai); ?> WIB</span>
                    </div>
                  </div>
                </div>

                <?php if ($status_teks === 'Berlangsung') : ?>
                  <a href="<?= base_url('ragam-ujian/konfirmasi/' . $ujian['id_ujian']); ?>" class="btn <?= $btn_class; ?> w-100 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i><?= $btn_label; ?>
                  </a>
                <?php else : ?>
                  <button type="button" class="btn <?= $btn_class; ?> w-100 py-2 rounded-pill" disabled>
                    <i class="bi bi-lock-fill me-1"></i><?= $btn_label; ?>
                  </button>
                <?php endif; ?>
              </div>
            </div>

            <?php $delay += 100; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
