<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Hasil extends Model
{
    protected $table            = 'tbl_hasil';
    protected $primaryKey       = 'id_hasil';
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'id_hasil',
        'id_ujian',
        'nama_siswa',
        'kelas',
        'nilai',
        'jumlah_benar',
        'jumlah_salah',
        'waktu_mulai',
        'waktu_selesai',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function autoNumber()
    {
        return $this->db->table($this->table)
            ->select('id_hasil')
            ->orderBy('id_hasil', 'DESC')
            ->limit(1)
            ->get();
    }

    public function getHasilUjian()
    {
        return $this->table($this->table)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}