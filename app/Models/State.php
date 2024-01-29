<?php
namespace App\Models;

use CodeIgniter\Model;

class State extends Model
{
    public $builder;
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('states');

    }
    public function insertData($data)
    {
        $data1 = [
            "updated_at" => date('d-m-Y'),
            "created_at" => date('d-m-Y'),
        ];
        $data = array_merge($data, $data1);
        $this->builder->insert($data);
        return $this->db->insertID();
    }

    public function getFields($fields, $where = "")
    {
        $this->builder->select($fields);
        $this->builder->where("deleted_at is NULL");
        if ($where) {
            $this->builder->where($where);
        }
        return $this->builder->get()->getResult();
    }

    public function getField($fields, $where)
    {
        $this->builder->select($fields);
        $this->builder->where("deleted_at is NULL");
        if ($where) {
            $this->builder->where($where);
        }
        return $this->builder->get()->getRowArray();
    }
    public function getAll()
    {
        $builder = $this->builder;
        $builder->select("*");
        $builder->where("deleted_at is NULL");
        return $builder->get()->getResult();
    }
    public function updateRow($column, $id)
    {
        $builder = $this->builder;
        $data1 = [
            "updated_at" => date('d-m-y'),
        ];
        $column = array_merge($column, $data1);
        $builder->set($column);
        $builder->where($id);
        $builder->where("deleted_at is NULL");
        $builder->update();
    }
    public function deleteRow($id)
    {
        $builder = $this->builder;
        $builder->set(["deleted_at" => date('d-m-y')]);
        $builder->where('id', $id);
        $builder->update();
    }
}