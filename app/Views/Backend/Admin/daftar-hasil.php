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
    <h1>Daftar Hasil Ujian</h1>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url('dashboard'); ?>">
            Dashboard
          </a>
        </li>

        <li class="breadcrumb-item active">
          Hasil Ujian
        </li>
      </ol>
    </nav>
  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">

      <i class="bi bi-check-circle me-1"></i>

      <?= session()->getFlashdata('success'); ?>

      <button type="button"
              class="btn-close"
              data-bs-dismiss="alert">
      </button>

    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      <?= session()->getFlashdata('error'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow"
       style="width: 100%">

    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">

      <h3>Data Hasil Ujian</h3>

    </div>

    <hr>

    <div class="table-responsive">

      <table class="table table-striped table-bordered align-middle">

        <thead>

          <tr>
            <th width="5%">#</th>
            <th>Nama Siswa</th>
            <th width="15%">Kelas</th>
            <th width="10%">Nilai</th>
            <th width="10%">Benar</th>
            <th width="10%">Salah</th>
            <th width="15%">Opsi</th>
          </tr>

        </thead>

        <tbody>

        <?php if (empty($data_hasil)) : ?>

          <tr>
            <td colspan="7"
                class="text-center text-muted py-3">

              Belum ada hasil ujian siswa

            </td>
          </tr>

        <?php else : ?>

          <?php $no = 1; ?>

          <?php foreach ($data_hasil as $h) : ?>

          <tr>

            <td><?= $no++; ?></td>

            <td>
              <strong>
                <?= esc($h['nama_siswa']); ?>
              </strong>
            </td>

            <td>
              <span class="badge bg-light text-dark border">
                <?= esc($h['kelas']); ?>
              </span>
            </td>

            <td>

              <?php if($h['nilai'] >= 75): ?>

                <span class="badge bg-success">
                  <?= esc($h['nilai']); ?>
                </span>

              <?php else: ?>

                <span class="badge bg-danger">
                  <?= esc($h['nilai']); ?>
                </span>

              <?php endif; ?>

            </td>

            <td>
              <span class="text-success fw-bold">
                <?= esc($h['jumlah_benar']); ?>
              </span>
            </td>

            <td>
              <span class="text-danger fw-bold">
                <?= esc($h['jumlah_salah']); ?>
              </span>
            </td>

            <td>

              <div class="d-flex gap-1 flex-wrap">
                <button class="btn btn-sm btn-primary"
                        title="Detail hasil"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDetail<?= $h['id_hasil']; ?>">
                  <i class="bi bi-eye"></i>
                </button>

                <button class="btn btn-sm btn-danger"
                        title="Hapus hasil"
                        data-bs-toggle="modal"
                        data-bs-target="#modalHapus<?= $h['id_hasil']; ?>">
                  <i class="bi bi-trash"></i>
                </button>
              </div>

            </td>

          </tr>

          <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

      </table>

    </div>

  </div>

</main>

<!-- MODAL DETAIL -->
<?php if (!empty($data_hasil)) : ?>

<?php foreach ($data_hasil as $h) : ?>

<div class="modal"
     id="modalDetail<?= $h['id_hasil']; ?>"
     tabindex="-1"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title fw-bold text-dark">
          Detail Hasil Ujian
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close">
        </button>

      </div>

      <div class="modal-body text-start">

        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Nama Siswa
          </label>

          <input type="text"
                 class="form-control"
                 value="<?= esc($h['nama_siswa']); ?>"
                 readonly>

        </div>

        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Kelas
          </label>

          <input type="text"
                 class="form-control"
                 value="<?= esc($h['kelas']); ?>"
                 readonly>

        </div>

        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Nilai
          </label>

          <input type="text"
                 class="form-control"
                 value="<?= esc($h['nilai']); ?>"
                 readonly>

        </div>

        <div class="row">

          <div class="col-md-6 mb-3">

            <label class="form-label fw-semibold text-success">
              Jumlah Benar
            </label>

            <input type="text"
                   class="form-control"
                   value="<?= esc($h['jumlah_benar']); ?>"
                   readonly>

          </div>

          <div class="col-md-6 mb-3">

            <label class="form-label fw-semibold text-danger">
              Jumlah Salah
            </label>

            <input type="text"
                   class="form-control"
                   value="<?= esc($h['jumlah_salah']); ?>"
                   readonly>

          </div>

        </div>

        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Waktu Mulai
          </label>

          <input type="text"
                 class="form-control"
                 value="<?= date('d M Y H:i', strtotime($h['waktu_mulai'])); ?>"
                 readonly>

        </div>

        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Waktu Selesai
          </label>

          <input type="text"
                 class="form-control"
                 value="<?= date('d M Y H:i', strtotime($h['waktu_selesai'])); ?>"
                 readonly>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">

          Tutup

        </button>

      </div>

    </div>

  </div>

</div>

<?php endforeach; ?>

<?php endif; ?>