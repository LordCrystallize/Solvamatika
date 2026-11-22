<style>
  .modal {
    z-index: 1060 !important;
  }
  .modal-backdrop {
    z-index: 1040 !important;
  }
  .modal-content {
    background-color: #ffffff !important;
    border: none !important;
    border-radius: 10px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
    padding: 10px !important;
  }
  .modal-header {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6 !important;
    border-top-left-radius: 10px !important;
    border-top-right-radius: 10px !important;
  }
  .modal-footer {
    border-top: 1px solid #dee2e6 !important;
  }
</style>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Ujian</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Ujian</li>
      </ol>
    </nav>
  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i> <?= session()->getFlashdata('success'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">

    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
      <h3>Data Ujian</h3>
      <div>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Ujian</button>
      </div>
    </div>

    <hr>

    <div class="table-responsive">
      <table id="table" class="table table-striped table-bordered align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Ujian</th>
            <th>Target Kelas</th>
            <th>Jumlah Soal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Durasi</th>
            <th>Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>

        <?php if (empty($data_ujian)) : ?>
          <tr>
            <td colspan="9" class="text-center text-muted py-4">Belum ada ujian yang dibuat</td>
          </tr>
        <?php else : $no = 1; foreach ($data_ujian as $data) : ?>
            <?php
              date_default_timezone_set('Asia/Jakarta');
              $sekarang       = time();
              $waktu_mulai    = strtotime($data['waktu_mulai']);
              $waktu_selesai  = strtotime($data['waktu_selesai']);

              if ($sekarang < $waktu_mulai) {
                  $status = 'Belum Mulai';
                  $badge  = 'secondary';
              } elseif ($sekarang >= $waktu_mulai && $sekarang <= $waktu_selesai) {
                  $status = 'Berlangsung';
                  $badge  = 'success';
              } else {
                  $status = 'Selesai';
                  $badge  = 'danger';
              }
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><strong><?= esc($data['nama_ujian']); ?></strong></td>
              <td>
                <?php 
                  $ada_kelas = false;
                  foreach ($data_kelas as $kls) {
                      if ($kls['id_kelas'] == $data['id_kelas']) {
                          echo '<span class="badge bg-light text-dark border fw-bold">' . esc($kls['nama_kelas']) . '</span>';
                          $ada_kelas = true;
                          break;
                      }
                  }
                  if (!$ada_kelas) {
                      echo '<span class="badge bg-light text-muted border">Belum Diatur</span>';
                  }
                ?>
              </td>
              <td><?= esc($data['jumlah_soal']); ?> Butir</td>
              <td><?= date('d M Y H:i', strtotime($data['waktu_mulai'])); ?> WIB</td>
              <td><?= date('d M Y H:i', strtotime($data['waktu_selesai'])); ?> WIB</td>
              <td><span class="badge bg-light text-dark border"><?= esc($data['durasi']); ?> Menit</span></td>
              <td><span class="badge bg-<?= $badge; ?>"><?= $status; ?></span></td>
              <td>
                <?php if ($status === 'Belum Mulai') : ?>
                  <a href="<?= base_url('tambah-data-soal/' . $data['id_ujian']); ?>" class="btn btn-sm btn-success" title="Kelola Soal"><i class="bi bi-plus-circle"></i></a>
                  <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id_ujian']; ?>" title="Edit"><i class="bi bi-pencil"></i></button>
                <?php else : ?>
                  <button class="btn btn-sm btn-secondary" disabled title="Ujian <?= strtolower($status); ?>"><i class="bi bi-plus-circle"></i></button>
                  <button class="btn btn-sm btn-secondary" disabled title="Ujian <?= strtolower($status); ?>"><i class="bi bi-pencil"></i></button>
                <?php endif; ?>
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $data['id_ujian']; ?>" data-name="<?= $data['nama_ujian']; ?>" title="Hapus"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<div class="modal" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="post" action="<?= base_url('simpan-data-ujian'); ?>" class="modal-content text-start">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-dark">Tambah Ujian Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Nama Ujian</label>
          <input type="text" name="nama_ujian" class="form-control" placeholder="Masukkan nama ujian" required>
        </div>
        
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Target Kelas Peserta</label>
          <select name="id_kelas" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($data_kelas as $kls) : ?>
              <option value="<?= $kls['id_kelas']; ?>"><?= esc($kls['nama_kelas']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Jumlah Soal Batas Maksimal</label>
          <input type="number" name="jumlah_soal" class="form-control" placeholder="Masukkan jumlah soal" min="1" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Waktu Mulai</label>
          <input type="datetime-local" id="tambah_waktu_mulai" name="waktu_mulai" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Waktu Selesai</label>
          <input type="datetime-local" id="tambah_waktu_selesai" name="waktu_selesai" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Durasi Sistem (Menit)</label>
          <input type="number" id="tambah_durasi" name="durasi" class="form-control bg-light fw-bold text-primary" readonly placeholder="Otomatis terhitung dari selisih waktu..." required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?php if (!empty($data_ujian)) : foreach ($data_ujian as $data): ?>
  <div class="modal" id="modalEdit<?= $data['id_ujian']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form method="post" action="<?= base_url('update-data-ujian/' . $data['id_ujian']); ?>" class="modal-content text-start">
        <div class="modal-header">
          <h5 class="modal-title fw-bold text-dark">Edit Data Ujian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Nama Ujian</label>
            <input type="text" name="nama_ujian" value="<?= esc($data['nama_ujian']); ?>" class="form-control" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Target Kelas Peserta</label>
            <select name="id_kelas" class="form-select" required>
              <?php foreach ($data_kelas as $kls) : ?>
                <option value="<?= $kls['id_kelas']; ?>" <?= ($kls['id_kelas'] == $data['id_kelas']) ? 'selected' : ''; ?>><?= esc($kls['nama_kelas']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Jumlah Soal Batas Maksimal</label>
            <input type="number" name="jumlah_soal" value="<?= esc($data['jumlah_soal']); ?>" class="form-control" min="1" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Waktu Mulai</label>
            <input type="datetime-local" id="edit_waktu_mulai_<?= $data['id_ujian']; ?>" onchange="hitungDurasiEdit('<?= $data['id_ujian']; ?>')" name="waktu_mulai" value="<?= date('Y-m-d\TH:i', strtotime($data['waktu_mulai'])); ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Waktu Selesai</label>
            <input type="datetime-local" id="edit_waktu_selesai_<?= $data['id_ujian']; ?>" onchange="hitungDurasiEdit('<?= $data['id_ujian']; ?>')" name="waktu_selesai" value="<?= date('Y-m-d\TH:i', strtotime($data['waktu_selesai'])); ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Durasi Sistem (Menit)</label>
            <input type="number" id="edit_durasi_<?= $data['id_ujian']; ?>" name="durasi" value="<?= $data['durasi']; ?>" class="form-control bg-light fw-bold text-primary" readonly required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
<?php endforeach; endif; ?>

<div class="modal" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-start">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-dark">Hapus Data Ujian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus ujian <strong id="ujianName" class="text-danger"></strong>? Total seluruh data soal beserta lembar jawaban di dalamnya juga akan terhapus permanen dari sistem.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>

<script>
  const deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');

    document.getElementById('ujianName').textContent = name;
    document.getElementById('confirmDeleteBtn').href = "<?= base_url('hapus-data-ujian/') ?>" + id;
  });

  const waktuMulaiInput = document.getElementById('tambah_waktu_mulai');
  const waktuSelesaiInput = document.getElementById('tambah_waktu_selesai');
  const durasiInput = document.getElementById('tambah_durasi');

  function hitungDurasiOtomatis() {
    const mulai = new Date(waktuMulaiInput.value);
    const selesai = new Date(waktuSelesaiInput.value);

    if (!isNaN(mulai) && !isNaN(selesai)) {
      let selisih = selesai - mulai;
      if (selisih > 0) {
        durasiInput.value = Math.floor(selisih / 1000 / 60);
      } else {
        durasiInput.value = 0;
      }
    }
  }
  waktuMulaiInput.addEventListener('change', hitungDurasiOtomatis);
  waktuSelesaiInput.addEventListener('change', hitungDurasiOtomatis);

  function hitungDurasiEdit(idUjian) {
    const mulai = new Date(document.getElementById('edit_waktu_mulai_' + idUjian).value);
    const selesai = new Date(document.getElementById('edit_waktu_selesai_' + idUjian).value);
    const durasi = document.getElementById('edit_durasi_' + idUjian);

    if (!isNaN(mulai) && !isNaN(selesai)) {
      let selisih = selesai - mulai;
      if (selisih > 0) {
        durasi.value = Math.floor(selisih / 1000 / 60);
      } else {
        durasi.value = 0;
      }
    }
  }

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('action') === 'tambah') {
    const modalTambahElement = document.getElementById('modalTambah');
    if (modalTambahElement) {
      const modalTambahObj = new bootstrap.Modal(modalTambahElement);
      modalTambahObj.show();
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  }

  const btnSidebar = document.getElementById('btnSidebarTambahUjian');
  if (btnSidebar && window.location.pathname.includes('daftar-ujian')) {
    btnSidebar.addEventListener('click', function(e) {
      e.preventDefault();
      const modalTambahElement = document.getElementById('modalTambah');
      if (modalTambahElement) {
        const modalTambahObj = bootstrap.Modal.getInstance(modalTambahElement) || new bootstrap.Modal(modalTambahElement);
        modalTambahObj.show();
      }
    });
  }
</script>