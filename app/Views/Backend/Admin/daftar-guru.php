<main id="main" class="main">
  <div class="pagetitle">
    <h1>Daftar Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Guru</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="row bg-white ms-1 pb-3 rounded border border-1 shadow" style="width: 100%">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
      <h3>Data Guru</h3>
      <div>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Guru</button>
      </div>
    </div>
    <hr>
    <div class="table-responsive">
      <table id="table" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Guru</th>
            <th>NIP Guru</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($data_user as $data) : ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nama_guru']; ?></td>
            <td><?= $data['nip_guru']; ?></td>
            <td>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id_guru']; ?>" title="Edit">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $data['id_guru']; ?>" data-name="<?= $data['nama_guru']; ?>" title="Hapus">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" action="<?= base_url('simpan-data-guru'); ?>" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Guru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Guru</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">NIP Guru</label>
            <input type="text" name="nip" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Edit (Ditempatkan di luar table) -->
  <?php foreach ($data_user as $data): ?>
  <div class="modal fade" id="modalEdit<?= $data['id_guru']; ?>" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" action="<?= base_url('update-data-guru/' . $data['id_guru']); ?>" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Guru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Guru</label>
            <input type="text" name="nama" class="form-control" value="<?= esc($data['nama_guru']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">NIP Guru</label>
            <input type="text" name="nip" class="form-control" value="<?= esc($data['nip_guru']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password <small>(Kosongkan jika tidak diubah)</small></label>
            <input type="password" name="password" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <?php endforeach; ?>

  <!-- Modal Hapus -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data Guru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus data guru <strong id="guruName"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Hapus</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  const deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');

    document.getElementById('guruName').textContent = name;
    document.getElementById('confirmDeleteBtn').href = "<?= base_url('hapus-data-guru/') ?>" + id;
  });
</script>
