<?php
namespace App\Models;

use CodeIgniter\Model;

class District extends Model
{
    public $builder;

    public function __construct()
    {
        $db = db_connect();
        $this->builder = $db->table('districts');

    }
    // function to insert new district in database
    public function insertData($data)
    {
        $data1 = [
            "updated_at" => date('d-m-Y'),
            "created_at" => date('d-m-Y'),
        ];
        $data = array_merge($data, $data1);
        $this->builder->insert($data);
    }
// function to get district
    public function getFields($fields, $where = '')
    {
        $this->builder->select($fields);
        $this->builder->where("deleted_at is NULL");
        if ($where) {
            $this->builder->where($where);
        }
        return $this->builder->get()->getResult();
    }
}