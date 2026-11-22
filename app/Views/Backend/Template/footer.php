<footer id="footer" class="footer light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        
        <!-- Kolom Informasi Platform -->
        <div class="col-lg-4 col-md-6 footer-info">
          <a href="<?= base_url(); ?>" class="logo d-flex align-items-center mb-4">
            <span class="sitename">Solvamatika</span>
          </a>
          <p>Platform Computer Based Test (CBT) modern yang dirancang untuk mempermudah pelaksanaan evaluasi belajar, ujian harian, dan analisis hasil ujian secara real-time dan akurat.</p>

          <div class="social-links d-flex mt-4">
            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          </div>
        </div>

        <!-- Kolom Tautan Siswa -->
        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Menu Siswa</h4>
          <ul>
            <li><a href="<?= base_url(); ?>">Home</a></li>
            <li><a href="<?= base_url('#services'); ?>">Jadwal Ujian</a></li>
            <li><a href="#">Lihat Nilai</a></li>
            <li><a href="#">Panduan CBT</a></li>
          </ul>
        </div>

        <!-- Kolom Tautan Layanan/Bantuan -->
        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Bantuan &amp; Dukungan</h4>
          <ul>
            <li><a href="#">Pusat Bantuan</a></li>
            <li><a href="#">FAQ Sistem Ujian</a></li>
            <li><a href="#">Laporkan Kendala Teknis</a></li>
            <li><a href="#">Kontak Admin Sekolah</a></li>
          </ul>
        </div>

        <!-- Kolom Info Akses Cepat -->
        <div class="col-lg-3 col-md-6">
          <div class="footer-newsletter">
            <h4>Akses Portal Guru</h4>
            <p>Untuk bapak/ibu guru yang ingin mengelola kelas, menjadwalkan evaluasi baru, atau membuat soal, silakan masuk melalui tautan di bawah ini.</p>
            <div class="mt-3">
              <a href="<?= base_url('login'); ?>" class="btn btn-primary w-100 py-2 fw-semibold text-white shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login Dashboard Guru
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Bagian Hak Cipta & Legalitas -->
    <div class="container footer-bottom">
      <div class="row gy-3">
        <div class="col-md-6 order-2 order-md-1">
          <div class="copyright">
            <p>© <span>Copyright</span> <strong class="sitename">Solvamatika</strong> 2026. All Rights Reserved.</p>
          </div>
        </div>
        <div class="col-md-6 order-1 order-md-2">
          <div class="legal-links">
            <a href="#">Syarat &amp; Ketentuan</a>
            <a href="#">Kebijakan Privasi</a>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/php-email-form/validate.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/aos/aos.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/isotope-layout/isotope.pkgd.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/purecounter/purecounter_vanilla.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/swiper/swiper-bundle.min.js'); ?>"></script>

  <!-- Main JS File -->
  <script src="<?= base_url('assets/js/main.js'); ?>"></script>

</body>

</html>