<?php

namespace App\Controllers;

use App\Models\M_Ujian;
use App\Models\M_Soal;
use App\Models\M_Siswa;
use App\Models\M_Hasil;

class Home extends BaseController
{
    public function home()
    {
        $modelUjian = new M_Ujian();
        $dataUjian = $modelUjian->getDataUjian()->getResultArray();

        $data = [
            'sidebar_ujian' => $dataUjian
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Home/home', $data);
        echo view('Backend/Template/footer');
    }

    public function konfirmasi_peserta($id_ujian)
    {
        $modelUjian = new M_Ujian();
        $ujian = $modelUjian->where('id_ujian', $id_ujian)->first();

        if (!$ujian) {
            session()->setFlashdata('error', 'Ujian tidak ditemukan!');
            return redirect()->to(base_url());
        }

        $data = ['ujian' => $ujian];
        return view('Backend/Home/konfirmasi-peserta', $data);
    }

public function validasi_peserta()
    {
        $id_ujian = $this->request->getPost('id_ujian');
        $nisn = $this->request->getPost('nisn');
        $password_input = $this->request->getPost('password');

        if (empty($nisn) || empty($password_input)) {
            session()->setFlashdata('error', 'NISN dan Password wajib diisi!');
            return redirect()->back();
        }

        $modelSiswa = new M_Siswa();
        $siswa = $modelSiswa->db->table('tbl_siswa')
            ->select('tbl_siswa.*, tbl_kelas.nama_kelas')
            ->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_siswa.id_kelas')
            ->where('tbl_siswa.nisn', $nisn)
            ->get()
            ->getRowArray();

        if (!$siswa || ($password_input !== $siswa['nisn'] && !password_verify($password_input, $siswa['password']))) {
            session()->setFlashdata('error', 'NISN atau Password salah! Password default sama dengan NISN.');
            return redirect()->back();
        }

        $modelUjian = new M_Ujian();
        $ujian_data = $modelUjian->where('id_ujian', $id_ujian)->first();
        
        if (!$ujian_data) {
            session()->setFlashdata('error', 'Data ujian tidak valid!');
            return redirect()->back();
        }

        $kelas_terpilih = explode(',', $ujian_data['id_kelas'] ?? '');

        if (!in_array($siswa['id_kelas'], $kelas_terpilih)) {
            session()->setFlashdata('error', 'Kelas Anda tidak didaftarkan untuk mengikuti ujian ini!');
            return redirect()->back();
        }

        session()->set([
            'siswa_id'          => $siswa['id_siswa'],
            'siswa_nisn'        => $siswa['nisn'],
            'siswa_nama'        => $siswa['nama_siswa'],
            'siswa_kelas'       => $siswa['nama_kelas'],
            'ujian_mulai_' . $id_ujian => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('ragam-ujian/mulai/' . $id_ujian));
    }
    
    public function mulai_ujian($id_ujian)
    {
        if (!session()->get('siswa_nama')) {
            return redirect()->to(base_url('ragam-ujian/konfirmasi/' . $id_ujian));
        }

        $modelUjian = new M_Ujian();
        $modelSoal = new M_Soal();

        $ujian = $modelUjian->where('id_ujian', $id_ujian)->first();
        $soal = $modelSoal->where('id_ujian', $id_ujian)->findAll();

        date_default_timezone_set('Asia/Jakarta');
        $waktu_sekarang = time();
        $waktu_selesai  = strtotime($ujian['waktu_selesai']);

        $sisa_detik = $waktu_selesai - $waktu_sekarang;

        if ($sisa_detik <= 0) {
            return redirect()->to(base_url('ragam-ujian/hasil/' . $id_ujian));
        }

        $data = [
            'ujian'       => $ujian,
            'daftar_soal' => $soal,
            'total_soal'  => count($soal),
            'sisa_detik'  => $sisa_detik
        ];
        
        return view('Backend/Home/ruang-ujian', $data);
    }

    public function simpan_jawaban()
    {
        if (!session()->get('siswa_nama')) {
            session()->setFlashdata('error', 'Silakan login sebagai peserta ujian terlebih dahulu.');
            return redirect()->to(base_url());
        }

        date_default_timezone_set('Asia/Jakarta');

        $modelSoal  = new M_Soal();
        $modelHasil = new M_Hasil();

        $id_ujian = $this->request->getPost('id_ujian');
        $jawaban_siswa = $this->request->getPost('jawaban') ?? [];

        $daftar_soal = $modelSoal->where('id_ujian', $id_ujian)->findAll();
        
        $benar = 0;
        $salah = 0;
        $total_soal = count($daftar_soal);

        foreach ($daftar_soal as $s) {
            $id_soal = $s['id_soal'];
            $kunci = $s['jawaban_benar'];
 
            $pilihan_siswa = isset($jawaban_siswa[$id_soal]) ? $jawaban_siswa[$id_soal] : '-';

            if ($pilihan_siswa === $kunci) {
                $benar++;
            } else {
                $salah++;
            }
        }

        $nilai_akhir = ($total_soal > 0) ? round(($benar / $total_soal) * 100, 2) : 0;
        $waktu_mulai = session()->get('ujian_mulai_' . $id_ujian) ?: date('Y-m-d H:i:s');
        $waktu_selesai = date('Y-m-d H:i:s');

        $hasilTerakhir = $modelHasil->autoNumber()->getRowArray();
        if (!$hasilTerakhir) {
            $id_hasil = 'HSL001';
        } else {
            $noUrut = (int) substr($hasilTerakhir['id_hasil'], -3);
            $noUrut++;
            $id_hasil = 'HSL' . sprintf('%03s', $noUrut);
        }

        $modelHasil->insert([
            'id_hasil'       => $id_hasil,
            'id_ujian'       => $id_ujian,
            'nama_siswa'     => session()->get('siswa_nama'),
            'kelas'          => session()->get('siswa_kelas'),
            'nilai'          => $nilai_akhir,
            'jumlah_benar'   => $benar,
            'jumlah_salah'   => $salah,
            'waktu_mulai'    => $waktu_mulai,
            'waktu_selesai'  => $waktu_selesai,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('hasil_ujian_' . $id_ujian, [
            'nama'        => session()->get('siswa_nama'),
            'kelas'       => session()->get('siswa_kelas'),
            'total_soal'  => $total_soal,
            'benar'       => $benar,
            'salah'       => $salah,
            'nilai'       => $nilai_akhir,
            'pilihan'     => $jawaban_siswa
        ]);

        session()->remove('ujian_mulai_' . $id_ujian);

        return redirect()->to(base_url('ragam-ujian/hasil/' . $id_ujian));
    }

    public function hasil_ujian($id_ujian)
    {
        $modelUjian = new M_Ujian();
        $modelSoal = new M_Soal();

        $ujian = $modelUjian->where('id_ujian', $id_ujian)->first();
        $soal = $modelSoal->where('id_ujian', $id_ujian)->findAll();

        $review = session()->getFlashdata('hasil_ujian_' . $id_ujian);

        if (!$review) {
            session()->setFlashdata('error', 'Waktu ujian telah berakhir.');
            return redirect()->to(base_url());
        }

        $data = [
            'ujian'       => $ujian,
            'daftar_soal' => $soal,
            'review'      => $review
        ];

        return view('Backend/Home/hasil-ujian', $data);
    }
}