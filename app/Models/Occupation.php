<?php
namespace App\Models;

use CodeIgniter\Model;

class Occupation extends Model
{
    public $builder;
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('occupations');

    }
    // function use to run query to insert new occupation in database
    public function insertData($data)
    {
        $data1 = [
            "created_at" => date('d-m-Y'),
        ];
        $data = array_merge($data, $data1);
        $this->builder->insert($data);
        return $this->db->insertID();
    }
// function to get id by occupation
    public function getID($occupation)
    {
        $this->builder->select('id');
        $this->builder->where('occupation', $occupation);
        $res = $this->builder->get()->getRow();
        if ($res) {
            return $res->id;
        } else {
            $newdata = [
                "occupation" => trim(ucwords(strtolower($occupation))),
            ];
            return $this->insertData($newdata);
        }
    }
// function to get field as per condition
    public function getFields($fields, $where = '')
    {
        $this->builder->select($fields);
        // $this->builder->where("deleted_at is NULL");
        if ($where) {
            $this->builder->where($where);
        }
        return $this->builder->get()->getResult();
    }
}