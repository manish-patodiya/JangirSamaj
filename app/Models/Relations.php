<?php
namespace App\Models;

use CodeIgniter\Model;

class Relations extends Model
{
    public $builder;
    public $relativeBuilder;
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('relations');
        $this->relativeBuilder = $this->db->table('user_relatives');
    }
    // function use to run query to insert data in database
    public function insertData($data)
    {
        $data1 = [
            "updated_at" => date('Y-m-d'),
            "created_at" => date('Y-m-d'),
        ];
        $data = array_merge($data, $data1);
        $this->builder->insert($data);
        return $this->db->insertID();
    }
    // function use to get all fields of table from database
    public function getAll()
    {
        $builder = $this->builder;
        $builder->select("*");
        $builder->where("deleted_at is NULL");
        return $builder->get()->getResult();
    }
    // function use to run query to update row in database
    public function updateRow($column, $id)
    {
        $builder = $this->builder;
        $data1 = [
            "updated_at" => date('Y-m-d'),
        ];
        $column = array_merge($column, $data1);
        $builder->set($column);
        $builder->where($id);
        $builder->where("deleted_at is NULL");
        $builder->update();
    }
    public function getFields($fields, $where)
    {
        $this->builder->select($fields);
        $this->builder->where("deleted_at is NULL");
        if ($where) {
            $this->builder->where($where);
        }
        return $this->builder->get()->getRowArray();
    }
    // function use to run query to delete row in database
    public function deleteRow($id)
    {
        $builder = $this->builder;
        $builder->set(["deleted_at" => date('Y-m-d')]);
        $builder->where('id', $id);
        $builder->update();
    }

    public function getID($relation)
    {
        $builder = $this->builder;
        $builder->select('id');
        $builder->where('relation', $relation);
        $res = $builder->get()->getRow();
        if ($res) {
            return $res->id;
        } else {
            return $this->insertData(["relation" => $relation]);
        }
    }

    public function insertRelatives($data)
    {
        $this->relativeBuilder->insert($data);
    }

    public function insertBulk($data)
    {
        $this->builder->insertBatch($data);
        $this->builder->set('updated_at', date('Y-m-d'));
        $this->builder->set('created_at', date('Y-m-d'));
        $this->builder->update();
    }

    public function getAllFamilyMembers($id)
    {
        $this->relativeBuilder->select('mp.first_name,mp.last_name,mp.father_name,mp.gender,mp.husband_name,mp.tahsil,mp.profile_photo,state,district,relation,occupation,e.education,e.qualification');
        $this->relativeBuilder->join('members_profile mp', 'mp.user_id = user_relatives.relative_user_id', 'left');
        $this->relativeBuilder->join('relations r', "r.id = user_relatives.relation_id", 'left');
        $this->relativeBuilder->join('occupations o', "o.id = mp.occupation_id", 'left');
        $this->relativeBuilder->join('education e', "e.id = mp.qualification_id", 'left');
        $this->relativeBuilder->join('districts d', "d.id = mp.district_id", 'left');
        $this->relativeBuilder->join('states s', "s.id = mp.state_id", 'left');
        $this->relativeBuilder->where('mp.deleted_at is NULL');
        $this->relativeBuilder->where('user_relatives.user_id', $id);
        $this->relativeBuilder->where('relation_id != 1');
        return $this->relativeBuilder->get()->getResult();
    }
}