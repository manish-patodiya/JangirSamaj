<?php
namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    public $builder;
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('users_business');

    }
    public function insertData($data)
    {
        $data1 = [
            "created_at" => date('d-m-Y'),
        ];
        $data = array_merge($data, $data1);
        $this->builder->insert($data);
        return $this->db->insertID();
    }

    public function get($id)
    {
        $this->builder->select('*');
        $this->builder->where('user_id', $id);
        return $this->builder->get()->getResult();
    }
}