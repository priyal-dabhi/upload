<?php 

namespace App\Models;

use CodeIgniter\Model;

class ExportExcelModel extends Model
{
    public function selectQuery()
    {
        $builder = $this->db->table('user');
        $builder->select("*");
        $result = $builder->get();
        return $result->getResult();
        
    }
}










?>