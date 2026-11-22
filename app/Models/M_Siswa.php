<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Siswa extends Model
{
    protected $table            = 'tbl_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
    'id_siswa',
    'id_kelas',
    'nis',
    'nisn',
    'jenis_kelamin',
    'nama_siswa',
    'password',
    'created_at',
    'updated_at'
];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function autoNumber()
    {
        return $this->db->table($this->table)
                    ->select('id_siswa')
                    ->orderBy('id_siswa', 'DESC')
                    ->limit(1)
                    ->get();
    }

    public function getSiswaDenganKelas()
    {
        return $this->db->table($this->table)
            ->select('tbl_siswa.*, tbl_kelas.nama_kelas')
            ->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_siswa.id_kelas')
            ->orderBy('tbl_siswa.id_siswa', 'DESC')
            ->get();
    }
}