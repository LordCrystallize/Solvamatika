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
    <h1>Daftar Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Kelas</li>
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
      <h3>Data Kelas</h3>
      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Kelas</button>
    </div>
    <hr>

    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
        <thead>
          <tr>
            <th width="10%">#</th>
            <th>Nama Kelas</th>
            <th width="15%">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($data_kelas)) : ?>
            <tr>
              <td colspan="3" class="text-center text-muted py-3">Belum ada master kelas yang tersimpan</td>
            </tr>
          <?php else : $no = 1; foreach ($data_kelas as $k) : ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><strong><?= esc($k['nama_kelas']); ?></strong></td>
              <td>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $k['id_kelas']; ?>"><i class="bi bi-pencil"></i></button>
                <a href="<?= base_url('admin/hapus-data-kelas/' . $k['id_kelas']); ?>" onclick="return confirm('Hapus kelas ini? Semua data siswa di dalam kelas ini akan ikut terhapus!')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php if (!empty($data_kelas)) : foreach ($data_kelas as $k) : ?>
  <div class="modal" id="modalEdit<?= $k['id_kelas']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form method="post" action="<?= base_url('admin/update-data-kelas/' . $k['id_kelas']); ?>" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold text-dark">Edit Nama Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label fw-semibold text-secondary">Nama Kelas</label>
            <input type="text" name="nama_kelas" value="<?= esc($k['nama_kelas']); ?>" class="form-control" required>
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

<div class="modal" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="post" action="<?= base_url('admin/simpan-data-kelas'); ?>" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-dark">Tambah Kelas Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Nama Kelas</label>
          <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: XII-RPL-1" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>