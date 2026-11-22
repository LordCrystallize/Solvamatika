<style>
  :root {
    --dash-primary: #4154f1;
    --dash-success: #2eca6a;
    --dash-warning: #ffb347;
    --dash-danger: #ff6b6b;
    --dash-dark: #1f2937;
    --dash-muted: #6b7280;
    --dash-soft: #f6f8ff;
    --dash-border: rgba(31, 41, 55, .08);
  }

  .dashboard-hero {
    position: relative;
    overflow: hidden;
    border: 0;
    border-radius: 24px;
    color: #fff;
    background: linear-gradient(135deg, #2336d8 0%, #5264ff 52%, #2eca6a 100%);
    box-shadow: 0 18px 45px rgba(65, 84, 241, .24);
  }

  .dashboard-hero::before,
  .dashboard-hero::after {
    content: "";
    position: absolute;
    border-radius: 999px;
    background: rgba(255, 255, 255, .14);
  }

  .dashboard-hero::before {
    width: 260px;
    height: 260px;
    right: -90px;
    top: -90px;
  }

  .dashboard-hero::after {
    width: 170px;
    height: 170px;
    right: 170px;
    bottom: -95px;
  }

  .dashboard-hero .card-body {
    position: relative;
    z-index: 2;
    padding: 28px;
  }

  .dashboard-hero h2 {
    margin: 0 0 8px;
    font-weight: 800;
    letter-spacing: -.03em;
  }

  .dashboard-hero p {
    max-width: 720px;
    margin: 0;
    color: rgba(255, 255, 255, .86);
  }

  .dash-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .16);
    color: #fff;
    font-size: .86rem;
    font-weight: 700;
    backdrop-filter: blur(8px);
  }

  .dash-card {
    border: 0;
    border-radius: 22px;
    box-shadow: 0 10px 32px rgba(31, 41, 55, .07);
    overflow: hidden;
  }

  .dash-card .card-body {
    padding: 22px;
  }

  .stat-card {
    height: 100%;
    border: 1px solid var(--dash-border);
    border-radius: 22px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(31, 41, 55, .06);
    transition: .2s ease;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 38px rgba(31, 41, 55, .1);
  }

  .stat-card .card-body {
    padding: 20px;
  }

  .stat-icon {
    width: 54px;
    height: 54px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.55rem;
  }

  .stat-icon.primary { background: rgba(65, 84, 241, .12); color: var(--dash-primary); }
  .stat-icon.success { background: rgba(46, 202, 106, .14); color: #169a4c; }
  .stat-icon.warning { background: rgba(255, 179, 71, .18); color: #b36b00; }
  .stat-icon.danger { background: rgba(255, 107, 107, .14); color: #d92d20; }

  .stat-label {
    color: var(--dash-muted);
    font-size: .85rem;
    font-weight: 700;
  }

  .stat-value {
    margin: 4px 0 0;
    color: var(--dash-dark);
    font-size: 2rem;
    font-weight: 850;
    letter-spacing: -.04em;
  }

  .stat-subtitle {
    display: block;
    margin-top: 6px;
    color: #8a94a6;
    font-size: .78rem;
  }

  .section-title-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
  }

  .section-title-modern h5 {
    margin: 0;
    color: var(--dash-dark);
    font-weight: 800;
    letter-spacing: -.02em;
  }

  .section-title-modern span {
    color: var(--dash-muted);
    font-size: .85rem;
  }

  .table-modern {
    min-width: 720px;
  }

  .table-modern thead th {
    color: #7a8497;
    font-size: .78rem;
    letter-spacing: .02em;
    text-transform: uppercase;
    border-bottom: 1px solid var(--dash-border);
    white-space: nowrap;
  }

  .table-modern tbody td,
  .table-modern tbody th {
    vertical-align: middle;
    padding-top: 14px;
    padding-bottom: 14px;
  }

  .activity-modern {
    position: relative;
  }

  .activity-item-modern {
    display: grid;
    grid-template-columns: 58px 16px 1fr;
    gap: 10px;
    padding: 0 0 18px;
  }

  .activity-time {
    color: #8a94a6;
    font-size: .8rem;
    font-weight: 800;
  }

  .activity-dot {
    width: 12px;
    height: 12px;
    margin-top: 3px;
    border-radius: 999px;
    background: var(--dash-success);
    box-shadow: 0 0 0 5px rgba(46, 202, 106, .12);
  }

  .activity-text {
    color: #374151;
    font-size: .88rem;
    line-height: 1.55;
  }

  .empty-state {
    padding: 34px 16px;
    text-align: center;
    color: var(--dash-muted);
    background: linear-gradient(180deg, #f9fbff, #fff);
    border: 1px dashed rgba(65, 84, 241, .22);
    border-radius: 18px;
  }

  .empty-state i {
    display: block;
    margin-bottom: 8px;
    color: var(--dash-primary);
    font-size: 2rem;
  }

  .chart-wrap {
    min-height: 340px;
  }

  .pie-wrap {
    min-height: 360px;
  }

  @media (max-width: 1199.98px) {
    .dashboard-hero .card-body { padding: 24px; }
    .stat-value { font-size: 1.75rem; }
  }

  @media (max-width: 767.98px) {
    .pagetitle h1 { font-size: 1.35rem; }
    .dashboard-hero { border-radius: 18px; }
    .dashboard-hero .card-body { padding: 22px; }
    .dashboard-hero h2 { font-size: 1.35rem; }
    .dashboard-hero p { font-size: .92rem; }
    .section-title-modern { align-items: flex-start; flex-direction: column; }
    .chart-wrap { min-height: 300px; }
    .pie-wrap { min-height: 320px; }
    .stat-card .card-body { padding: 18px; }
  }
</style>

<main id="main" class="main">

  <div class="pagetitle mb-3">
    <h1>Dashboard Analisis</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="card dashboard-hero mb-4">
      <div class="card-body">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
          <div>
            <div class="dash-chip mb-3"><i class="bi bi-speedometer2"></i> Sistem CBT Solvamatika</div>
            <h2>Selamat datang, <?= esc($guru['nama_guru'] ?? 'Admin'); ?> 👋</h2>
            <p>Pantau data guru, siswa, kelas, ujian, dan hasil pengerjaan siswa dari satu dashboard yang ringkas dan responsif.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('admin/daftar-ujian'); ?>" class="btn btn-light fw-bold rounded-pill px-4">
              <i class="bi bi-plus-circle me-1"></i> Kelola Ujian
            </a>
            <a href="<?= base_url('admin/daftar-hasil'); ?>" class="btn btn-outline-light fw-bold rounded-pill px-4">
              <i class="bi bi-clipboard-data me-1"></i> Lihat Hasil
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3 g-xl-4 mb-4">
      <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon primary"><i class="bi bi-person-badge"></i></div>
            <div>
              <div class="stat-label">Total Guru</div>
              <div class="stat-value"><?= number_format((int)($total_guru ?? 0), 0, ',', '.'); ?></div>
              <span class="stat-subtitle">Pengampu evaluasi aktif</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon success"><i class="bi bi-people"></i></div>
            <div>
              <div class="stat-label">Total Siswa</div>
              <div class="stat-value"><?= number_format((int)($total_siswa ?? 0), 0, ',', '.'); ?></div>
              <span class="stat-subtitle">Peserta terdata</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon warning"><i class="bi bi-building"></i></div>
            <div>
              <div class="stat-label">Total Kelas</div>
              <div class="stat-value"><?= number_format((int)($total_kelas ?? 0), 0, ',', '.'); ?></div>
              <span class="stat-subtitle">Rombel aktif</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon danger"><i class="bi bi-clipboard-check"></i></div>
            <div>
              <div class="stat-label">Hasil Masuk</div>
              <div class="stat-value"><?= number_format((int)($total_hasil ?? 0), 0, ',', '.'); ?></div>
              <span class="stat-subtitle">Rata-rata nilai: <?= esc($rata_nilai ?? 0); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-12 col-xl-8">
        <div class="card dash-card mb-4">
          <div class="card-body">
            <div class="section-title-modern">
              <div>
                <h5>Statistik Nilai Ujian</h5>
                <span>Perbandingan nilai tertinggi dan rata-rata setiap ujian</span>
              </div>
              <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle">Total Ujian: <?= (int)($total_ujian ?? 0); ?></span>
            </div>
            <div id="reportsChart" class="chart-wrap"></div>
          </div>
        </div>

        <div class="card dash-card">
          <div class="card-body">
            <div class="section-title-modern">
              <div>
                <h5>Aktivitas Ujian Terbaru</h5>
                <span>Status jadwal ujian yang baru dibuat</span>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover table-modern align-middle mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama Ujian</th>
                    <th>Kelas</th>
                    <th>Durasi</th>
                    <th>Soal</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($ujian_terbaru)) : foreach ($ujian_terbaru as $uj) : ?>
                    <tr>
                      <th><code><?= esc($uj['id_ujian']); ?></code></th>
                      <td><strong><?= esc($uj['nama_ujian']); ?></strong></td>
                      <td><?= esc($uj['nama_kelas'] ?? '-'); ?></td>
                      <td><?= esc($uj['durasi']); ?> menit</td>
                      <td><?= esc($uj['jumlah_soal']); ?> butir</td>
                      <td>
                        <?php
                          $now   = time();
                          $start = strtotime($uj['waktu_mulai']);
                          $end   = strtotime($uj['waktu_selesai']);

                          if ($now < $start) {
                              echo '<span class="badge rounded-pill bg-secondary">Belum Mulai</span>';
                          } elseif ($now >= $start && $now <= $end) {
                              echo '<span class="badge rounded-pill bg-success">Berlangsung</span>';
                          } else {
                              echo '<span class="badge rounded-pill bg-danger">Selesai</span>';
                          }
                        ?>
                      </td>
                    </tr>
                  <?php endforeach; else : ?>
                    <tr>
                      <td colspan="6">
                        <div class="empty-state"><i class="bi bi-calendar-x"></i>Belum ada data ujian.</div>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-xl-4">
        <div class="card dash-card mb-4">
          <div class="card-body">
            <div class="section-title-modern">
              <div>
                <h5>Log Submit Nilai</h5>
                <span>Aktivitas pengerjaan terbaru</span>
              </div>
            </div>

            <div class="activity-modern">
              <?php if (!empty($log_nilai_terbaru)) : foreach ($log_nilai_terbaru as $log) : ?>
                <div class="activity-item-modern">
                  <div class="activity-time"><?= date('H:i', strtotime($log['waktu_selesai'])); ?></div>
                  <div class="activity-dot"></div>
                  <div class="activity-text">
                    <strong><?= esc($log['nama_siswa']); ?></strong><br>
                    <span class="text-muted"><?= esc($log['kelas']); ?></span> mendapat nilai
                    <span class="badge bg-light text-primary border border-primary fw-bold"><?= esc($log['nilai']); ?></span>
                  </div>
                </div>
              <?php endforeach; else : ?>
                <div class="empty-state"><i class="bi bi-inbox"></i>Belum ada hasil ujian yang masuk.</div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="card dash-card">
          <div class="card-body pb-2">
            <div class="section-title-modern">
              <div>
                <h5>Sebaran Partisipasi</h5>
                <span>Jumlah submit hasil berdasarkan kelas</span>
              </div>
            </div>
            <div id="trafficChart" class="pie-wrap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const chartEl = document.querySelector("#reportsChart");
    if (chartEl && typeof ApexCharts !== 'undefined') {
      new ApexCharts(chartEl, {
        series: [{
          name: 'Nilai Tertinggi',
          data: <?= json_encode($grafik_tertinggi ?? [0]); ?>
        }, {
          name: 'Nilai Rata-rata',
          data: <?= json_encode($grafik_rata_rata ?? [0]); ?>
        }],
        chart: {
          height: 350,
          type: 'area',
          toolbar: { show: false },
          fontFamily: 'Nunito, sans-serif'
        },
        markers: { size: 4 },
        colors: ['#4154f1', '#2eca6a'],
        fill: {
          type: "gradient",
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.32,
            opacityTo: 0.08,
            stops: [0, 90, 100]
          }
        },
        grid: {
          borderColor: '#eef1f7',
          strokeDashArray: 4
        },
        dataLabels: { enabled: false },
        stroke: {
          curve: 'smooth',
          width: 3
        },
        yaxis: {
          min: 0,
          max: 100,
          labels: {
            formatter: function(value) {
              return Math.round(value);
            }
          }
        },
        xaxis: {
          categories: <?= json_encode($grafik_label_ujian ?? ['Belum ada ujian']); ?>,
          labels: {
            trim: true,
            rotate: -20,
            style: { fontSize: '12px' }
          }
        },
        tooltip: {
          y: {
            formatter: function(value) {
              return value + ' poin';
            }
          }
        }
      }).render();
    }

    const pieEl = document.querySelector("#trafficChart");
    if (pieEl && typeof echarts !== 'undefined') {
      const pieChart = echarts.init(pieEl);
      pieChart.setOption({
        tooltip: { trigger: 'item' },
        legend: {
          type: 'scroll',
          bottom: 0,
          left: 'center'
        },
        series: [{
          name: 'Jumlah Submit',
          type: 'pie',
          radius: ['42%', '70%'],
          center: ['50%', '44%'],
          avoidLabelOverlap: true,
          itemStyle: {
            borderRadius: 8,
            borderColor: '#fff',
            borderWidth: 2
          },
          label: {
            formatter: '{b}\n{c} submit',
            fontSize: 12
          },
          emphasis: {
            label: {
              show: true,
              fontSize: 16,
              fontWeight: 'bold'
            }
          },
          data: <?= json_encode($sebaran_peserta_kelas ?? [['value' => 1, 'name' => 'Belum ada hasil']]); ?>
        }]
      });

      window.addEventListener('resize', function() {
        pieChart.resize();
      });
    }
  });
</script>
