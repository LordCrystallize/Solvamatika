<?php
namespace App\Models;

use CodeIgniter\Model;

class M_Guru extends Model
{
   
    protected $table = 'tbl_guru';
    protected $primaryKey = 'id_guru';
    protected $allowedFields = [
        'id_guru', 'nama_guru', 'nip_guru', 
        'password_guru', 'is_delete_guru', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDataGuru($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        if ($where !== false) {
            $builder->where($where);
        }
        $builder->orderBy('nama_guru', 'ASC');
        return $builder->get();
    }
    
    public function saveDataGuru($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataGuru($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber()
    {
        $builder = $this->db->table($this->table);
        $builder->select("id_guru");
        $builder->orderBy("id_guru", "DESC");
        $builder->limit(1);
        return $builder->get();
    }

    public function restoreGuru() 
    {
        return $this->where('is_delete_guru', '1')
                    ->set('is_delete_guru', '0')
                    ->update();
    }
}
?>
