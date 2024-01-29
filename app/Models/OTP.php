<?php
namespace App\Models;

use CodeIgniter\Model;

class OTP extends Model
{
    public $builder;
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table('otp');

    }
    public function insertData($data)
    {
        $data1 = [
            "created_at" => time(),
        ];
        $data = array_merge($data, $data1);
        $this->builder->insert($data);
        return $this->db->insertID();
    }

    public function verify($id, $otp)
    {
        $this->builder->select('*');
        $this->builder->where("user_id='$id' && otp = '$otp'");
        $result = $this->builder->get()->getRow();
        if ($result) {
            if (time() - $result->created_at < 1800) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 0;
        }
    }

    public function updateOTP($data, $where)
    {
        $data1 = [
            "created_at" => time(),
        ];
        $data = array_merge($data, $data1);
        $builder = $this->builder;
        $builder->set($data);
        $builder->where($where);
        return $builder->update();
    }

    public function generateOTP($id)
    {
        $this->builder->select('user_id');
        $this->builder->where('user_id', $id);
        $res = $this->builder->get()->getRow();
        if ($res) {
            $data = [
                'otp' => rand(100000, 999999),
            ];
            return $this->updateOTP($data, "user_id='$id'");
        } else {
            $data = [
                "user_id" => $id,
                "otp" => rand(100000, 999999),
            ];
            return $this->insertData($data);
        }

    }
}