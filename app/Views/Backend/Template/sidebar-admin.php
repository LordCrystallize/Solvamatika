<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Bagian Dashboard -->
    <li class="nav-item">
      <!-- Jika halaman aktif, hapus class 'collapsed' -->
      <a class="nav-link <?= (isset($pages) && $pages == 'dashboard') ? '' : 'collapsed'; ?>" href="<?= base_url('dashboard'); ?>">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- Bagian Daftar Guru -->
    <li class="nav-item">
      <!-- Jika halaman aktif, hapus class 'collapsed' -->
      <a class="nav-link <?= (isset($pages) && $pages == 'guru') ? '' : 'collapsed'; ?>" href="<?= base_url('daftar-guru'); ?>">
        <i class="bi bi-person"></i>
        <span>Daftar Guru</span>
      </a>
    </li>
      
    <li class="nav-item">
  <a class="nav-link <?= ($pages === 'kelas') ? '' : 'collapsed'; ?>" href="<?= base_url('admin/daftar-kelas'); ?>">
    <i class="bi bi-building"></i>
    <span>Daftar Kelas</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link <?= ($pages === 'siswa') ? '' : 'collapsed'; ?>" href="<?= base_url('admin/daftar-siswa'); ?>">
    <i class="bi bi-people"></i>
    <span>Daftar Siswa</span>
  </a>
</li>

    <!-- Bagian Daftar Ujian Cascading -->
    <li class="nav-item">
      <div class="d-flex align-items-center position-relative structure-nav-group">
        
        <!-- Jika sedang di halaman ujian/soal, hilangkan class collapsed -->
        <a class="nav-link <?= (isset($pages) && ($pages == 'ujian' || $pages == 'soal')) ? '' : 'collapsed'; ?> w-100 pe-5" href="<?= base_url('daftar-ujian'); ?>">
          <i class="bi bi-menu-button-wide"></i>
          <span>Daftar Ujian</span>
        </a>
        
        <button class="btn border-0 p-0 position-absolute end-0 me-3 text-secondary text-opacity-70 style-arrow-trigger"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#ujian-nav"
                aria-expanded="true">
          <i class="bi bi-chevron-down fs-6"></i>
        </button>
      </div>
      
      <!-- Jika sedang di halaman ujian/soal, paksa dropdown-nya tetap terbuka ('show') -->
      <ul id="ujian-nav" class="nav-content collapse <?= (isset($pages) && ($pages == 'ujian' || $pages == 'soal')) ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
        <?php if(empty($sidebar_ujian)) : ?>
          
        <li class="pe-3 ps-2 py-2 my-1">
          <div class="p-3 rounded-3 bg-light border border-dashed text-center">
            <i class="bi bi-calendar-x d-block text-muted mb-2 fs-5"></i>
            <div class="fw-medium text-dark small mb-1" style="font-size: 0.8rem;">Belum Ada Ujian</div>
            <p class="text-muted mb-2" style="font-size: 0.72rem; line-height: 1.3;">
              Jadwal atau subjek evaluasi belum dibuat oleh guru.
            </p>
            <a href="<?= base_url('admin/daftar-ujian?action=tambah'); ?>" id="btnSidebarTambahUjian" class="btn btn-outline-primary" style="font-size: 0.75rem;">
              <i class="bi bi-plus-lg me-1"></i> Buat Ujian Baru
            </a>
          </div>
        </li>

        <?php else : ?>
          
          <?php foreach($sidebar_ujian as $su) : ?>
            <?php
              date_default_timezone_set('Asia/Jakarta');
              $sekarang_side = time();
              $mulai_side    = strtotime($su['waktu_mulai']);
              $selesai_side  = strtotime($su['waktu_selesai']);

              if ($sekarang_side < $mulai_side) {
                  $status_side = 'Belum Mulai';
              } elseif ($sekarang_side >= $mulai_side && $sekarang_side <= $selesai_side) {
                  $status_side = 'Berlangsung';
              } else {
                  $status_side = 'Selesai';
              }
            ?>

            <li>
              <?php if ($status_side === 'Belum Mulai') : ?>
                <!-- Link Aktif Menuju Tambah Soal -->
                <a href="<?= base_url('tambah-data-soal/' . $su['id_ujian']); ?>">
                  <i class="bi bi-circle"></i>
                  <span><?= esc($su['nama_ujian']); ?></span>
                </a>
              <?php else : ?>
                <!-- Link Terkunci: Diarahkan kembali ke daftar ujian jika diklik -->
                <a href="<?= base_url('daftar-ujian'); ?>" class="text-muted text-decoration-line-through" title="Ujian <?= strtolower($status_side); ?> (Akses Tambah Soal Ditutup)">
                  <i class="bi bi-lock-fill text-danger small"></i>
                  <span><?= esc($su['nama_ujian']); ?></span>
                </a>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>

        <?php endif; ?>
      </ul>
    </li>

    <!-- Bagian Daftar Hasil -->
    <li class="nav-item">

  <a class="nav-link <?= ($pages == 'hasil_ujian') ? '' : 'collapsed'; ?>"
     data-bs-target="#hasil-ujian-nav"
     data-bs-toggle="collapse"
     href="#">

    <i class="bi bi-clipboard-data"></i>

    <span>Daftar Hasil</span>

    <i class="bi bi-chevron-down ms-auto"></i>

  </a>

  <ul id="hasil-ujian-nav"
      class="nav-content collapse <?= ($pages == 'hasil_ujian') ? 'show' : ''; ?>"
      data-bs-parent="#sidebar-nav">

    <li>

      <a href="<?= base_url('admin/daftar-hasil-ujian'); ?>"
         class="<?= ($pages == 'hasil_ujian') ? 'active' : ''; ?>">

        <i class="bi bi-circle"></i>

        <span>Hasil Ujian</span>

      </a>

    </li>

  </ul>

</li>

    <!-- Bagian Log Out -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('logout'); ?>">
        <i class="bi bi-box-arrow-right"></i>
        <span>Log Out</span>
      </a>
    </li>

  </ul>
</aside>