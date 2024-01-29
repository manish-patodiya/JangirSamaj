<?php
namespace App\Controllers;

class Profile extends BaseController
{
    public $usermodel;
    public $profilemodel;
    public $validation;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('common');
        if (!$this->session->get('is_login')) {
            header("Location:" . base_url());
            exit;
        }
        //include validation liabrary
        helper(['form', 'url']);
        $this->validation = \config\Services::validation();

        $this->usermodel = model('UserModel');
        $this->profilemodel = model('MembersProfileModel');
    }

    public function index()
    {
        $id = base64_encode($this->session->user_details['id']);
        switch ($this->session->user_details['active_role_id']) {
            case 1:
                return $this->profile($id, null, 'sidebar_admin');
                break;
            case 2:
                return $this->profile($id, null, 'sidebar_moderator');
                break;
            case 3:
                return $this->profile($id, null, 'sidebar_member');
                break;
        }
    }
// function to show edit profile page
    public function editProfile($id, $newWindow = null)
    {
        $id = base64_decode($id);
        $sidebar = 'sidebar_member';
        switch ($this->session->user_details['active_role_id']) {
            case 1:
                $sidebar = 'sidebar_admin';
                break;
            case 2:
                $sidebar = 'sidebar_moderator';
                break;
            case 3:
                $sidebar = 'sidebar_member';
                break;
        }
        $details = $this->profilemodel->getFields(
            "first_name, middle_name, last_name,is_manglik,gender,phone,education,tahsil,self_gotra_id,dob, qualification_id, state_id,district_id,address,father_name, mother_name,occupation_id, occupation_detail,marital_status,nani_gotra_id,mother_gotra_id,dadi_gotra_id,availableformarriage,pob,height,skin,profile_photo", "user_id='$id'");
        $profile = $details->profile_photo && file_exists('public/uploads/members_profile/' . $details->profile_photo) ? base_url("public/uploads/members_profile/" . $details->profile_photo) : base_url("public/img/avatar.png");
        $details->profile_photo = $profile;
        $model = model('Gotra');
        $gotras = $model->getFields('id,gotra');
        $data = [
            'id' => $id,
            'sidebar' => $sidebar,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'newwindow' => base64_decode($newWindow),
            'session' => $this->session,
            'gotra' => $gotras,
            'info' => $details,
            'districts' => model('District')->getFields('district,id', "state_id='$details->state_id'"),
            'states' => model('State')->getFields('id,state'),
            'occupation' => model('Occupation')->getFields('id,occupation'),
            'education' => model('EducationModel')->getdistinct(),
            'qualification' => model('EducationModel')->getFields('id,qualification', "education='$details->education'"),
        ];
        return view('dashboard/content/edit_profile', $data);
    }

    public function profile($id, $newWindow = null, $sidebar = "sidebar_member")
    {
        $id = base64_decode($id);
        $details = $this->profilemodel->getMemberProfile($id);
        $profile = $details->profile_photo && file_exists('public/uploads/members_profile/' . $details->profile_photo) ? base_url("public/uploads/members_profile/" . $details->profile_photo) : base_url("public/img/avatar.png");
        $details->profile_photo = $profile;
        $model = model('Gotra');
        $gotras = $model->getFields('id,gotra');
        $data = [
            'id' => $id,
            'sidebar' => $sidebar,
            'newwindow' => base64_decode($newWindow),
            'session' => $this->session,
            'info' => $details,
        ];
        return view('dashboard/content/profile', $data);
    }
// function to update member profile detail
    public function updateProfile()
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
            $model = $this->usermodel;
            $pmodel = $this->profilemodel;
            $id = $this->request->getPost('id');
            $gmodel = model('Gotra');
            $occID;
            if ($this->request->getPost('occupation') == 0) {
                $occ = $this->request->getPost('new-occ');
                $data = [
                    'occupation' => trim(uswords(strtolower($occ))),
                ];
                $occID = model('Occupation')->insertData($data);
            } else {
                $occID = $this->request->getPost('occupation');
            };
            $img_name;
            $profile = $this->request->getFile('profile');
            if ($profile->isValid()) {
                $img_name = $profile->getRandomName();
                $profile->move('public/uploads/members_profile/', $img_name);
            } else {
                $img_name = $pmodel->getFields('profile_photo', "user_id='$id'")->profile_photo;
            }
            $data = [
                'first_name' => $this->request->getPost('fname'),
                'last_name' => $this->request->getPost('lname'),
            ];
            $model->updateRow($data, "id=$id");
            $data = [
                'first_name' => ucwords(strtolower(trim($this->request->getPost('fname')))),
                'middle_name' => ucwords(strtolower(trim($this->request->getPost('mname')))),
                'last_name' => ucwords(strtolower(trim($this->request->getPost('lname')))),
                'gender' => ucwords(strtolower(trim($this->request->getPost('gender')))),
                'education' => ucwords(strtolower(trim($this->request->getPost('education')))),
                'qualification_id' => $this->request->getPost('qualification'),
                'self_gotra_id' => $this->request->getPost('gotra'),
                'dob' => ucwords(strtolower(trim($this->request->getPost('dob')))),
                'state_id' => $this->request->getPost('state'),
                'district_id' => $this->request->getPost('district'),
                'tahsil' => ucwords(strtolower(trim($this->request->getPost('tahsil')))),
                'address' => ucwords(strtolower(trim($this->request->getPost('address')))),
                'father_name' => ucwords(strtolower(trim($this->request->getPost('father')))),
                'mother_name' => ucwords(strtolower(trim($this->request->getPost('mother')))),
                'occupation_id' => $occID,
                'occupation_detail' => ucfirst(strtolower(trim($this->request->getPost('occdetail')))),
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
            $pmodel->updateRow($data, "user_id=$id");
            if ($id == $this->session->get('user_details')['id']) {
                $user_details = $this->session->user_details;
                $user_details['name'] = $this->request->getPost('fname') . " " . $this->request->getPost('lname');
                $user_details['photo'] = $img_name && file_exists("public/uploads/members_profile/" . $img_name) ? base_url("public/uploads/members_profile/" . $img_name) : base_url("public/img/avatar.png");
                $user_details['complete_profile'] = 1;
                $this->session->set("user_details", $user_details);
            }

            echo json_encode([
                "status" => 1,
                "msg" => "Profile updated successfully",
            ]);
        } else {
            echo json_encode([
                'status' => 0,
                'msg' => "Form is not validate",
                'errors' => $this->validation->getErrors(),
            ]);
        }
    }
// function to get qualifications details
    public function getQualifications()
    {
        $education = $this->request->getGet('title');
        $res = model('EducationModel')->getFields('id,qualification', "education='$education'");
        if ($res) {
            echo json_encode([
                'status' => 1,
                'msg' => 'data fetch successfully',
                'qualification' => $res,
            ]);
        }
    }
// function to change password
    public function changePass()
    {
        $id = $this->session->user_details['id'];
        $model = $this->usermodel;
        $password = md5($this->request->getPost('password'));
        $exist = $model->get("password = '$password' AND id='$id'");
        if ($exist) {
            $new_pass = md5($this->request->getPost('new_password'));
            $data = [
                'password' => $new_pass,
            ];
            $model->updateRow($data, "id='$id'");
            echo json_encode([
                "status" => 1,
                "msg" => "Successful",
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => "Please enter correct password",
            ]);
        }
    }

}