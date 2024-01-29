<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public $db;
    public $builder;

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('users');
    }

    // funtion to get rows on the basis of condition
    public function get($where)
    {
        $builder = $this->builder;
        $builder->select('*');
        $builder->where($where);
        $builder->where('deleted_at is NULL');
        return $builder->get()->getResultArray();
    }

    public function getUser($where)
    {
        $builder = $this->builder;
        $builder->select('*');
        $builder->where($where);
        $builder->where('deleted_at is NULL');
        return $builder->get()->getRow();
    }

    public function getFeilds($select, $where = "")
    {
        $builder = $this->builder;
        $builder->select($select);
        if ($where) {
            $builder->where($where);
        }
        $builder->where('deleted_at is NULL');
        return $builder->get()->getResultArray();
    }

    //function to get all row in the table
    public function getAll()
    {
        $builder = $this->builder;
        $builder->select("*");
        $builder->where('deleted_at is NULL');
        return $builder->get()->getResultArray();
    }

    // function to get fields for join rows on the basis of the condition
    public function getFieldsForJoin($column, $otherTable, $cond, $where = '', $type = null)
    {
        $builder = $this->builder;
        $builder->select($column);
        if ($where) {
            $builder->where($where);
        }
        $builder->where('users.deleted_at is NULL');
        if ($type) {
            $builder->join($otherTable, $cond, $type);
        } else {
            $builder->join($otherTable, $cond);
        }

        return $builder->get()->getResultArray();
    }

    // function to insert data in the table
    public function insertData($data)
    {
        $builder = $this->builder;
        $data1 = [
            "updated_at" => date('Y-m-d'),
            "created_at" => date('Y-m-d'),
        ];
        $data = array_merge($data, $data1);
        $builder->insert($data);
        return $this->db->insertID();
    }

    // function to update any row
    public function updateRow($data, $where)
    {
        $data1 = [
            "updated_at" => date('Y-m-d'),
        ];
        $data = array_merge($data, $data1);
        $builder = $this->builder;
        $builder->set($data);
        $builder->where($where);
        return $builder->update();
    }

    public function login($phone, $pwd)
    {
        $pwd = md5($pwd);
        $this->builder->where("phone='$phone'");
        $this->builder->where("password", $pwd);

        $result = $this->builder->get()->getRow();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function activateUser($uid = false)
    {
        if ($uid) {
            $builder = $this->builder;
            $builder->set("status", 1);
            $builder->where("id", $uid);
            $builder->update();
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id)
    {
        $builder = $this->builder;
        $builder->set(['deleted_at' => date('Y-m-d')]);
        $builder->where('id', $id);
        $builder->update();
    }

    public function getCount($where)
    {
        $builder = $this->builder;
        $builder->where($where);
        $builder->where('deleted_at is NULL');
        return $builder->countAllResults();
    }

    public function getPaginate($limit, $offset, $where)
    {
        $builder = $this->builder;
        $builder->select('users.id,users.phone,status,users.first_name,users.last_name,profile_photo');
        $builder->join('members_profile mp', 'mp.user_id=users.id', 'left');
        $builder->where('users.deleted_at is NULL');
        $builder->where($where);
        $builder->limit($limit, $offset);
        return $builder->get()->getResult();
    }
    public function fg_password($value)
    {
        $builder = $this->builder;
        $builder->select('id,phone');
        $builder->where('phone', $value);
        return $builder->get()->getRow();
    }
}