<?php
namespace App\Models;

use CodeIgniter\Model;

class EducationModel extends Model
{
    public $builder;
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('education');

    }
    public function insertData($data)
    {
        $this->builder->insert($data);
        return $this->db->insertID();
    }

    public function getID($qualification, $education = false)
    {
        $this->builder->select('id');
        $this->builder->where('qualification', $qualification);
        $res = $this->builder->get()->getRow();
        if ($res) {
            return $res->id;
        } else {
            $newdata = [
                "education" => $education,
                "qualification" => trim($qualification),
            ];
            return $this->insertData($newdata);
        }
    }

    public function getFields($fields, $where = '')
    {
        $this->builder->select($fields);
        if ($where) {
            $this->builder->where($where);
        }
        return $this->builder->get()->getResult();
    }

    public function getDistinct()
    {
        $this->builder->select('education');
        $this->builder->distinct();
        return $this->builder->get()->getResult();
    }
}