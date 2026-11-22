<?php

namespace App\Controllers;

use App\Models\M_Guru;
use App\Models\M_Siswa;
use App\Models\M_Kelas;
use App\Models\M_Ujian;
use App\Models\M_Soal;
use App\Models\M_Hasil;

use PhpOffice\PhpSpreadsheet\IOFactory;


class Admin extends BaseController
{

    public function __construct()
    {
        $this->update_status_ujian();
    }

    public function login()
    {
        // echo password_hash("developer", PASSWORD_DEFAULT) . "\n";
        if ($this->request->getMethod() == 'post') {
            $nip = $this->request->getPost('nip');
            $password = $this->request->getPost('password');

            $modelGuru = new M_Guru();
            $guru = $modelGuru->getDataGuru(['nip_guru' => $nip])->getRowArray();

            echo "NIP yang dimasukkan: $nip <br>";
            echo "Password yang dimasukkan: $password <br>";

            if ($guru) {
                echo "Data Guru ditemukan: <pre>";
                print_r($guru);
                echo "</pre>";

                if (password_verify($password, $guru['password_guru'])) {
                    session()->set([
                        'ses_id' => $guru['id_guru'],
                        'ses_user' => $guru['nip_guru'],
                        'isLoggedIn' => true
                    ]);
                    return redirect()->to(base_url('dashboard'));
                } else {
                    echo "Password tidak cocok.";
                    session()->setFlashdata('error', 'Password salah!');
                    return redirect()->back();
                }
            } else {
                echo "NIP tidak ditemukan.";
                session()->setFlashdata('error', 'NIP tidak ditemukan!');
                return redirect()->back();
            }
        }

        return view('Backend/Admin/login');
    }

    public function autentikasi()
    {
        $modelGuru = new M_Guru;

        $nip = $this->request->getPost('nip');
        $cekNip = $modelGuru->getDataGuru(['nip_guru' => $nip])->getNumRows();
        if ($cekNip == 0) {
            session()->setFlashdata('error', 'Masukkan NIP Dengan Benar!');
            return redirect()->back();
        } else {
            $dataUser = $modelGuru->getDataGuru(['nip_guru' => $nip, 'is_delete_guru' => '0'])->getRowArray();
            $password = $this->request->getPost('password');

            $verifikasi_password = password_verify($password, $dataUser['password_guru']);
            if (!$verifikasi_password) {
                session()->setFlashdata('error', 'Masukkan Password Dengan Benar!');
                return redirect()->back();
            } else {
                session()->setFlashdata('success', 'Berhasil Login!');
                $dataSession = [
                    'ses_id' => $dataUser['id_guru'],
                    'ses_user' => $dataUser['nama_guru'],
                ];
                session()->set($dataSession);
                return redirect()->to(base_url('dashboard'));
            }
        }
    }

    public function dashboard()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "") {
            session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('login'));
        }

        date_default_timezone_set('Asia/Jakarta');

        $session = session();
        $guruId  = $session->get('ses_id');

        $modelGuru  = new M_Guru();
        $modelUjian = new M_Ujian();
        $db         = \Config\Database::connect();

        $guruData         = $modelGuru->getDataGuru(['id_guru' => $guruId])->getRowArray();
        $dataUjianSidebar = $modelUjian->getDataUjian()->getResultArray();

        // Statistik utama
        $totalGuru = $db->table('tbl_guru')
            ->where('is_delete_guru', '0')
            ->countAllResults();

        $totalKelas = $db->table('tbl_kelas')
            ->countAllResults();

        $totalSiswa = $db->table('tbl_siswa')
            ->countAllResults();

        $totalUjian = $db->table('tbl_ujian')
            ->countAllResults();

        $totalHasil = $db->table('tbl_hasil')
            ->countAllResults();

        $rataNilaiRow = $db->table('tbl_hasil')
            ->select('ROUND(AVG(CAST(nilai AS DECIMAL(10,2))), 1) AS rata_nilai')
            ->get()
            ->getRowArray();
        $rataNilai = $rataNilaiRow['rata_nilai'] ?? 0;

        // Grafik nilai per ujian. LEFT JOIN membuat ujian tetap tampil walaupun belum ada hasil.
        $grafikRows = $db->table('tbl_ujian u')
            ->select('u.nama_ujian')
            ->select('COALESCE(MAX(CAST(h.nilai AS DECIMAL(10,2))), 0) AS nilai_tertinggi', false)
            ->select('COALESCE(ROUND(AVG(CAST(h.nilai AS DECIMAL(10,2))), 1), 0) AS nilai_rata_rata', false)
            ->join('tbl_hasil h', 'h.id_ujian = u.id_ujian', 'left')
            ->groupBy('u.id_ujian, u.nama_ujian')
            ->orderBy('u.created_at', 'ASC')
            ->limit(8)
            ->get()
            ->getResultArray();

        $grafikLabelUjian = [];
        $grafikTertinggi  = [];
        $grafikRataRata   = [];

        foreach ($grafikRows as $row) {
            $grafikLabelUjian[] = $row['nama_ujian'];
            $grafikTertinggi[]  = (float) $row['nilai_tertinggi'];
            $grafikRataRata[]   = (float) $row['nilai_rata_rata'];
        }

        // Jika belum ada ujian sama sekali, tampilkan chart kosong yang tetap rapi.
        if (empty($grafikLabelUjian)) {
            $grafikLabelUjian = ['Belum ada ujian'];
            $grafikTertinggi  = [0];
            $grafikRataRata   = [0];
        }

        $ujianTerbaru = $db->table('tbl_ujian u')
            ->select('u.*, k.nama_kelas')
            ->join('tbl_kelas k', 'k.id_kelas = u.id_kelas', 'left')
            ->orderBy('u.created_at', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        $logNilaiTerbaru = $db->table('tbl_hasil')
            ->orderBy('waktu_selesai', 'DESC')
            ->limit(7)
            ->get()
            ->getResultArray();

        $sebaranRows = $db->table('tbl_hasil')
            ->select('kelas AS name, COUNT(*) AS value')
            ->groupBy('kelas')
            ->orderBy('value', 'DESC')
            ->get()
            ->getResultArray();

        $sebaranPesertaKelas = [];
        foreach ($sebaranRows as $row) {
            $sebaranPesertaKelas[] = [
                'name'  => $row['name'] ?: 'Tanpa Kelas',
                'value' => (int) $row['value'],
            ];
        }

        if (empty($sebaranPesertaKelas)) {
            $sebaranPesertaKelas = [
                ['value' => 1, 'name' => 'Belum ada hasil']
            ];
        }

        $pages = 'dashboard';

        $data = [
            'guru'                  => $guruData,
            'dashboard'             => $pages,
            'pages'                 => $pages,
            'sidebar_ujian'         => $dataUjianSidebar,
            'total_guru'            => $totalGuru,
            'total_kelas'           => $totalKelas,
            'total_siswa'           => $totalSiswa,
            'total_ujian'           => $totalUjian,
            'total_hasil'           => $totalHasil,
            'rata_nilai'            => $rataNilai,
            'grafik_label_ujian'    => $grafikLabelUjian,
            'grafik_tertinggi'      => $grafikTertinggi,
            'grafik_rata_rata'      => $grafikRataRata,
            'ujian_terbaru'         => $ujianTerbaru,
            'log_nilai_terbaru'     => $logNilaiTerbaru,
            'sebaran_peserta_kelas' => $sebaranPesertaKelas,
        ];

        echo view('Backend/Template/header-admin', $data);
        echo view('Backend/Template/sidebar-admin', $data);
        echo view('Backend/Admin/dashboard', $data);
        echo view('Backend/Template/footer-admin', $data);
    }

    public function daftar_guru()
    {
        if(session()->get('ses_id') == "" or session()->get('ses_user') == ""){
            session()->setFlashdata('error','Silahkan Login Terlebih Dahulu!!');
            return redirect()->to(base_url('login'));
        }
        else{

            $session = session();
            $guruId = $session->get('ses_id');

            $modelGuru = new M_Guru;
            $modelUjian = new M_Ujian;

            $uri = service('uri');
            $pages = 'guru';
            $dataUser = $modelGuru->getDataGuru(['is_delete_guru' => '0'])->getResultArray();
            $guruData = $modelGuru->getDataGuru(['id_guru' => $guruId])->getRowArray();
            $dataUjianSidebar = $modelUjian->getDataUjian()->getResultArray();

            $kirimData['pages'] = $pages;
            $kirimData['guru'] = $guruData;
            $kirimData['data_user'] = $dataUser;
            $kirimData['sidebar_ujian'] = $dataUjianSidebar;

            echo view('Backend/Template/header-admin', $kirimData);
            echo view('Backend/Template/sidebar-admin', $kirimData);
            echo view('Backend/Admin/daftar-guru', $kirimData);
            echo view('Backend/Template/footer-admin');
        }
    }

    public function simpan_data_guru()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {
            $modelGuru = new M_Guru;

            $nama = $this->request->getPost('nama');
            $nip = $this->request->getPost('nip');
            $password = $this->request->getPost('password');

            $cekUname = $modelGuru->getDataGuru(['nip_guru' => $nip])->getNumRows();
            if ($cekUname > 0) {
                session()->setFlashdata('error', 'NIP sudah digunakan!');
                return redirect()->back();
            } else {
                $hasil = $modelGuru->autoNumber()->getRowArray();
                if (!$hasil) {
                    $id = "GUR001";
                } else {
                    $kode = $hasil['id_guru'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = "GUR" . sprintf("%03s", $noUrut);
                }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $dataSimpan = [
                    'id_guru' => $id,
                    'nama_guru' => $nama,
                    'nip_guru' => $nip,
                    'password_guru' => $hashedPassword,
                    'is_delete_guru' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelGuru->saveDataGuru($dataSimpan);
                session()->setFlashdata('success', 'Data Guru Berhasil Ditambahkan!');
                return redirect()->to(base_url('admin/daftar-guru'));
            }
        }
    }

    public function update_data_guru($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('login'));
        }

        $modelGuru = new M_Guru;

        $nama = $this->request->getPost('nama');
        $nip = $this->request->getPost('nip');
        $password = $this->request->getPost('password');

        $dataSimpan = [
            'nama_guru' => $nama,
            'nip_guru' => $nip,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($password)) {
            $dataSimpan['password_guru'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($modelGuru->updateDataGuru($dataSimpan, ['id_guru' => $id])) {
            session()->setFlashdata('success', 'Data Guru Berhasil Diperbarui!!');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data Guru.');
        }
        return redirect()->to(base_url('admin/daftar-guru'));
    }

    public function hapus_data_guru()
    {
        if(session()->get('ses_id') == "" || session()->get('ses_user') == ""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/daftar-guru'));
        }
        $modelGuru = new M_Guru;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataSimpan = [
            'is_delete_guru' => "1",
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($modelGuru->updateDataGuru($dataSimpan, ['id_guru' => $idHapus])) {
            session()->setFlashdata('success', 'Data Guru Berhasil Dihapus!!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data Guru.');
        }
        return redirect()->to(base_url('admin/daftar-guru'));
    }

public function daftar_ujian()
{
    $this->update_status_ujian();

    if(session()->get('ses_id') == "" || session()->get('ses_user') == ""){
        session()->setFlashdata('error','Silahkan Login Terlebih Dahulu!!');
        return redirect()->to(base_url('login'));
    }

    $session = session();
    $guruId = $session->get('ses_id');

    $modelGuru = new M_Guru;
    $modelUjian = new M_Ujian;
    $modelKelas = new \App\Models\M_Kelas;

    $pages = 'ujian';

    $dataUjian = $modelUjian->getDataUjian()->getResultArray();
    $guruData = $modelGuru->getDataGuru([
        'id_guru' => $guruId
    ])->getRowArray();
    $dataUjianSidebar = $modelUjian->getDataUjian()->getResultArray();
    $dataKelas = $modelKelas->findAll();

    $kirimData['pages'] = $pages;
    $kirimData['guru'] = $guruData;
    $kirimData['data_ujian'] = $dataUjian;
    $kirimData['sidebar_ujian'] = $dataUjianSidebar;
    $kirimData['data_kelas'] = $dataKelas;

    echo view('Backend/Template/header-admin', $kirimData);
    echo view('Backend/Template/sidebar-admin', $kirimData);
    echo view('Backend/Admin/daftar-ujian', $kirimData);
    echo view('Backend/Template/footer-admin');
}
public function simpan_data_ujian()
{
    $modelUjian = new M_Ujian;

    $hasil = $modelUjian->autoNumber()->getRowArray();

    if (!$hasil) {
        $id = "UJN001";
    } else {
        $kode = $hasil['id_ujian'];
        $noUrut = (int) substr($kode, -3);
        $noUrut++;
        $id = "UJN" . sprintf("%03s", $noUrut);
    }

    $dataSimpan = [
        'id_ujian' => $id,
        'id_kelas' => $this->request->getPost('id_kelas'),
        'nama_ujian' => $this->request->getPost('nama_ujian'),
        'jumlah_soal' => $this->request->getPost('jumlah_soal'),
        'waktu_mulai' => $this->request->getPost('waktu_mulai'),
        'waktu_selesai' => $this->request->getPost('waktu_selesai'),
        'durasi' => $this->request->getPost('durasi'),
        'status' => 'Belum Mulai',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $modelUjian->saveDataUjian($dataSimpan);

    session()->setFlashdata('success', 'Data Ujian Berhasil Ditambahkan!');

    return redirect()->to(base_url('daftar-ujian'));
}

public function update_data_ujian($id)
{
    $modelUjian = new M_Ujian;

    $ujian = $modelUjian->where('id_ujian', $id)->first();
    if ($ujian['status'] !== 'Belum Mulai') {
        session()->setFlashdata('error', 'Gagal! Data ujian yang sedang berlangsung atau selesai tidak boleh diubah.');
        return redirect()->to(base_url('daftar-ujian'));
    }

    $dataSimpan = [
        'id_kelas' => $this->request->getPost('id_kelas'),
        'nama_ujian' => $this->request->getPost('nama_ujian'),
        'jumlah_soal' => $this->request->getPost('jumlah_soal'),
        'waktu_mulai' => $this->request->getPost('waktu_mulai'),
        'waktu_selesai' => $this->request->getPost('waktu_selesai'),
        'durasi' => $this->request->getPost('durasi'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $modelUjian->updateDataUjian($dataSimpan, ['id_ujian' => $id]);
    session()->setFlashdata('success', 'Data Ujian Berhasil Diupdate!');
    return redirect()->to(base_url('daftar-ujian'));
}
public function hapus_data_ujian($id)
{
    if(session()->get('ses_id') == "" || session()->get('ses_user') == ""){
        session()->setFlashdata('error','Silahkan Login Terlebih Dahulu!!');
        return redirect()->to(base_url('login'));
    }

    $modelUjian = new M_Ujian();
    $modelSoal = new M_Soal();

    $modelSoal->where('id_ujian', $id)->delete();
    $modelUjian->where('id_ujian', $id)->delete();

    session()->setFlashdata('success', 'Data ujian beserta seluruh butir soal di dalamnya berhasil dihapus permanen!');
    return redirect()->to(base_url('daftar-ujian'));
}

public function update_status_ujian()
{

    date_default_timezone_set('Asia/Jakarta');

    $modelUjian = new M_Ujian;

    $dataUjian = $modelUjian->findAll();

    $sekarang = date('Y-m-d H:i:s');

    foreach ($dataUjian as $ujian) {

        $status = 'Belum Mulai';

        if (
            $sekarang >= $ujian['waktu_mulai']
            &&
            $sekarang <= $ujian['waktu_selesai']
        ) {

            $status = 'Berlangsung';

        } elseif ($sekarang > $ujian['waktu_selesai']) {

            $status = 'Selesai';
        }

        $modelUjian->update(
            $ujian['id_ujian'],
            [
                'status' => $status
            ]
        );
    }
}

public function tambah_data_soal($id_ujian)
{
    if(session()->get('ses_id') == "" || session()->get('ses_user') == ""){
        session()->setFlashdata('error','Silahkan Login Terlebih Dahulu!!');
        return redirect()->to(base_url('login'));
    }

    $session = session();
    $guruId = $session->get('ses_id');    

    $modelSoal = new M_Soal;
    $modelUjian = new M_Ujian;
    $modelGuru = new M_Guru;

    $ujian = $modelUjian->where('id_ujian', $id_ujian)->first();
    $soal = $modelSoal->where('id_ujian', $id_ujian)->findAll();

    $totalSoalSaatIni = count($soal);
    $maxSoal = (int) $ujian['jumlah_soal'];
    $apakahSudahPenuh = ($totalSoalSaatIni >= $maxSoal);

    $guruData = $modelGuru->getDataGuru(['id_guru' => $guruId])->getRowArray();
    $allUjian = $modelUjian->findAll(); 

    $data = [
        'ujian'            => $ujian,
        'soal'             => $soal,
        'guru'             => $guruData,
        'sidebar_ujian'    => $allUjian,
        'total_soal_aktif' => $totalSoalSaatIni,
        'is_full'          => $apakahSudahPenuh,
        'pages'            => 'soal'
    ];

    echo view('Backend/Template/header-admin', $data);
    echo view('Backend/Template/sidebar-admin', $data);
    echo view('Backend/Admin/tambah-soal', $data);
    echo view('Backend/Template/footer-admin');
}

public function simpan_data_soal()
{
    $modelSoal = new M_Soal();
    $hasil = $modelSoal->autoNumber()->getRowArray();

    if (!$hasil) {
        $id_soal_baru = "SOL001";
    } else {
        $kodeTerakhir = $hasil['id_soal'];
        $noUrut = (int) substr($kodeTerakhir, -3);
        $noUrut++;
        $id_soal_baru = "SOL" . sprintf("%03s", $noUrut);
    }

    $id_ujian = $this->request->getPost('id_ujian');

    $modelSoal->insert([
        'id_soal'       => $id_soal_baru,
        'id_ujian'      => $id_ujian,
        'soal'          => $this->request->getPost('soal'),
        'coretan'       => $this->request->getPost('coretan'),
        'opsi_a'        => $this->request->getPost('opsi_a'),
        'opsi_b'        => $this->request->getPost('opsi_b'),
        'opsi_c'        => $this->request->getPost('opsi_c'),
        'opsi_d'        => $this->request->getPost('opsi_d'),
        'jawaban_benar' => $this->request->getPost('jawaban_benar')
    ]);

    session()->setFlashdata('success', 'Butir soal baru berhasil disimpan ke dalam sistem!');
    return redirect()->to(base_url('tambah-data-soal/' . $id_ujian));
}
public function daftar_kelas()
{
    $modelKelas = new M_Kelas();
    $data = [
        'pages'      => 'kelas',
        'data_kelas' => $modelKelas->findAll()
    ];
    echo view('Backend/Template/header-admin', $data);
    echo view('Backend/Template/sidebar-admin', $data);
    echo view('Backend/Admin/daftar-kelas', $data);
    echo view('Backend/Template/footer-admin');
}

public function simpan_data_kelas()
{
    $modelKelas = new M_Kelas();
    $hasil = $modelKelas->autoNumber()->getRowArray();

    if (!$hasil) {
        $id_kelas_baru = "KLS001";
    } else {
        $kodeTerakhir = $hasil['id_kelas'];
        $noUrut = (int) substr($kodeTerakhir, -3);
        $noUrut++;
        $id_kelas_baru = "KLS" . sprintf("%03s", $noUrut);
    }

    $modelKelas->insert([
        'id_kelas'   => $id_kelas_baru,
        'nama_kelas' => $this->request->getPost('nama_kelas')
    ]);

    session()->setFlashdata('success', 'Data Kelas baru berhasil ditambahkan!');
    return redirect()->to(base_url('admin/daftar-kelas'));
}

public function update_data_kelas($id)
{
    $modelKelas = new M_Kelas();
    $modelKelas->update($id, ['nama_kelas' => $this->request->getPost('nama_kelas')]);
    session()->setFlashdata('success', 'Data Kelas berhasil diubah!');
    return redirect()->to(base_url('admin/daftar-kelas'));
}

public function hapus_data_kelas($id)
{
    $modelKelas = new M_Kelas();
    $modelKelas->delete($id);
    session()->setFlashdata('success', 'Data Kelas berhasil dihapus dari sistem.');
    return redirect()->to(base_url('admin/daftar-kelas'));
}

public function daftar_siswa()
{
    $modelKelas = new M_Kelas();
    $modelSiswa = new M_Siswa();

    $data = [
        'pages'      => 'siswa',
        'data_kelas' => $modelKelas->findAll(),
        'data_siswa' => $modelSiswa->getSiswaDenganKelas()->getResultArray()
    ];

    echo view('Backend/Template/header-admin', $data);
    echo view('Backend/Template/sidebar-admin', $data);
    echo view('Backend/Admin/daftar-siswa', $data);
    echo view('Backend/Template/footer-admin');
}

public function simpan_data_siswa()
{
    $modelSiswa = new M_Siswa();

    $hasil = $modelSiswa->autoNumber()->getRowArray();

    if (!$hasil) {

        $id_siswa_baru = "SIS001";

    } else {

        $kodeTerakhir = $hasil['id_siswa'];

        $noUrut = (int) substr($kodeTerakhir, -3);

        $noUrut++;

        $id_siswa_baru = "SIS" . sprintf("%03s", $noUrut);
    }

    // PASSWORD DEFAULT = NISN SISWA
    $password_default = $this->request->getPost('nisn');

    $modelSiswa->insert([

        'id_siswa'       => $id_siswa_baru,

        'id_kelas'       => $this->request->getPost('id_kelas'),

        'nis'            => $this->request->getPost('nis'),

        'nisn'           => $this->request->getPost('nisn'),

        'jenis_kelamin'  => $this->request->getPost('jenis_kelamin'),

        'nama_siswa'     => $this->request->getPost('nama_siswa'),

        'password'       => password_hash($password_default, PASSWORD_DEFAULT)

    ]);

    session()->setFlashdata(
        'success',
        'Akun resmi siswa baru berhasil dicatatkan!'
    );

    return redirect()->to(base_url('admin/daftar-siswa'));
}

public function update_data_siswa($id)
{
    $modelSiswa = new M_Siswa();

    $dataUpdate = [

        'id_kelas'      => $this->request->getPost('id_kelas'),

        'nis'           => $this->request->getPost('nis'),

        'nisn'          => $this->request->getPost('nisn'),

        'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),

        'nama_siswa'    => $this->request->getPost('nama_siswa')

    ];

    // UPDATE PASSWORD JIKA DIISI
    $password_baru = $this->request->getPost('password');

    if (!empty($password_baru)) {

        $dataUpdate['password'] = password_hash(
            $password_baru,
            PASSWORD_DEFAULT
        );
    }

    $modelSiswa->update($id, $dataUpdate);

    session()->setFlashdata(
        'success',
        'Data akun siswa berhasil disesuaikan!'
    );

    return redirect()->to(base_url('admin/daftar-siswa'));
}

public function hapus_data_siswa($id)
{
    $modelSiswa = new M_Siswa();

    $modelSiswa->delete($id);

    session()->setFlashdata(
        'success',
        'Akun siswa telah dihapus dari sistem.'
    );

    return redirect()->to(base_url('admin/daftar-siswa'));
}

public function import_siswa()
{
    $modelSiswa = new M_Siswa();
    $modelKelas = new M_Kelas();

    // AMBIL FILE
    $file = $this->request->getFile('file_excel');

    // VALIDASI FILE
    if (!$file->isValid()) {

        session()->setFlashdata(
            'error',
            'File excel gagal diupload!'
        );

        return redirect()->back();
    }

    // LOAD EXCEL
    $spreadsheet = IOFactory::load(
        $file->getTempName()
    );

    $sheet = $spreadsheet->getActiveSheet();

    $rows = $sheet->toArray();

    // LOOP DATA EXCEL
    foreach ($rows as $row) {

        /*
        FORMAT EXCEL

        A = NO
        B = NIS
        C = NISN
        D = JK
        E = NAMA SISWA
        F = KELAS
        */

        // SKIP JIKA NIS KOSONG
        if (empty($row[1])) {
            continue;
        }

        // AMBIL DATA
        $nis = trim($row[1]);

        $nisn = trim(
            str_replace("'", "", $row[2])
        );

        $jk_excel = strtoupper(
            trim($row[3])
        );

        $nama_siswa = trim($row[4]);

        $nama_kelas = trim($row[5]);

        // KONVERSI JK
        if ($jk_excel == 'L') {

            $jenis_kelamin = 'Laki-laki';

        } else {

            $jenis_kelamin = 'Perempuan';
        }

        // CARI KELAS
        $kelas = $modelKelas
                    ->where(
                        'nama_kelas',
                        $nama_kelas
                    )
                    ->first();

        // JIKA KELAS TIDAK DITEMUKAN
        if (!$kelas) {

            continue;
        }

        // AUTO NUMBER SISWA
        $hasil = $modelSiswa
                    ->autoNumber()
                    ->getRowArray();

        if (!$hasil) {

            $id_siswa_baru = "SIS001";

        } else {

            $kodeTerakhir = $hasil['id_siswa'];

            $noUrut = (int) substr(
                $kodeTerakhir,
                -3
            );

            $noUrut++;

            $id_siswa_baru = "SIS" .
                sprintf("%03s", $noUrut);
        }

        // CEK DUPLIKAT NIS
        $cekNis = $modelSiswa
                    ->where('nis', $nis)
                    ->first();

        if ($cekNis) {
            continue;
        }

        // INSERT DATA
        $modelSiswa->insert([

            'id_siswa'       => $id_siswa_baru,

            'id_kelas'       => $kelas['id_kelas'],

            'nis'            => $nis,

            'nisn'           => $nisn,

            'jenis_kelamin'  => $jenis_kelamin,

            'nama_siswa'     => $nama_siswa,

            'password'       => password_hash(
                                    $nisn,
                                    PASSWORD_DEFAULT
                               )
        ]);
    }

    session()->setFlashdata(
        'success',
        'Import data siswa berhasil!'
    );

    return redirect()->to(
        base_url('admin/daftar-siswa')
    );
}

public function daftar_hasil_ujian()
{
    if (session()->get('ses_id') == "" || session()->get('ses_user') == "") {
        session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
        return redirect()->to(base_url('login'));
    }

    $modelHasil = new M_Hasil();
    $modelUjian = new M_Ujian();

    $data = [
        'pages'        => 'hasil_ujian',
        'sidebar_ujian'=> $modelUjian->getDataUjian()->getResultArray(),
        'data_hasil'   => $modelHasil->getHasilUjian()->getResultArray()
    ];

    echo view('Backend/Template/header-admin', $data);
    echo view('Backend/Template/sidebar-admin', $data);
    echo view('Backend/Admin/daftar-hasil', $data);
    echo view('Backend/Template/footer-admin');
}


public function hapus_data_hasil($id)
{
    if (session()->get('ses_id') == "" || session()->get('ses_user') == "") {
        session()->setFlashdata('error', 'Silahkan Login Terlebih Dahulu!!');
        return redirect()->to(base_url('login'));
    }

    $modelHasil = new M_Hasil();
    $cekHasil = $modelHasil->find($id);

    if (!$cekHasil) {
        session()->setFlashdata('error', 'Data hasil ujian tidak ditemukan.');
        return redirect()->to(base_url('admin/daftar-hasil-ujian'));
    }

    $modelHasil->delete($id);

    session()->setFlashdata('success', 'Data hasil ujian berhasil dihapus.');
    return redirect()->to(base_url('admin/daftar-hasil-ujian'));
}

public function logout()
{
    if (
        session()->get('ses_id') == "" ||
        session()->get('ses_user') == ""
    ) {

        session()->setFlashdata(
            'error',
            'Silahkan Login Terlebih Dahulu!!'
        );

        return redirect()->to(base_url('login'));
    }

    session()->destroy();

    return redirect()->to(base_url('login'));
}



}

