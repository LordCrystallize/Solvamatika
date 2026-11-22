<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Ujian extends Model
{
    protected $table = 'tbl_ujian';
    protected $primaryKey = 'id_ujian';

    protected $allowedFields = [
        'id_ujian',
        'id_kelas',
        'nama_ujian',
        'jumlah_soal',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDataUjian($where = false)
    {
        $builder = $this->db->table($this->table);

        $builder->select('*');

        if ($where !== false) {
            $builder->where($where);
        }

        $builder->orderBy('created_at', 'DESC');

        return $builder->get();
    }

    public function saveDataUjian($data)
    {
        $builder = $this->db->table($this->table);

        return $builder->insert($data);
    }

    public function updateDataUjian($data, $where)
    {
        $builder = $this->db->table($this->table);

        $builder->where($where);

        return $builder->update($data);
    }

    public function autoNumber()
    {
        $builder = $this->db->table($this->table);

        $builder->select('id_ujian');
        $builder->orderBy('id_ujian', 'DESC');
        $builder->limit(1);

        return $builder->get();
    }
}