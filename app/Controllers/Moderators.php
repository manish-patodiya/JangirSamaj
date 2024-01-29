<?php

namespace App\Controllers;

class Moderators extends BaseController
{
    public $usermodel;
    public $moderatorModel;
    public $userroles;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('common');
        $uri = service('uri');
        if (!$this->session->get('is_login')) {
            header("Location:" . base_url());
            exit;
        } else if ($this->session->user_details['active_role_id'] > 1) {
            header("Location:" . base_url('dashboard'));
            exit;
        } else if (!$this->session->get('user_details')['complete_profile']) {
            header("Location:" . base_url("profile/editProfile/" . base64_encode($this->session->get('user_details')['id'])));
            exit;
        }
        $this->usermodel = model('UserModel');
        $this->moderatorModel = model('MembersProfileModel');
        $this->userroles = model('UserRoles');
    }
    public function index()
    {
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'states' => model('State')->getFields('id,state'),
            'gotra' => model('Gotra')->getFields('id,gotra'),
            'occupation' => model('Occupation')->getFields('id,occupation'),
            'education' => model('EducationModel')->getdistinct(),
            'moderatorscount' => $this->userroles->getCount(2),
        ];
        return view('dashboard/content/moderators', $data);
    }
// function to get moderators and show them in table
    public function getModerators()
    {
        $columns = ["photo", "first_name", "phone", "gender"];
        $limit = $this->request->getGet("length");
        $offset = $this->request->getGet("start");
        $district_id = $this->request->getGet("district_id");
        $search_str = $this->request->getGet('search')['value'];
        $order_col = $this->request->getGet('order')[0]['column'] ?: 1;
        $order = $this->request->getGet('order')[0]['dir'] ?: "asc";
        $order_col_name = $columns[$order_col];

        $filters = [
            "district_id" => $district_id,
            "search_str" => $search_str,
            "order" => $order_col_name . " " . $order,
        ];

        $res = $this->moderatorModel->searchModerators($limit, $offset, $filters);
        $members = $res[1];
        $records = $res[0];
        $data = [];
        foreach ($members as $v) {
            $name = $v->first_name . " " . $v->last_name;
            $imgsrc = base_url($v->profile_photo && file_exists('public/uploads/members_profile/' . $v->profile_photo) ? 'public/uploads/members_profile/' . $v->profile_photo : 'public/img/avatar.png');
            $data[] = [
                '<img src="' . $imgsrc . '" alt="' . $name . '" width="50" height="50" class=""/>',
                $name . "<span class='text-secondary w-100 d-block'>" . ($v->gender == "Male" ? "S/O " : ($v->ms == "Widow" || $v->ms == "Married" ? "W/O " : "D/O ")) . (trim($v->father_name) ?: $v->husband_name),
                $v->phone ?: "N/A",
                $v->gender,
                trim(implode(" ", [$v->address, $v->tahsil])) ?: "N/A",
                "<a class=' text-primary me-1 btn-edit' href='" . base_url('profile/editProfile/' . base64_encode($v->user_id)) . "/" . base64_encode(1) . "' target='_blank' title='Edit user' uid='$v->user_id'><i class='fas fa-edit'></i></a>
                <a class=' text-danger me-1 btn-dlt'  title='Delete user' uid='$v->user_id'><i class='fas fa-trash'></i></a>
                <a class=' text-dark me-1 btn-view'  title='View user' uid='$v->user_id'><i class='fas fa-eye'></i></a>",
            ];
        }
        echo json_encode([
            "draw" => $this->request->getGet('draw'),
            "recordsTotal" => $records,
            "recordsFiltered" => $records,
            "data" => $data,
        ]);
    }
// function to delete moderator
    public function deleteModerator()
    {
        $umodel = $this->usermodel;
        $upmodel = $this->moderatorModel;
        $id = $this->request->getPost('id');
        $umodel->deleteUser($id);
        $upmodel->deleteUser($id);
        echo json_encode([
            "status" => 1,
            "msg" => "User deleted succesfully!",
        ]);
    }
// function to show moderator profile
    public function showModeratorProfile()
    {
        $id = $this->request->getPost('id');
        $details = $this->moderatorModel->getMemberProfile($id);
        if ($details) {
            echo json_encode([
                "status" => 1,
                "msg" => "Member profile fetch succesfully!",
                "info" => $details,
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => "Member profile does not Fetch!",
            ]);
        }
    }

}