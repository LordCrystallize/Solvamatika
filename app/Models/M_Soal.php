<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Soal extends Model
{
    protected $table = 'tbl_soal';
    protected $primaryKey = 'id_soal';
    
    protected $useAutoIncrement = false; 

    protected $allowedFields = [
        'id_soal',
        'id_ujian',
        'soal',
        'coretan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function autoNumber()
    {
        $builder = $this->db->table($this->table);
        $builder->select("id_soal");
        $builder->orderBy("id_soal", "DESC");
        $builder->limit(1);
        return $builder->get();
    }
}