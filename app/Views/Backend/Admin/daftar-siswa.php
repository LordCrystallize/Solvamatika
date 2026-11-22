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

    <h1>Daftar Siswa</h1>

    <nav>

      <ol class="breadcrumb">

        <li class="breadcrumb-item">
          <a href="<?= base_url('dashboard'); ?>">
            Dashboard
          </a>
        </li>

        <li class="breadcrumb-item active">
          Daftar Siswa
        </li>

      </ol>

    </nav>

  </div>

  <!-- ALERT SUCCESS -->
  <?php if (session()->getFlashdata('success')) : ?>

    <div class="alert alert-success alert-dismissible fade show"
         role="alert">

      <i class="bi bi-check-circle me-1"></i>

      <?= session()->getFlashdata('success'); ?>

      <button type="button"
              class="btn-close"
              data-bs-dismiss="alert">
      </button>

    </div>

  <?php endif; ?>

  <!-- ALERT ERROR -->
  <?php if (session()->getFlashdata('error')) : ?>

    <div class="alert alert-danger alert-dismissible fade show"
         role="alert">

      <i class="bi bi-exclamation-circle me-1"></i>

      <?= session()->getFlashdata('error'); ?>

      <button type="button"
              class="btn-close"
              data-bs-dismiss="alert">
      </button>

    </div>

  <?php endif; ?>

  <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow"
       style="width: 100%">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">

      <h3>Data Siswa</h3>

      <div class="d-flex gap-2">

        <!-- BUTTON IMPORT -->
        <button type="button"
                class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#modalImport">

          <i class="bi bi-file-earmark-excel"></i>
          Import Excel

        </button>

        <!-- BUTTON TAMBAH -->
        <button type="button"
                class="btn btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">

          + Tambah Siswa

        </button>

      </div>

    </div>

    <hr>

    <!-- TABLE -->
    <div class="table-responsive">

      <table class="table table-striped table-bordered align-middle">

        <thead>

          <tr>

            <th width="5%">#</th>

            <th width="12%">NIS</th>

            <th width="15%">NISN</th>

            <th>Nama Lengkap</th>

            <th width="15%">Jenis Kelamin</th>

            <th width="15%">Kelas</th>

            <th width="12%">Opsi</th>

          </tr>

        </thead>

        <tbody>

        <?php if (empty($data_siswa)) : ?>

          <tr>

            <td colspan="7"
                class="text-center text-muted py-3">

              Belum ada data siswa resmi yang terdaftar

            </td>

          </tr>

        <?php else : ?>

          <?php $no = 1; ?>

          <?php foreach ($data_siswa as $s) : ?>

          <tr>

            <td><?= $no++; ?></td>

            <td><?= esc($s['nis']); ?></td>

            <td><?= esc($s['nisn']); ?></td>

            <td>
              <strong>
                <?= esc($s['nama_siswa']); ?>
              </strong>
            </td>

            <td>

              <?php if($s['jenis_kelamin'] == 'Laki-laki') : ?>

                <span class="badge bg-primary">
                  Laki-laki
                </span>

              <?php else : ?>

                <span class="badge bg-danger">
                  Perempuan
                </span>

              <?php endif; ?>

            </td>

            <td>

              <span class="badge bg-light text-dark border">

                <?= esc($s['nama_kelas']); ?>

              </span>

            </td>

            <td>

              <!-- EDIT -->
              <button class="btn btn-sm btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEdit<?= $s['id_siswa']; ?>">

                <i class="bi bi-pencil"></i>

              </button>

              <!-- DELETE -->
              <a href="<?= base_url('admin/hapus-data-siswa/' . $s['id_siswa']); ?>"
                 onclick="return confirm('Hapus akun siswa ini?')"
                 class="btn btn-sm btn-danger">

                <i class="bi bi-trash"></i>

              </a>

            </td>

          </tr>

          <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

      </table>

    </div>

  </div>

</main>

<!-- MODAL EDIT -->
<?php if (!empty($data_siswa)) : ?>

<?php foreach ($data_siswa as $s) : ?>

<div class="modal"
     id="modalEdit<?= $s['id_siswa']; ?>"
     tabindex="-1"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">

    <form method="post"
          action="<?= base_url('admin/update-data-siswa/' . $s['id_siswa']); ?>"
          class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title fw-bold text-dark">
          Edit Informasi Siswa
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal">
        </button>

      </div>

      <div class="modal-body text-start">

        <!-- NIS -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            NIS
          </label>

          <input type="text"
                 name="nis"
                 value="<?= esc($s['nis']); ?>"
                 class="form-control"
                 required>

        </div>

        <!-- NISN -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            NISN
          </label>

          <input type="text"
                 name="nisn"
                 maxlength="10"
                 value="<?= esc($s['nisn']); ?>"
                 class="form-control"
                 required>

        </div>

        <!-- NAMA -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Nama Lengkap
          </label>

          <input type="text"
                 name="nama_siswa"
                 value="<?= esc($s['nama_siswa']); ?>"
                 class="form-control"
                 required>

        </div>

        <!-- JK -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Jenis Kelamin
          </label>

          <select name="jenis_kelamin"
                  class="form-select"
                  required>

            <option value="Laki-laki"
              <?= ($s['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>

              Laki-laki

            </option>

            <option value="Perempuan"
              <?= ($s['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>

              Perempuan

            </option>

          </select>

        </div>

        <!-- KELAS -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Ubah Kelas
          </label>

          <select name="id_kelas"
                  class="form-select"
                  required>

            <?php foreach($data_kelas as $k): ?>

              <option value="<?= $k['id_kelas']; ?>"
                <?= ($k['id_kelas'] == $s['id_kelas']) ? 'selected' : ''; ?>>

                <?= esc($k['nama_kelas']); ?>

              </option>

            <?php endforeach; ?>

          </select>

        </div>

        <!-- PASSWORD -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">

            Ubah Password

            <span class="text-muted small">
              (Kosongkan jika tetap)
            </span>

          </label>

          <input type="password"
                 name="password"
                 class="form-control"
                 placeholder="Masukkan password baru">

        </div>

      </div>

      <div class="modal-footer">

        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">

          Batal

        </button>

        <button type="submit"
                class="btn btn-primary">

          Simpan Perubahan

        </button>

      </div>

    </form>

  </div>

</div>

<?php endforeach; ?>

<?php endif; ?>

<!-- MODAL TAMBAH -->
<div class="modal"
     id="modalTambah"
     tabindex="-1"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">

    <form method="post"
          action="<?= base_url('admin/simpan-data-siswa'); ?>"
          class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title fw-bold text-dark">
          Registrasi Akun Siswa
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal">
        </button>

      </div>

      <div class="modal-body text-start">

        <!-- NIS -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            NIS
          </label>

          <input type="text"
                 name="nis"
                 class="form-control"
                 placeholder="Masukkan NIS"
                 required>

        </div>

        <!-- NISN -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            NISN
          </label>

          <input type="text"
                 name="nisn"
                 maxlength="10"
                 class="form-control"
                 placeholder="Masukkan NISN"
                 required>

        </div>

        <!-- NAMA -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Nama Lengkap
          </label>

          <input type="text"
                 name="nama_siswa"
                 class="form-control"
                 placeholder="Masukkan Nama Siswa"
                 required>

        </div>

        <!-- JK -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Jenis Kelamin
          </label>

          <select name="jenis_kelamin"
                  class="form-select"
                  required>

            <option value="">
              -- Pilih Jenis Kelamin --
            </option>

            <option value="Laki-laki">
              Laki-laki
            </option>

            <option value="Perempuan">
              Perempuan
            </option>

          </select>

        </div>

        <!-- KELAS -->
        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">
            Penempatan Kelas
          </label>

          <select name="id_kelas"
                  class="form-select"
                  required>

            <option value="">
              -- Pilih Kelas --
            </option>

            <?php foreach($data_kelas as $k): ?>

              <option value="<?= $k['id_kelas']; ?>">

                <?= esc($k['nama_kelas']); ?>

              </option>

            <?php endforeach; ?>

          </select>

        </div>

        <!-- INFO -->
        <div class="alert alert-info border-0 small mb-0 py-2">

          <i class="bi bi-info-circle me-1"></i>

          Password default siswa:
          <strong>12345678</strong>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">

          Batal

        </button>

        <button type="submit"
                class="btn btn-primary">

          Daftarkan

        </button>

      </div>

    </form>

  </div>

</div>

<!-- MODAL IMPORT EXCEL -->
<div class="modal"
     id="modalImport"
     tabindex="-1"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">

    <form method="post"
          action="<?= base_url('admin/import-siswa'); ?>"
          enctype="multipart/form-data"
          class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title fw-bold text-dark">

          Import Data Siswa Excel

        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal">
        </button>

      </div>

      <div class="modal-body text-start">

        <div class="mb-3">

          <label class="form-label fw-semibold text-secondary">

            Upload File Excel

          </label>

          <input type="file"
                 name="file_excel"
                 class="form-control"
                 accept=".xls,.xlsx"
                 required>

        </div>

        <div class="alert alert-info border-0 small mb-0">

          <i class="bi bi-info-circle me-1"></i>

          Format Excel wajib:
          <br><br>

          <strong>
            NIS | NISN | Nama Siswa | Jenis Kelamin | Kelas
          </strong>

          <hr>

          Contoh:
          <br>

          1001 | 998877 | Andi Saputra | Laki-laki | X RPL 1

        </div>

      </div>

      <div class="modal-footer">

        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">

          Batal

        </button>

        <button type="submit"
                class="btn btn-success">

          <i class="bi bi-upload"></i>
          Import Sekarang

        </button>

      </div>

    </form>

  </div>

</div>