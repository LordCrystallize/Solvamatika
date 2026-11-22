<main id="main" class="main">

  <!-- ALERT NOTIFIKASI SYSTEM -->
  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i> <?= session()->getFlashdata('success'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i> <?= session()->getFlashdata('error'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- CARD INPUT SOAL -->
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
      <h4 class="card-title mb-0 fw-bold text-primary">
        <i class="bi bi-file-earmark-plus me-2"></i>Kelola Soal: <?= esc($ujian['nama_ujian']); ?>
      </h4>
      <a href="<?= base_url('daftar-ujian'); ?>" class="btn btn-outline-danger btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
    </div>

    <div class="card-body pt-4">
      
      <!-- KONDISI JIKA KUOTA SOAL PENUH -->
      <?php if ($is_full) : ?>
        <div class="text-center py-4 bg-light rounded border border-success">
          <i class="bi bi-shield-check text-success display-4 mb-2 d-block"></i>
          <h5 class="fw-bold text-success">Kuota Soal Terpenuhi!</h5>
          <p class="text-muted mb-0">
            Ujian ini diset dengan batas maksimal <strong><?= $ujian['jumlah_soal']; ?></strong> soal, dan seluruh slot telah berhasil dibuat.
          </p>
        </div>
      <?php else : ?>
        
        <!-- FORM AKTIF (HANYA MUNCUL JIKA BELUM PENUH) -->
        <div class="alert alert-info border-0 py-2 mb-3 small d-flex align-items-center">
          <i class="bi bi-info-circle me-2 fs-5"></i>
          Progress: Memasukkan soal ke-<strong><?= $total_soal_aktif + 1; ?></strong> dari batas maksimal <strong><?= $ujian['jumlah_soal']; ?></strong> butir soal.
        </div>

        <form action="<?= base_url('simpan-data-soal'); ?>" method="post">
          <input type="hidden" name="id_ujian" value="<?= $ujian['id_ujian']; ?>">

          <div class="mb-4">
            <label class="form-label fw-semibold">Butir Soal Pertanyaan</label>
            <textarea name="soal" class="form-control" rows="4" placeholder="Tuliskan teks pertanyaan di sini..." required></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Pilihan Opsi A</label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold">A</span>
                <input type="text" name="opsi_a" class="form-control" placeholder="Isi opsi A" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Pilihan Opsi B</label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold">B</span>
                <input type="text" name="opsi_b" class="form-control" placeholder="Isi opsi B" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Pilihan Opsi C</label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold">C</span>
                <input type="text" name="opsi_c" class="form-control" placeholder="Isi opsi C" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Pilihan Opsi D</label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold">D</span>
                <input type="text" name="opsi_d" class="form-control" placeholder="Isi opsi D" required>
              </div>
            </div>
          </div>

          <div class="row align-items-end mt-2">
            <div class="col-md-6 mb-4">
              <label class="form-label fw-semibold text-success">Kunci Jawaban Yang Benar</label>
              <select name="jawaban_benar" class="form-select border-success" required>
                <option value="">-- Pilih Kunci --</option>
                <option value="A">Opsi A</option>
                <option value="B">Opsi B</option>
                <option value="C">Opsi C</option>
                <option value="D">Opsi D</option>
              </select>
            </div>
            <div class="col-md-6 mb-4 text-end">
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-hdd me-1"></i> Simpan Soal
              </button>
            </div>
          </div>
        </form>
      <?php endif; ?>

    </div>
  </div>

  <!-- TABLE LIST DAFTAR SOAL -->
  <div class="card shadow-sm mt-4">
    <div class="card-header bg-white py-3">
      <h5 class="card-title mb-0 fw-semibold text-secondary">
        <i class="bi bi-list-task me-2"></i>Koleksi Soal Tersimpan (<?= $total_soal_aktif; ?> / <?= $ujian['jumlah_soal']; ?>)
      </h5>
    </div>

    <div class="card-body pt-3">
      <div class="table-responsive">
        <table class="table table-hover align-middle border">
          <thead class="table-light">
            <tr>
              <th width="6%" class="text-center">No</th>
              <th>Detail Soal &amp; Pilihan Ganda</th>
              <th width="15%" class="text-center">Kunci Jawaban</th>
            </tr>
          </thead>
          <tbody>
            <?php if(empty($soal)): ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-4">
                  <i class="bi bi-folder-x display-6 d-block mb-2"></i>
                  Belum ada soal yang ditambahkan untuk ujian ini.
                </td>
              </tr>
            <?php else: ?>
              <?php $no = 1; ?>
              <?php foreach($soal as $s): ?>
                <tr>
                  <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                  <td class="py-3">
                    <div class="fw-semibold mb-3 text-dark fs-6"><?= esc($s['soal']); ?></div>
                    <div class="row g-2 ps-2 text-secondary">
                      <div class="col-md-6"><strong>A.</strong> <?= esc($s['opsi_a']); ?></div>
                      <div class="col-md-6"><strong>B.</strong> <?= esc($s['opsi_b']); ?></div>
                      <div class="col-md-6"><strong>C.</strong> <?= esc($s['opsi_c']); ?></div>
                      <div class="col-md-6"><strong>D.</strong> <?= esc($s['opsi_d']); ?></div>
                    </div>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-light text-success border border-success px-3 py-2 fs-6">
                      Kunci: <strong><?= esc($s['jawaban_benar']); ?></strong>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</main>