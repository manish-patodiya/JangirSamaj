<?php
namespace App\Models;

use CodeIgniter\Model;

class MembersProfileModel extends Model
{
    public $builder;
    public $favorite_builder;
    public $db;
    public $msgs_buider;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = db_connect();
        $this->builder = $this->db->table('members_profile');
        $this->favorite_builder = $this->db->table('favorite_members');
        $this->msgs_builder = $this->db->table('matrimonial_msgs');

    }

    public function insertData($data)
    {
        $data1 = [
            "updated_at" => date('Y-m-d'),
            "created_at" => date('Y-m-d'),
        ];
        $data2 = array_merge($data, $data1);
        return $this->builder->insert($data2);
    }
// function to run query to get user detail
    public function getUserProfile($id)
    {
        $this->builder->where("user_id", $id);
        $this->builder->where("deleted_at is NULL");
        $result = $this->builder->get()->getRow();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
// function to run query to delete user from database
    public function deleteUser($id)
    {
        $builder = $this->builder;
        $builder->set(['deleted_at' => date('Y-m-d')]);
        $builder->where('user_id', $id);
        $builder->update();
    }
// function to run query to select field as per condition
    public function getFields($select, $where = "")
    {
        $builder = $this->builder;
        $builder->select($select);
        if ($where) {
            $builder->where($where);
        }
        $builder->where('deleted_at is NULL');
        return $builder->get()->getRow();
    }
//function to run query to update data in database
    public function updateRow($data, $where)
    {
        $data1 = [
            "updated_at" => date('Y-m-d'),
        ];
        $data = array_merge($data, $data1);
        $builder = $this->builder;
        $builder->set($data);
        $builder->where($where);
        $builder->update();
    }
//function to run query to get data as per limit
    public function getPaginate($limit, $offset, $id)
    {
        $builder = $this->builder;
        $builder->select('members_profile.user_id,phone,first_name,last_name,gender,profile_photo');
        $builder->join('user_roles ur', 'members_profile.user_id=ur.user_id', 'left');
        $builder->where('members_profile.deleted_at is NULL');
        $builder->where('role_id', $id);
        $builder->limit($limit, $offset);
        return $builder->get()->getResult();
    }
// function to get member profile detail form different table in database
    public function getMemberProfile($id)
    {
        $builder = $this->builder;
        $builder->select('first_name, middle_name,last_name,gender,members_profile.phone,members_profile.email,members_profile.education,g.gotra,dob,tahsil, state,district,members_profile.address,father_name, mother_name,o. occupation,  occupation_detail,marital_status,gn.gotra ngotra,gm.gotra mgotra,gd.gotra dgotra,availableformarriage,pob,height,skin,self_income,family_income,blood_group,father_occupation,profile_photo,qualification');
        $builder->join('gotras g', 'members_profile.self_gotra_id=g.id', 'left');
        $builder->join('gotras gn', 'members_profile.nani_gotra_id=gn.id', 'left');
        $builder->join('gotras gm', 'members_profile.mother_gotra_id=gm.id', 'left');
        $builder->join('gotras gd', 'members_profile.dadi_gotra_id=gd.id', 'left');
        $builder->join('states s', 'members_profile.state_id=s.id', 'left');
        $builder->join('districts d', 'members_profile.district_id=d.id', 'left');
        $builder->join('occupations o', 'members_profile.occupation_id=o.id', 'left');
        $builder->join('education e', 'members_profile.qualification_id=e.id', 'left');
        $builder->where('members_profile.user_id', $id);
        return $builder->get()->getRow();
    }
    // function to get all field from database
    public function getAll()
    {
        $builder = $this->builder;
        $builder->select('*');
        $builder->where('deleted_at is NULL');
        return $builder->get()->getResultArray();
    }
// function to show search filtered matrimonial members
    public function searchFields($limit, $offset, $filters, $user)
    {
        return $this->MatrimonailCards($limit, $offset, $filters, $user);
    }

    //funciton to show search filtered members
    public function searchMembersCards($limit, $offset, $user, $filters)
    {
        return $this->MemberProfile($limit, $offset, $user, $filters);
    }
// function to run query to get members with filters
    public function MemberProfile($limit, $offset, $user, $filters)
    {
        $builder = $this->builder;
        $builder->select('user_id,first_name,middle_name,last_name,gender,phone,education,g.gotra,dob, state,district,address,father_name, mother_name,o. occupation,  occupation_detail,marital_status,gp.gotra pgotra,gm.gotra mgotra,ggm.gotra gmgotra,availableformarriage,pob,height,skin,profile_photo');
        $builder->join('gotras g', 'members_profile.self_gotra_id=g.id', 'left');
        $builder->join('gotras gp', 'members_profile.nani_gotra_id=gp.id', 'left');
        $builder->join('gotras gm', 'members_profile.mother_gotra_id=gm.id', 'left');
        $builder->join('gotras ggm', 'members_profile.dadi_gotra_id=ggm.id', 'left');
        $builder->join('states s', 'members_profile.state_id=s.id', 'left');
        $builder->join('districts d', 'members_profile.district_id=d.id', 'left');
        $builder->join('occupations o', 'members_profile.occupation_id=o.id', 'left');
        $builder->where("members_profile.id !=", $user);
        $builder->limit($limit, $offset);
        if ($filters) {
            if (isset($filters['gender']) && $filters['gender']) {
                $builder->where('gender', $filters['gender']);
            }
            if (isset($filters["district_id"]) && $filters["district_id"]) {
                $builder->where('district_id', $filters["district_id"]);
            }
            if (isset($filters["tahsil"]) && $filters["tahsil"]) {
                $builder->where("tahsil", $filters["tahsil"]);
            }
        }
        $data = [
            $builder->countAllResults(false),
            $builder->get()->getResult(),
        ];
        return $data;
    }
    // function to run query to get matrimonial members with filtered
    public function MatrimonailCards($limit, $offset, $filters, $user)
    {
        $uesr_id = $this->session->user_details["id"];
        $builder = $this->builder;
        $favorite_builder = $this->favorite_builder;
        $builder->select('members_profile.user_id,first_name,middle_name,last_name,gender,phone,education,g.gotra,dob, state,district,address,father_name, mother_name,o. occupation,  occupation_detail,marital_status,gp.gotra pgotra,gm.gotra mgotra,ggm.gotra gmgotra,availableformarriage,pob,height,skin,profile_photo,is_manglik,husband_name');
        $builder->join('gotras g', 'members_profile.self_gotra_id=g.id', 'left');
        $builder->join('gotras gp', 'members_profile.nani_gotra_id=gp.id', 'left');
        $builder->join('gotras gm', 'members_profile.mother_gotra_id=gm.id', 'left');
        $builder->join('gotras ggm', 'members_profile.dadi_gotra_id=ggm.id', 'left');
        $builder->join('states s', 'members_profile.state_id=s.id', 'left');
        $builder->join('districts d', 'members_profile.district_id=d.id', 'left');
        $builder->join('occupations o', 'members_profile.occupation_id=o.id', 'left');
        $builder->join('(SELECT * FROM favorite_members WHERE user_id = ' . $uesr_id . ') fm', 'members_profile.user_id=fm.favorite_user_id', 'left');
        $builder->where("availableformarriage", 1);
        $builder->where("members_profile.id !=", $user);
        $builder->where("members_profile.marital_status !=", "Married");
        if ($filters) {
            if (isset($filters['gender']) && $filters['gender']) {
                $builder->where('gender', $filters['gender']);
            }
            if (isset($filters['education']) && $filters['education']) {
                $builder->where('education', $filters['education']);
            }
            if (isset($filters["height"]) && $filters["height"]) {
                $builder->where('height ' . $filters["height"]);
            }
            if (isset($filters['marital_status']) && $filters["marital_status"]) {
                $builder->where('marital_status', $filters['marital_status']);
            }
            $gotra_ids = [];
            if (isset($filters["self_gotra_id"]) && $filters["self_gotra_id"]) {
                $gotra_ids[] = $filters["self_gotra_id"];
            }
            if (isset($filters["nani_gotra_id"]) && $filters["nani_gotra_id"]) {
                $gotra_ids[] = $filters["nani_gotra_id"];
            }
            if (isset($filters["dadi_gotra_id"]) && $filters["dadi_gotra_id"]) {
                $gotra_ids[] = $filters["dadi_gotra_id"];
            }
            if (isset($filters["mother_gotra_id"]) && $filters["mother_gotra_id"]) {
                $gotra_ids[] = $filters["mother_gotra_id"];
            }
            if ($gotra_ids) {
                $gids = implode(",", $gotra_ids); //8,5,3,2
                $builder->where("self_gotra_id NOT IN ($gids) AND nani_gotra_id NOT IN ($gids) AND dadi_gotra_id NOT IN ($gids) AND mother_gotra_id NOT IN ($gids)");
            }
            if (isset($filters["height"]) && $filters["height"]) {
                $builder->where('height ' . $filters["height"]);
            }
            if (isset($filters["age"]) && $filters["age"]) {
                $builder->where("dob " . $filters["age"]);
            }
            if (isset($filters["sort"]) && $filters["sort"]) {
                $builder->orderBy("members_profile.dob", "DESC");
            }
            if (isset($filters["manglik"]) && $filters["manglik"]) {
                $builder->where("is_manglik", $filters["manglik"]);
            }
            // my favourite button functionality
            if (isset($filters["is_fav"]) && $filters["is_fav"]) {
                $builder->where('fm.user_id', $uesr_id);
            }
        }
        $builder->orderBy("members_profile.created_at", 'DESC');
        $builder->limit($limit, $offset);
        $data = [
            $builder->countAllResults(false),
            $builder->get()->getResult(),
        ];
        // die($this->db->getLastQuery());
        return $data;
    }
// function to count members
    public function MemberProfileCount($filters = false)
    {
        $builder = $this->builder;
        return $builder->countAllResults();
    }
    //funciton to show search filtered members
    public function searchMembers($limit, $offset, $filters)
    {
        return $this->search($limit, $offset, $filters, 3);
    }
    //funciton to show search filtered moderators
    public function searchModerators($limit, $offset, $filters)
    {
        return $this->search($limit, $offset, $filters, 2);
    }

    public function search($limit, $offset, $filters, $role_id)
    {
        $builder = $this->builder;
        $builder->select('members_profile.user_id,marital_status ms,father_name,husband_name,tahsil,state,district,address,phone,gender,first_name,sabha_members,middle_name,last_name,profile_photo');
        $builder->join('user_roles ur', 'members_profile.user_id=ur.user_id', 'left');
        $builder->join('states s', 'members_profile.state_id=s.id', 'left');
        $builder->join('districts d', 'members_profile.district_id=d.id', 'left');
        $builder->where('members_profile.deleted_at is NULL');
        $builder->where('ur.role_id', $role_id);
        $builder->limit($limit, $offset);
        if ($filters) {
            if (isset($filters["search_str"]) && $filters["search_str"]) {
                $strArr = explode(" ", $filters["search_str"]);
                foreach ($strArr as $str) {
                    $builder->where("(`first_name` LIKE '%$str%' OR `middle_name` LIKE '%$str%' OR `last_name` LIKE '%$str%' OR `phone` LIKE '%$str%' OR `gender` LIKE '%$str%')");
                }
            }
            if (isset($filters["district_id"]) && $filters["district_id"]) {
                $builder->where('district_id', $filters['district_id']);
            }
            if (isset($filters["order"]) && $filters["order"]) {
                $builder->orderBy($filters['order']);
            }
            if (isset($filters["sabha_member"]) && $filters["sabha_member"]) {
                $builder->where("sabha_members", 1);
            }
            if (isset($filters["gender"]) && $filters["gender"]) {
                $builder->where("gender", $filters['gender']);
            }
        }
        $data = [
            $builder->countAllResults(false),
            $builder->get()->getResult(),
        ];
        return $data;
    }
// function to run query to get detail of matrimonial members
    public function getMetrimonialDetail($uid = false)
    {
        if (!$uid) {
            return;
        }
        $builder = $this->builder;
        $builder->select('user_id, first_name,middle_name,last_name,gender,phone,education,g.gotra,dob,tahsil,state,district,address,father_name, mother_name,o.occupation,  occupation_detail,marital_status,gn.gotra ngotra,gm.gotra mgotra,gd.gotra dgotra,availableformarriage,pob,height,skin,profile_photo,blood_group,self_income,family_income,father_occupation,email');
        $builder->join('gotras g', 'members_profile.self_gotra_id=g.id', 'left');
        $builder->join('gotras gn', 'members_profile.nani_gotra_id=gn.id', 'left');
        $builder->join('gotras gm', 'members_profile.mother_gotra_id=gm.id', 'left');
        $builder->join('gotras gd', 'members_profile.dadi_gotra_id=gd.id', 'left');
        $builder->join('states s', 'members_profile.state_id=s.id', 'left');
        $builder->join('districts d', 'members_profile.district_id=d.id', 'left');
        $builder->join('occupations o', 'members_profile.occupation_id=o.id', 'left');
        $builder->where("members_profile.user_id", $uid);
        return $builder->get()->getRow();
    }
    // function to run query to update favourite members
    public function updateFavorite($uid, $fav_uid, $remove = false)
    {

        if (!$remove) {
            return $this->favorite_builder->insert([
                "user_id" => $uid,
                "favorite_user_id" => $fav_uid,
            ]);
        } else {
            $this->favorite_builder->where([
                "user_id" => $uid,
                "favorite_user_id" => $fav_uid,
            ]);
            return $this->favorite_builder->delete();
        }
    }
    // function to run query to get favourites members
    public function getFavorites($uid)
    {
        $this->favorite_builder->select("favorite_user_id");
        $this->favorite_builder->where("user_id", $uid);
        return $this->favorite_builder->get()->getResult();
    }
    // function to count matrimonial members
    public function countMatrimonialMember()
    {
        $this->builder->select('*');
        $this->builder->where('availableformarriage', 1);
        return $this->builder->countAllResults();
    }
    // function to count shaba members
    public function countshabMember()
    {
        $this->builder->select('*');
        $this->builder->where("members_profile.sabha_members =1");
        return $this->builder->countAllResults();
    }

    //get Messages of Logged In User0
    public function getMessages()
    {
        $id = $this->session->user_details['id'];
        $builderMsg = $this->db->table('Matrimonial_msgs mm');
        $builderMsg->select('mm.id,msg,first_name,middle_name,last_name ,time,check_msg');
        $builderMsg->where('mm.contact_user_id', $id);
        $builderMsg->join('members_profile mp', 'mp.user_id = mm.user_id', 'left');
        // prd($builderMsg->get()->getResult());
        return $builderMsg->get()->getResult();
    }

    //get Unseen Messages of Logged In User0
    public function getUnseenMessages()
    {
        $id = $this->session->user_details['id'];
        $builderMsg = $this->db->table('Matrimonial_msgs mm');
        $builderMsg->select('mm.id,msg,first_name,middle_name,last_name ,time,check_msg');
        $builderMsg->where('mm.check_msg', 0);
        $builderMsg->where('mm.contact_user_id', $id);
        $builderMsg->join('members_profile mp', 'mp.user_id = mm.user_id', 'left');
        // prd($builderMsg->get()->getResult());
        return $builderMsg->get()->getResult();
    }

    //check_msg 1 / msg seen
    public function msgSeen($mid)
    {
        $builderMsg = $this->db->table('Matrimonial_msgs mm');
        $builderMsg->set('check_msg', 1);
        $builderMsg->where('id', $mid);
        return $builderMsg->update();
    }

    // insert maessge in database table
    public function insertMsg($msgData)
    {
        $msgData['created_at'] = date('Y-m-d');
        return $this->msgs_builder->insert($msgData);
    }
    // function to count notifications
    public function getCountNotification($contact_user_id)
    {
        $this->msgs_builder->where("contact_user_id", $contact_user_id);
        return $this->msgs_builder->countAllResults();
    }

    // function to show tahsil filter
    public function tahsil($id)
    {
        $builder = $this->builder;
        $builder->select('tahsil');
        $builder->distinct();
        $builder->where('district_id', $id);
        return $builder->get()->getResult();
    }
}