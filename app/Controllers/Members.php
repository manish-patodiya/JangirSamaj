<?php

namespace App\Controllers;

class Members extends BaseController
{
    public $usermodel;
    public $memberModel;
    public $validation;
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
        } else if (!$this->session->get('user_details')['complete_profile']) {
            header("Location:" . base_url("profile/editProfile/" . base64_encode($this->session->get('user_details')['id'])));
            exit;
        }
        //include validation liabrary
        helper(['form', 'url']);
        $this->validation = \config\Services::validation();

        $this->usermodel = model('UserModel');
        $this->memberModel = model('MembersProfileModel');
        $this->limit = 5;
        $this->userroles = model('UserRoles');
    }

    public function index()
    {
        switch ($this->session->user_details["active_role_id"]) {
            case 1:
            case 2:
                return $this->members();
                break;
            case 3:
                return $this->memberCards();
                break;
        }
    }

    private function members()
    {
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'states' => model('State')->getFields('id,state'),
            'gotra' => model('Gotra')->getFields('id,gotra'),
            'occupation' => model('Occupation')->getFields('id,occupation'),
            'education' => model('EducationModel')->getdistinct(),
            'sidebar' => $this->session->user_details["active_role_id"] == 1 ? 'sidebar_admin' : 'sidebar_moderator',
            'userscount' => $this->userroles->getCount(3),
        ];
        return view('dashboard/content/members', $data);
    }
// function to add member
    public function addMember()
    {
        $check = $this->validate([
            'fname' => "required|min_length[2]",
            'lname' => "required|min_length[2]",
            'mname' => "min_length[2]",
            'gender' => 'required',
            'education' => "required",
            'qualification' => "required|is_not_unique[education.id]",
            'gotra' => 'required|is_not_unique[gotras.id]',
            'dob' => "required",
            'state' => "required|is_not_unique[states.id]",
            'district' => "required|is_not_unique[districts.id]",
            'tahsil' => "min_length[2]",
            'address' => "min_length[2]",
            'father' => "required|min_length[2]",
            'mother' => "min_length[2]",
            'occupation' => "required",
            'mstatus' => "required",
            'phone' => "required|min_length[10]|is_unique[users.phone]",
        ]);
        if ($this->request->getPost('formarriage') && $check) {
            $check = $this->validate([
                'naniGotra' => "required|is_not_unique[gotras.id]",
                'dadiGotra' => "required|is_not_unique[gotras.id]",
                'motherGotra' => "required|is_not_unique[gotras.id]",
                'pob' => "required",
                'height' => "required|min_length[2]|max_length[3]",
                'skin' => "required",
            ]);
        }
        if ($check) {
            $umodel = $this->usermodel;
            $pmodel = $this->memberModel;
            $occID;
            if ($this->request->getPost('occupation') == 0) {
                $occ = $this->request->getPost('new-occ');
                $data = [
                    'occupation' => trim(ucwords(strtolower($occ))),
                ];
                $occID = model('Occupation')->insertData($data);
            } else {
                $occID = $this->request->getPost('occupation');
            };
            $img_name = '';
            $profile = $this->request->getFile('profile');
            if ($profile->isValid()) {
                $img_name = $profile->getRandomName();
                $profile->move('public/uploads/members_profile/', $img_name);
            }
            $data = [
                'first_name' => ucwords(strtolower(trim($this->request->getPost('fname')))),
                'last_name' => ucwords(strtolower(trim($this->request->getPost('lname')))),
                'phone' => trim($this->request->getPost('phone')),
            ];
            $uid = $umodel->insertData($data);
            $data1 = [
                'user_id' => $uid,
                'first_name' => ucwords(strtolower(trim($this->request->getPost('fname')))),
                'middle_name' => ucwords(strtolower(trim($this->request->getPost('mname')))),
                'last_name' => ucwords(strtolower(trim($this->request->getPost('lname')))),
                'gender' => ucwords(strtolower(trim($this->request->getPost('gender')))),
                'education' => ucwords(strtolower(trim($this->request->getPost('education')))),
                'qualification_id' => $this->request->getPost('qualification'),
                'self_gotra_id' => $this->request->getPost('gotra'),
                'phone' => trim($this->request->getPost('phone')),
                'dob' => ucwords(strtolower(trim($this->request->getPost('dob')))),
                'state_id' => $this->request->getPost('state'),
                'district_id' => $this->request->getPost('district'),
                'tahsil' => ucwords(strtolower(trim($this->request->getPost('tahsil')))),
                'address' => ucwords(strtolower(trim($this->request->getPost('address')))),
                'father_name' => ucwords(strtolower(trim($this->request->getPost('father')))),
                'mother_name' => ucwords(strtolower(trim($this->request->getPost('mother')))),
                'occupation_id' => $occID,
                'occupation_detail' => ucwords(strtolower(trim($this->request->getPost('occdetail')))),
                'marital_status' => ucwords(strtolower(trim($this->request->getPost('mstatus')))),
                'nani_gotra_id' => $this->request->getPost('naniGotra'),
                'mother_gotra_id' => $this->request->getPost('motherGotra'),
                'dadi_gotra_id' => $this->request->getPost('dadiGotra'),
                'availableformarriage' => trim($this->request->getPost('formarriage')),
                'is_manglik' => trim($this->request->getPost('manglik')),
                'pob' => ucwords(strtolower(trim($this->request->getPost('pob')))),
                'height' => ucwords(strtolower(trim($this->request->getPost('height')))),
                'skin' => ucwords(strtolower(trim($this->request->getPost('skin')))),
                'profile_photo' => $img_name,
            ];
            $res = $pmodel->insertData($data1);
            $data2 = [
                'user_id' => $uid,
                'role_id' => $this->request->getPost('role'),
            ];
            $res1 = model('UserRoles')->insertData($data2);
            if ($res && $res1) {
                echo json_encode([
                    "status" => 1,
                    "msg" => "Member add successfully",
                ]);
            }
        } else {
            echo json_encode([
                'status' => 0,
                'msg' => "Form is not validate",
                'errors' => $this->validation->getErrors(),
            ]);
        }
    }
// function to show cards of members
    private function memberCards()
    {
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'states' => model('State')->getFields('id,state'),
            'membercount' => model('MembersProfileModel')->countshabMember(),
        ];
        return view('dashboard/content/member_cards', $data);
    }

    public function getMembers()
    {
        $columns = ["photo", "first_name", "phone", "gender", "address"];

        $limit = $this->request->getGet("length");
        $offset = $this->request->getGet("start");
        $district_id = $this->request->getGet("district_id");
        $sabha_member = $this->request->getGet("sabha_member");
        $search_str = $this->request->getGet('search')['value'];
        $order_col = $this->request->getGet('order')[0]['column'] ?: 1;
        $order = $this->request->getGet('order')[0]['dir'] ?: "asc";
        $order_col_name = $columns[$order_col];
        $gender = $this->request->getGet("gender");
        $filters = [
            "district_id" => $district_id,
            "sabha_member" => $sabha_member,
            "search_str" => $search_str,
            "order" => $order_col_name . " " . $order,
            "gender" => $gender,
        ];
        // prd($filters);
        $res = $this->memberModel->searchMembers($limit, $offset, $filters);
        $members = $res[1];
        $records = $res[0];

        $data = [];
        foreach ($members as $v) {
            $name = $v->first_name . " " . $v->last_name;
            $imgsrc = base_url($v->profile_photo && file_exists('public/uploads/members_profile/' . $v->profile_photo) ? 'public/uploads/members_profile/' . $v->profile_photo : 'public/img/avatar.png');
            $data[] = [
                '<div class="position-relative"><img src="' . $imgsrc . '" alt="' . $name . '" width="50" height="50" class=""/>' . ($v->sabha_members ? '<img src="' . base_url('public/img/Vishwakarma.jpg') . '" width="20" height="20" class="position-absolute rounded-circle top-0 right-0"/>' : "") . '</div>',
                $name . "<span class='text-secondary w-100 d-block'>" . ($v->gender == "Male" ? "S/O " : ($v->ms == "Widow" || $v->ms == "Married" ? "W/O " : "D/O ")) . (trim($v->father_name) ?: $v->husband_name),
                $v->phone ?: "N/A",
                $v->gender,

                trim(implode(" ", [$v->address, $v->tahsil])) ?: "N/A",
                ($this->session->user_details['active_role_id'] < 3 ? "<a class=' text-primary me-1 btn-edit' href='" . base_url('profile/editProfile/' . base64_encode($v->user_id)) . "/" . base64_encode(1) . "' target='_blank' title='Edit user' uid='$v->user_id'><i class='fas fa-edit'></i></a>
                <a class=' text-danger me-1 btn-dlt'  title='Delete user' uid='$v->user_id'><i class='fas fa-trash'></i></a>"
                    : "") . "<a class=' text-dark me-1 btn-view'  title='View user' uid='$v->user_id'><i class='fas fa-eye'></i></a>" .
                ($this->session->user_details['active_role_id'] == 1 ? (model('UserRoles')->checkRole($v->user_id) ?
                    "<a class=' text-danger me-1 btn-demote'  title='Deomote from moderator' uid='$v->user_id'><i class='fas fa-arrow-circle-down'></i></a>" :
                    "<a class='text-success me-1 btn-promote'  title='Promote as moderator' uid='$v->user_id'><i class='fas fa-arrow-circle-up'></i></a>") : ""),
            ];

        }
        echo json_encode([
            "draw" => $this->request->getGet('draw'),
            "recordsTotal" => $records,
            "recordsFiltered" => $records,
            "data" => $data,
        ]);
    }
// function to delete users
    public function deleteUser()
    {
        $umodel = $this->usermodel;
        $upmodel = $this->memberModel;
        $id = $this->request->getPost('id');
        $umodel->deleteUser($id);
        $upmodel->deleteUser($id);
        echo json_encode([
            "status" => 1,
            "msg" => "User deleted succesfully!",
        ]);
    }
// function to show members profile detail
    public function showMemberProfile()
    {
        $id = $this->request->getPost('id');
        $details = $this->memberModel->getMemberProfile($id);
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
// function to promote member to moderator
    public function promoteMember()
    {
        $id = $this->request->getPost('id');
        $data = [
            'user_id' => $id,
            'role_id' => 2,
        ];
        if (model('UserRoles')->InsertData($data)) {
            echo json_encode([
                "status" => 1,
                "msg" => "Member promoted successfully!",
            ]);
        }

    }
// function to demote member from his/her role
    public function demoteMember()
    {
        $id = $this->request->getPost('id');
        if (model('UserRoles')->deleteData($id, 2)) {
            echo json_encode([
                "status" => 1,
                "msg" => "Member demoted succesfully!",
            ]);
        }
    }

    //Get business details on the basis of user id
    public function getBusinessDetail()
    {
        $id = $this->request->getPost('id');
        $detail = model('BusinessModel')->get($id);
        if ($detail) {
            echo json_encode([
                "status" => 1,
                "msg" => 'fetch details successfully',
                'details' => $detail,
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => 'Business details not found',
            ]);
        }
    }
// function to upload CSV file in database
    public function uploadCSV()
    {
        $file = $this->request->getFile('csv');

        $type = $file->guessExtension();
        if ($file->isValid() && $type == "csv") {
            // convert csv string in array
            $rows = array_map('str_getcsv', file($file));
            //get and remove header from csv array
            $header = array_shift($rows);
            $csv = array();
            foreach ($rows as $row) {
                if ($row) {
                    $csv[] = array_combine($header, $row);
                }
            }
            $all = [];
            foreach ($csv as $value) {
                array_shift($value);
                array_push($all, $value);
            }
            $Families = [];
            $flag = 0;
            foreach ($all as $member) {
                if (explode('.', $member['Sub. No.'])[0] == $flag) {
                    array_shift($member);
                    array_push($Families[$flag - 1], $member);
                } else {
                    array_shift($member);
                    $Families[$flag][0] = $member;
                    $flag++;
                }
            }

            foreach ($Families as $key => $family) {
                $user_id;
                foreach ($family as $key => $member) {
                    $userData = [
                        'first_name' => trim(ucfirst(strtolower($member['name']))),
                        'last_name' => 'Jangid',
                        'phone' => trim($member['phone']),
                    ];
                    $id = $this->usermodel->insertData($userData);
                    $relation = ucfirst(strtolower(trim($member['relation'])));
                    if ($relation == "Self") {
                        $user_id = $id;
                    }
                    $userRelativesData = [
                        'user_id' => $user_id,
                        'relative_user_id' => $id,
                        'relation_id' => model('Relations')->getID($relation),
                    ];
                    model('Relations')->insertRelatives($userRelativesData);
                    $profileData = [
                        'user_id' => $id,
                        'first_name' => trim(ucfirst(strtolower($member['name']))),
                        'last_name' => 'Jangid',
                        'self_gotra_id' => model('Gotra')->getID(false, $member['gotra']),
                        'mother_gotra_id' => $member['mother gotra'] ? model('Gotra')->getID(false, $member['mother gotra']) : "",
                        'nani_gotra_id' => $member['nani gotra'] ? model('Gotra')->getID(false, $member['nani gotra']) : "",
                        'dadi_gotra_id' => $member['dadi gotra'] ? model('Gotra')->getID(false, $member['dadi gotra']) : "",
                        'title_name' => trim(ucfirst(strtolower($member['title']))),
                        'gender' => trim(ucfirst(strtolower($member['gender']))),
                        'marital_status' => trim(ucfirst(strtolower($member['marital status']))),
                        'dob' => date("Y-m-d", strtotime($member['dob'])),
                        'education' => trim($member['education']),
                        'qualification_id' => $member['degree'] ? model('EducationModel')->getID($member['degree'], trim($member['education'])) : "",
                        'occupation_id' => model('Occupation')->getID($member['occupation']),
                        'tahsil' => ucwords(strtolower(trim($member['tahsil']))),
                        'address' => ucwords(strtolower(trim($member['address']))),
                        'phone' => trim($member['phone']),
                        'sabha_members' => $member['mahashabmember'] ? 1 : 0,

                    ];

                    if ($profileData['gender'] == "Female" && ($profileData['marital_status'] == "Married" || $profileData['marital_status'] == "Widow")) {
                        $profileData['husband_name'] = trim(ucfirst(strtolower($member['father or husband'])));
                    } else {
                        $profileData['father_name'] = trim(ucfirst(strtolower($member['father or husband'])));
                    }
                    $this->memberModel->insertData($profileData);
                    $data2 = [
                        'user_id' => $id,
                        'role_id' => 3,
                    ];
                    $res1 = model('UserRoles')->insertData($data2);
                }
            }
            echo json_encode([
                "status" => 1,
                "msg" => "CSV import successfully",
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => "Not a CSV file",
            ]);
        }
    }
// function to get members profile as respect of some fileters also
    public function getMembersProfile()
    {
        $limit = 10;
        $user = $this->session->get("user_details")['id'];
        $district_id = $this->request->getPost("district_id");
        $tahsil = $this->request->getPost("tahsil");
        $gender = $this->request->getPost("gender");
        $offset = $this->request->getPost('page') ? (($this->request->getPost('page') - 1) * $limit) + 1 : '1';
        $filters = [];
        if ($gender) {
            $filters["gender"] = $gender;
        }
        if ($district_id) {
            $filters["district_id"] = $district_id;
        }
        if ($tahsil) {
            $filters["tahsil"] = $tahsil;
        }
        $res = $this->memberModel->searchMembersCards($limit, $offset - 1, $user, $filters);
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
// function to show members profile details on click member card
    public function getMemberDetails()
    {
        $id = $this->request->getPost('id');
        $details = $this->memberModel->getMemberProfile($id);
        if ($details) {
            echo json_encode([
                "status" => 1,
                "msg" => 'fetch details successfully',
                'details' => $details,
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => 'Member details not found',
            ]);
        }
    }
// function to get family members
    public function getFamilyMembers()
    {
        $id = $this->request->getPost('id');
        $family = model('Relations')->getAllFamilyMembers($id);
        if ($family) {
            echo json_encode([
                "status" => 1,
                "msg" => 'fetch members successfully',
                'family' => $family,
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => 'Family members details not found',
            ]);
        }
    }

}