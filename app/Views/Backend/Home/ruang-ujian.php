<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Ruang Ujian - Solvamatika</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="<?= base_url('assets/img/favicon.png'); ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/aos/aos.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">

  <link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet">

  <style>
    body { background-color: #f4f6f9; }
    .question-box { display: none; }
    .question-box.active { display: block; }
    .no-btn { width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin: 4px; border-radius: 8px; cursor: not-allowed; opacity: 0.65; transition: 0.2s; }
    .no-btn.current { border: 2px solid #0d6efd !important; background-color: #e7f1ff; color: #0d6efd; opacity: 1; }
    .no-btn.answered { background-color: #198754; color: white; border: 1px solid #198754; opacity: 1; }
    .no-btn.unanswered { background-color: #fff; color: #6c757d; border: 1px solid #dee2e6; }
    .cursor-not-allowed { cursor: not-allowed; }
    .option-wrapper:hover { background-color: #f0f4f8 !important; border-color: #bfdbfe !important; }
    .user-select-none { user-select: none; -webkit-user-select: none; }
    .scratchpad-container { background: #ffffff; border: 1px solid #dee2e6; border-radius: 8px; position: relative; margin-bottom: 20px; }
    .scratchpad-canvas { width: 100%; height: 180px; display: block; cursor: crosshair; touch-action: none; background: #ffffff; border-radius: 0 0 8px 8px; }
  </style>
</head>

<body class="index-page user-select-none">

  <header id="header" class="header d-flex align-items-center sticky-top shadow-sm">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center me-auto me-xl-0 text-decoration-none">
        <h1 class="sitename">Solvamatika</h1><span>.</span>
      </a>
      <div class="text-end small">
        <span class="badge bg-light text-dark border me-2"><i class="bi bi-person-fill text-primary me-1"></i> <?= session()->get('siswa_nama'); ?></span>
        <span class="badge bg-light text-dark border"><i class="bi bi-building text-secondary me-1"></i> Kelas <?= session()->get('siswa_kelas'); ?></span>
      </div>
    </div>
  </header>

  <main class="main my-5">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      
      <?php if (empty($daftar_soal)): ?>
        <div class="alert alert-warning text-center py-5 rounded-3 border shadow-sm">
          <i class="bi bi-folder-x display-4 d-block mb-3 text-warning"></i>
          <h4 class="fw-bold">Butir Soal Belum Tersedia!</h4>
          <p class="mb-0 text-muted">Hubungi guru pengampu ujian untuk memasukkan butir pertanyaan evaluasi ke dalam sistem.</p>
        </div>
      <?php else: ?>
        
        <form id="examForm" action="<?= base_url('ragam-ujian/simpan-jawaban'); ?>" method="post">
          <input type="hidden" name="id_ujian" value="<?= $ujian['id_ujian']; ?>">
          
          <div class="row g-4">
            
            <div class="col-lg-8">
              <div class="card shadow border border-light rounded-3 bg-white">
                
                <?php foreach ($daftar_soal as $index => $s): ?>
                  <?php $nomor = $index + 1; ?>
                  
                  <div class="card-body p-4 question-box" id="soal-box-<?= $nomor; ?>" data-nomor="<?= $nomor; ?>">
                    
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                      <h4 class="fw-bold mb-0 text-dark">SOAL NOMOR <?= $nomor; ?></h4>
                      <span class="badge bg-light text-primary border border-primary px-3 py-1.5 fw-semibold">Pilihan Ganda</span>
                    </div>

                    <div class="fs-5 text-dark mb-4" style="line-height: 1.7; font-family: 'Roboto', sans-serif;">
                      <?= esc($s['soal']); ?>
                    </div>

                    <div class="d-flex flex-column gap-3 mb-4">
                      
                      <label class="p-3 border rounded-3 bg-light d-flex align-items-center option-wrapper" style="cursor: pointer; transition: 0.2s;">
                        <input type="radio" name="jawaban[<?= $s['id_soal']; ?>]" value="A" class="form-check-input me-3 border-secondary" style="transform: scale(1.2);" onchange="tandaiSudahDijawab(<?= $nomor; ?>, '<?= $s['id_soal']; ?>', 'A')">
                        <span class="text-dark"><strong class="me-2">A.</strong> <?= esc($s['opsi_a']); ?></span>
                      </label>

                      <label class="p-3 border rounded-3 bg-light d-flex align-items-center option-wrapper" style="cursor: pointer; transition: 0.2s;">
                        <input type="radio" name="jawaban[<?= $s['id_soal']; ?>]" value="B" class="form-check-input me-3 border-secondary" style="transform: scale(1.2);" onchange="tandaiSudahDijawab(<?= $nomor; ?>, '<?= $s['id_soal']; ?>', 'B')">
                        <span class="text-dark"><strong class="me-2">B.</strong> <?= esc($s['opsi_b']); ?></span>
                      </label>

                      <label class="p-3 border rounded-3 bg-light d-flex align-items-center option-wrapper" style="cursor: pointer; transition: 0.2s;">
                        <input type="radio" name="jawaban[<?= $s['id_soal']; ?>]" value="C" class="form-check-input me-3 border-secondary" style="transform: scale(1.2);" onchange="tandaiSudahDijawab(<?= $nomor; ?>, '<?= $s['id_soal']; ?>', 'C')">
                        <span class="text-dark"><strong class="me-2">C.</strong> <?= esc($s['opsi_c']); ?></span>
                      </label>

                      <label class="p-3 border rounded-3 bg-light d-flex align-items-center option-wrapper" style="cursor: pointer; transition: 0.2s;">
                        <input type="radio" name="jawaban[<?= $s['id_soal']; ?>]" value="D" class="form-check-input me-3 border-secondary" style="transform: scale(1.2);" onchange="tandaiSudahDijawab(<?= $nomor; ?>, '<?= $s['id_soal']; ?>', 'D')">
                        <span class="text-dark"><strong class="me-2">D.</strong> <?= esc($s['opsi_d']); ?></span>
                      </label>

                    </div>

                    <div class="scratchpad-container shadow-sm">
                      <div class="bg-light px-3 py-2 border-bottom d-flex justify-content-between align-items-center rounded-top-3">
                        <span class="small text-secondary fw-bold"><i class="bi bi-pencil-fill me-1 text-primary"></i>Papan Coretan Cakar Rumus - Nomor <?= $nomor; ?></span>
                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 0.75rem;" onclick="clearCanvas(<?= $nomor; ?>)">
                          <i class="bi bi-trash3-fill me-1"></i>Hapus Coretan
                        </button>
                      </div>
                      <canvas id="canvas-<?= $nomor; ?>" class="scratchpad-canvas"></canvas>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-4">
                      <button type="button" class="btn btn-secondary px-4 py-2 cursor-not-allowed" disabled>
                        <i class="bi bi-arrow-left me-1"></i> Sebelumnya
                      </button>
                      
                      <?php if ($nomor === $total_soal): ?>
                        <button type="button" id="btn-submit-ujian" class="btn btn-danger px-4 py-2 fw-bold" onclick="konfirmasiSelesaiUjian()">
                          <i class="bi bi-check-all me-1"></i> Selesai Ujian
                        </button>
                      <?php else: ?>
                        <button type="button" class="btn btn-primary px-4 py-2" id="btn-next-<?= $nomor; ?>" onclick="pindahSoal(<?= $nomor + 1; ?>)">
                          Berikutnya <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                      <?php endif; ?>
                    </div>

                  </div>
                <?php endforeach; ?>

              </div>
            </div>

            <div class="col-lg-4">
              <div class="card shadow border border-light rounded-3 bg-white">
                
                <div class="card-header bg-danger text-white py-3 border-0 d-flex justify-content-between align-items-center rounded-top-3">
                  <h6 class="mb-0 fw-bold"><i class="bi bi-clock-fill me-2"></i>SISA WAKTU</h6>
                  <span id="countdown-timer" class="badge bg-white text-danger fw-bold fs-5 px-3 py-1">00:00:00</span>
                </div>

                <div class="card-body p-3 text-center">
                  
                  <div class="text-start mb-2 px-1 small fw-bold text-secondary">
                    <i class="bi bi-grid-3x3-gap me-1"></i> Lembar Peta Soal:
                  </div>

                  <div class="d-flex flex-wrap justify-content-start ps-1">
                    <?php for($i = 1; $i <= $total_soal; $i++): ?>
                      <div id="grid-no-<?= $i; ?>" class="no-btn unanswered">
                        <?= $i; ?>
                      </div>
                    <?php endfor; ?>
                  </div>

                  <hr class="text-muted my-3">
                  <div class="d-flex gap-3 small text-muted justify-content-start px-2">
                    <div class="d-flex align-items-center"><span class="badge bg-success me-2" style="width: 14px; height: 14px; display: inline-block;">&nbsp;</span> Sudah Diisi</div>
                    <div class="d-flex align-items-center"><span class="badge bg-white border text-dark me-2" style="width: 14px; height: 14px; display: inline-block;">&nbsp;</span> Belum Diisi</div>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </form>

      <?php endif; ?>
    </div>
  </main>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/php-email-form/validate.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/aos/aos.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/isotope-layout/isotope.pkgd.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/purecounter/purecounter_vanilla.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/swiper/swiper-bundle.min.js'); ?>"></script>

  <script src="<?= base_url('assets/js/main.js'); ?>"></script>

<script>
  let currentActiveNo = 1;
  const totalSoal = <?= $total_soal ?? 0; ?>;
  const idUjianAktif = "<?= $ujian['id_ujian']; ?>";
  let sisaDetik = <?= $sisa_detik ?? 0; ?>; 

  let canvasInstances = {};

  function startTimer() {
    const timerElement = document.getElementById('countdown-timer');
    
    const interval = setInterval(function() {
      if (sisaDetik <= 0) {
        clearInterval(interval);
        timerElement.textContent = "00:00:00";
        alert("Waktu pelaksanaan ujian telah habis! Sistem akan menyimpan dan mengirimkan lembar jawaban Anda secara otomatis.");
        bersihkanSemuaDataLokal();
        document.getElementById('examForm').submit();
        return;
      }

      sisaDetik--;

      let hours = Math.floor(sisaDetik / 3600);
      let minutes = Math.floor((sisaDetik % 3600) / 60);
      let seconds = Math.floor(sisaDetik % 60);

      hours = String(hours).padStart(2, '0');
      minutes = String(minutes).padStart(2, '0');
      seconds = String(seconds).padStart(2, '0');

      timerElement.textContent = `${hours}:${minutes}:${seconds}`;
    }, 1000);
  }

  function pindahSoal(targetNomor) {
    if (targetNomor < 1 || targetNomor > totalSoal) return;

    document.querySelector('.question-box.active')?.classList.remove('active');
    document.getElementById('soal-box-' + targetNomor).classList.add('active');

    document.querySelector('.no-btn.current')?.classList.remove('current');
    document.getElementById('grid-no-' + targetNomor).classList.add('current');

    currentActiveNo = targetNomor;
    
    localStorage.setItem('solvamatika_active_no_' + idUjianAktif, targetNomor);
    
    resizeCanvas(targetNomor);
  }

  function tandaiSudahDijawab(nomor, idSoal, nilaiJawaban) {
    const gridBtn = document.getElementById('grid-no-' + nomor);
    gridBtn.classList.remove('unanswered');
    gridBtn.classList.add('answered');

    let listCadangan = JSON.parse(localStorage.getItem('solvamatika_ans_' + idUjianAktif)) || {};
    listCadangan[idSoal] = {
      nomor_soal: nomor,
      pilihan: nilaiJawaban
    };
    localStorage.setItem('solvamatika_ans_' + idUjianAktif, JSON.stringify(listCadangan));
  }

  function pulihkanJawabanSiswa() {
    const dataLokal = localStorage.getItem('solvamatika_ans_' + idUjianAktif);
    
    if (dataLokal) {
      const listCadangan = JSON.parse(dataLokal);
      
      Object.keys(listCadangan).forEach(idSoal => {
        const detail = listCadangan[idSoal];
        const selectorRadio = `input[name="jawaban[${idSoal}]"][value="${detail.pilihan}"]`;
        const komponenRadio = document.querySelector(selectorRadio);
        
        if (komponenRadio) {
          komponenRadio.checked = true;
          
          const gridBtn = document.getElementById('grid-no-' + detail.nomor_soal);
          if (gridBtn) {
            gridBtn.classList.remove('unanswered');
            gridBtn.classList.add('answered');
          }
        }
      });
    }
  }

  function initScratchpads() {
    for (let i = 1; i <= totalSoal; i++) {
      const canvas = document.getElementById('canvas-' + i);
      if (!canvas) continue;

      const ctx = canvas.getContext('2d');
      let drawing = false;

      ctx.strokeStyle = '#1e3a8a';
      ctx.lineWidth = 2.5;
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';

      canvas.addEventListener('mousedown', (e) => { 
        drawing = true; 
        ctx.beginPath(); 
        draw(e, ctx, canvas); 
      });
      canvas.addEventListener('mousemove', (e) => draw(e, ctx, canvas));
      canvas.addEventListener('mouseup', () => { 
        if(drawing) {
          drawing = false; 
          simpanCoretanKeLokal(i); 
        }
      });
      canvas.addEventListener('mouseleave', () => { 
        if(drawing) {
          drawing = false; 
          simpanCoretanKeLokal(i); 
        }
      });

      canvas.addEventListener('touchstart', (e) => {
        drawing = true;
        ctx.beginPath();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent("mousedown", {
          clientX: touch.clientX,
          clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
        e.preventDefault();
      });
      canvas.addEventListener('touchend', (e) => {
        drawing = false;
        const mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
      });
      canvas.addEventListener('touchmove', (e) => {
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent("mousemove", {
          clientX: touch.clientX,
          clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
        e.preventDefault();
      });

      function draw(e, context, cvs) {
        if (!drawing) return;

        const rect = cvs.getBoundingClientRect();
        const x = (e.clientX - rect.left) * (cvs.width / rect.width);
        const y = (e.clientY - rect.top) * (cvs.height / rect.height);

        context.lineTo(x, y);
        context.stroke();
        context.beginPath();
        context.moveTo(x, y);
      }

      canvasInstances[i] = { canvas: canvas, context: ctx };
    }
  }

  function simpanCoretanKeLokal(nomor) {
    const instansi = canvasInstances[nomor];
    if (instansi) {
      const sketsaDataUrl = instansi.canvas.toDataURL();
      let semuaCoretan = JSON.parse(localStorage.getItem('solvamatika_pads_' + idUjianAktif)) || {};
      semuaCoretan[nomor] = sketsaDataUrl;
      localStorage.setItem('solvamatika_pads_' + idUjianAktif, JSON.stringify(semuaCoretan));
    }
  }

  function pulihkanCoretanSiswa() {
    const dataCoretanLokal = localStorage.getItem('solvamatika_pads_' + idUjianAktif);
    if (dataCoretanLokal) {
      const semuaCoretan = JSON.parse(dataCoretanLokal);
      
      Object.keys(semuaCoretan).forEach(nomor => {
        const instansi = canvasInstances[nomor];
        if (instansi) {
          const cvs = instansi.canvas;
          const ctx = instansi.context;
          
          const img = new Image();
          img.src = semuaCoretan[nomor];
          img.onload = function() {
            ctx.clearRect(0, 0, cvs.width, cvs.height);
            ctx.drawImage(img, 0, 0);
          };
        }
      });
    }
  }

  function resizeCanvas(nomor) {
    const instansi = canvasInstances[nomor];
    if (instansi) {
      const cvs = instansi.canvas;
      const ctx = instansi.context;
      
      const tempImg = cvs.toDataURL();

      cvs.width = cvs.offsetWidth;
      cvs.height = cvs.offsetHeight;

      ctx.strokeStyle = '#1e3a8a';
      ctx.lineWidth = 2.5;
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';

      const img = new Image();
      img.src = tempImg;
      img.onload = function() {
        ctx.drawImage(img, 0, 0);
      };
    }
  }

  function clearCanvas(nomor) {
    const instansi = canvasInstances[nomor];
    if (instansi) {
      instansi.context.clearRect(0, 0, instansi.canvas.width, instansi.canvas.height);
      instansi.context.beginPath();
      
      let semuaCoretan = JSON.parse(localStorage.getItem('solvamatika_pads_' + idUjianAktif)) || {};
      if (semuaCoretan[nomor]) {
        delete semuaCoretan[nomor];
        localStorage.setItem('solvamatika_pads_' + idUjianAktif, JSON.stringify(semuaCoretan));
      }
    }
  }

  function bersihkanSemuaDataLokal() {
    localStorage.removeItem('solvamatika_ans_' + idUjianAktif);
    localStorage.removeItem('solvamatika_pads_' + idUjianAktif);
    localStorage.removeItem('solvamatika_active_no_' + idUjianAktif);
  }

  function konfirmasiSelesaiUjian() {
    if (confirm("Apakah Anda yakin ingin menyelesaikan ujian dan menyetor seluruh lembar jawaban?")) {
      bersihkanSemuaDataLokal();
      document.getElementById('examForm').submit();
    }
  }

  window.onload = function() {
    if (totalSoal > 0) {
      initScratchpads(); 
      pulihkanJawabanSiswa(); 
      
      setTimeout(pulihkanCoretanSiswa, 150); 
      
      let savedNo = localStorage.getItem('solvamatika_active_no_' + idUjianAktif);
      let targetNo = (savedNo && parseInt(savedNo) <= totalSoal) ? parseInt(savedNo) : 1;
      
      pindahSoal(targetNo); 
      startTimer();
    }
  };

  document.getElementById('examForm').addEventListener('submit', function() {
    bersihkanSemuaDataLokal();
  });
</script>

</body>

</html>