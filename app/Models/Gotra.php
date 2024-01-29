<?php
namespace App\Models;

use CodeIgniter\Model;

class Gotra extends Model
{
    public $builder;
    public $db;

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('gotras');
    }
    // function to insert new gotra in database
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
    // function to get gotra from database
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
// function to get id by gotras
    public function getID($where, $like = null)
    {
        $this->builder->select('id');
        if ($where) {
            $this->builder->where("gotra='$where'");
        } else {
            $this->builder->like('gotra', $like);
        }
        $res = $this->builder->get()->getRow();
        if ($res) {
            return $res->id;
        } else {
            return $this->insertData(['gotra' => $like]);
        }
    }

    public function getCreateID()
    {

    }
// function to get gotra by id
    public function getGotra($id)
    {
        $this->builder->select('gotra');
        $this->builder->where("id='$id'");
        return $this->builder->get()->getRow();
    }
    // function to run query who select all gotras from gotra table
    public function getAll()
    {
        $builder = $this->builder;
        $builder->select("*");
        $builder->where("deleted_at is NULL");
        return $builder->get()->getResult();
    }
    // function to update gotra
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
    // function to delete gotra
    public function deleteRow($id)
    {
        $builder = $this->builder;
        $builder->set(["deleted_at" => date('d-m-y')]);
        $builder->where('id', $id);
        $builder->update();
    }
}