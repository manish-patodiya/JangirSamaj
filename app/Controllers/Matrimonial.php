<?php

namespace App\Controllers;

class Matrimonial extends BaseController
{
    public $memberProfile;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('common');
        $uri = service('uri');
        if (!$this->session->get('is_login')) {
            header("Location:" . base_url());
            exit;
        } else if (!$this->session->get('user_details')['complete_profile']) {
            header("Location:" . base_url("profile/editProfile/" . base64_encode($this->session->get('user_details')['id'])));
            exit;
        }
        $this->memberProfile = model('membersProfileModel');
    }

    public function index()
    {
        switch ($this->session->user_details['active_role_id']) {
            case 1:
                return $this->matrimonial_cards('sidebar_admin');
                break;
            case 2:
                return $this->matrimonial_cards('sidebar_moderator');
                break;
            case 3:
                return $this->matrimonial_cards();
                break;
        }
    }

    private function matrimonial_cards($sidebar = "sidebar_member")
    {
        $model = model('Gotra');
        $details = $this->memberProfile->getFields("self_gotra_id");
        $gotras = $model->getFields('id,gotra');
        $id = $this->session->get("user_details")["id"];
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'sidebar' => $sidebar,
            'education' => model('EducationModel')->getdistinct(),
            'gotra' => $gotras,
            'info' => $details,
            'matrimonialcount' => model('MembersProfileModel')->countMatrimonialMember($id),
        ];
        return view('dashboard/content/matrimonial', $data);
    }

    public function card($id = false)
    {
        if (!$id) {
            die("No member id found ");
        }
        $data = (Array) $this->memberProfile->getMetrimonialDetail($id);
        if (!$data) {
            die("no details found ");
        }
        //prd($data);
        return view('dashboard/content/matrimonial_card', $data);

    }
    public function matrimonial_msg()
    {
        return view('dashboard/content/matrimonil_msg');

    }
    public function matrimonial_detail($id)
    {
        if (!$id) {
            die("No member id found ");
        }
        $detail = (Array) $this->memberProfile->getMetrimonialDetail($id);
        if (!$detail) {
            die("no details found ");
        }
        $data = [
            'session' => $this->session,
            'sidebar' => "sidebar_member",
            'detail' => $detail,
        ];
        return view('dashboard/content/matrimonial_detail', $data);

    }

    public function cards()
    {
        $members = $this->memberProfile->getAll();
        echo json_encode([
            "status" => 1,
            "members" => $members,
        ]);
    }

    public function getMatrimonialDetail()
    {
        $id = $this->request->getPost("id");
        $detail = $this->memberProfile->getMetrimonialDetail($id);
        echo json_encode([
            "status" => 1,
            'messages' => model('MembersProfileModel')->getMessages(),
            "msg" => "Details get successful",
            "detail" => $detail,
        ]);
    }

    public function update_favorite()
    {
        $fav_uid = $this->request->getPost("uid");
        $remove = $this->request->getPost("remove");
        $uid = $this->session->user_details["id"];
        $res = $this->memberProfile->updateFavorite($uid, $fav_uid, $remove);
        if ($res) {
            echo json_encode([
                "status" => 1,
                "msg" => "Favorite updated successful",
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => "Failed to update favorite",
            ]);
        }
    }

    public function my_favorites()
    {
        $uid = $this->session->user_details["id"];
        $favs = $this->memberProfile->getFavorites($uid);
        $favorites = [];
        foreach ($favs as $v) {
            $favorites[] = $v->favorite_user_id;
        }
        echo json_encode([
            "status" => 1,
            "msg" => "Favorite get successful",
            "favorites" => $favorites,
        ]);
    }

    public function getMatrimonialCards()
    {
        $limit = 10;
        $user = $this->session->get("user_details")['id'];
        $gender = $this->request->getPost("gender");
        $s_gotra = $this->request->getPost("sgotra");
        $n_gotra = $this->request->getPost("ngotra");
        $d_gotra = $this->request->getPost("dgotra");
        $m_gotra = $this->request->getPost("mgotra");
        $marital_status = $this->request->getPost("marital_status");
        $height = $this->request->getPost("height");
        $age = $this->request->getPost("age");
        $education = $this->request->getPost("education");
        $sort = $this->request->getPost("sort");
        $manglik = $this->request->getPost("manglik");
        $is_fav = $this->request->getPost("is_fav");
        $offset = $this->request->getPost("page") ? (($this->request->getPost('page') - 1) * $limit) + 1 : '1';
        $filters = [];
        if ($gender) {
            $filters["gender"] = $gender;
        }
        if ($education) {
            $filters["education"] = $education;
        }
        if ($marital_status) {
            $filters["marital_status"] = $marital_status;
        }
        if ($height) {
            $filters["height"] = isset(FILTER_HEIGHT[$height]) ? FILTER_HEIGHT[$height] : false;
        }
        if ($age) {
            $filters["age"] = isset(FILTER_AGE[$age]) ? FILTER_AGE[$age] : false;
        }
        if ($s_gotra) {
            $filters["self_gotra_id"] = $s_gotra;
        }
        if ($n_gotra) {
            $filters["nani_gotra_id"] = $n_gotra;
        }
        if ($d_gotra) {
            $filters["dadi_gotra_id"] = $d_gotra;
        }
        if ($m_gotra) {
            $filters["mother_gotra_id"] = $m_gotra;
        }
        if ($sort) {
            $filters["sort"] = $sort;
        }
        if ($manglik) {
            $filters["manglik"] = $manglik;
        }
        if ($is_fav) {
            $filters["is_fav"] = $is_fav;
        }
        $res = $this->memberProfile->searchFields($limit, $offset - 1, $filters, $user);
        $members = $res[1];
        $total_members = $res[0];
        if ($members) {
            echo json_encode([
                "status" => 1,
                "members" => $members,
                "total_members" => $total_members,
            ]);} else {
            echo json_encode([
                "status" => 0,
                "message" => "Not Available",
                "total_members" => $total_members,
            ]);
        }
    }

    //maessge data insert in table.........
    public function sendMsg()
    {
        $uid = $this->session->user_details["id"];
        $matrimonial_member_id = $this->request->getPost('uid');
        $msg = $this->request->getPost('msg');
        $phone = $this->memberProfile->getFields("phone", "user_id=$uid")->phone;
        if ($this->request->getPost('share_phone')) {
            $msg = $msg . "\nphone no.: $phone";
        }
        $data = [
            'user_id' => $uid,
            'contact_user_id' => $matrimonial_member_id,
            'msg' => $msg,
        ];
        $res = $this->memberProfile->insertMsg($data);
        if ($res) {
            echo json_encode([
                "status" => 1,
                "msg" => "Message sent successfully!",
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => "Message does not sent!",
            ]);
        }
    }

}