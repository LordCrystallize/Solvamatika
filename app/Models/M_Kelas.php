<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Kelas extends Model
{
    protected $table            = 'tbl_kelas';
    protected $primaryKey       = 'id_kelas';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id_kelas', 'nama_kelas', 'created_at', 'updated_at'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function autoNumber()
    {
        return $this->db->table($this->table)
                    ->select('id_kelas')
                    ->orderBy('id_kelas', 'DESC')
                    ->limit(1)
                    ->get();
    }
}