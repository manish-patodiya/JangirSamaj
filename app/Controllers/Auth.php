<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public $usermodel;
    public $profilemodel;
    public $encrypter;
    public $session;
    public $validation;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('common');
        $uri = service('uri');
        if ($this->session->get('is_login') && !($uri->getTotalSegments() > 1 && ($uri->getSegment(2) == 'logout' || $uri->getSegment(2) == 'mobileExist' || $uri->getSegment(2) == 'loginAs'))) {
            header("Location:" . base_url("dashboard"));
            exit;
        }
        //include validation liabrary
        helper(['form', 'url']);
        $this->validation = \config\Services::validation();

        //include encrption liabrary
        $this->encrypter = \Config\Services::encrypter();

        //initialize model variables
        $this->profilemodel = model('MembersProfileModel');
        $this->usermodel = model('UserModel');
        $model = model("Gotra");
    }

    public function index()
    {
        return view('auth/login');
    }

    public function loginAs($activeID = null)
    {
        if ($activeID) {
            $user_details = $this->session->user_details;
            $user_details['active_role_id'] = $activeID;
            $this->session->set('user_details', $user_details);
            header("Location:" . base_url(config('app')->redirectURLs[$activeID]));
            exit;
        } else {
            return view('auth/login_as', ['session' => $this->session->get('user_details')]);
        }
    }

    public function login()
    {
        $check = $this->validate([
            'phone' => "required|min_length[10]",
            'password' => "required",
        ], [
            'phone' => [
                "min_length" => "Not a valid phone no.",
            ],
        ]);

        if ($check) {
            $model = $this->usermodel;
            if ($this->request->isAJAX()) {
                $phone = $this->request->getPost('phone');
                $password = $this->request->getPost('password');
                $user = $model->login($phone, $password);
                // Login method you have to create
                if ($user) {
                    switch ($user->status) {
                        case 0:
                            echo json_encode([
                                'status' => 0,
                                'message' => 'Your phone no. is not varified yet. <br>Please <a href="javascript:void(0)" id="verify-phn">verify</a> your phone.',
                                'user_id' => $user->id,
                                'phone' => $this->request->getPost('phone'),
                            ]);
                            break;
                        case 1:
                            $roles = model('UserRoles')->getRoles($user->id);
                            sort($roles);
                            if (count($roles) > 1) {
                                $this->setSession($roles, $user->id);
                                echo json_encode([
                                    'status' => 1,
                                    'id' => $user->id,
                                    'roles' => $roles,
                                    'message' => 'Have various roles',
                                ]);
                            } else {
                                $this->setSession($roles, $user->id, 3);
                                echo json_encode([
                                    'status' => 1,
                                    'message' => 'Login success',
                                ]);
                            }
                            break;
                        case 2:
                            echo json_encode([
                                'status' => 0,
                                'message' => 'Your account has been suspended. <br>Please contact service provider.',
                            ]);
                            break;
                    }
                } else {
                    echo json_encode([
                        'status' => 0,
                        'message' => 'Invalid user credential',
                    ]);
                }
            } else {
                die("Invalid request");
            }
        } else {
            echo json_encode([
                'status' => 0,
                'msg' => "Form is not validate",
                'errors' => $this->validation->getErrors(),
            ]);
        }
    }

    public function setSession($roles, $id, $active_role = null)
    {
        $notification = $this->profilemodel->getCountNotification($id);
        $profile = $this->profilemodel->getFields("gender,first_name,last_name,profile_photo", "user_id='$id'");
        $user_detail = [
            "id" => $id,
            "name" => ucwords($profile->first_name . " " . $profile->last_name),
            "photo" => $profile->profile_photo && file_exists("public/uploads/members_profile/" . $profile->profile_photo) ? base_url("public/uploads/members_profile/" . $profile->profile_photo) : base_url("public/img/avatar.png"),
            "user_roles" => $roles,
            "complete_profile" => $profile->gender ? 1 : 0,
            "active_role_id" => $active_role,
            "notification" => $notification,
        ];
        // prd($notification);
        $this->session->set("is_login", 1);
        $this->session->set("user_details", $user_detail);
    }

    public function signUp()
    {
        $model = model('Gotra');
        $gotra = $model->getFields('gotra,id');
        return view('auth/register', ['gotra' => $gotra]);
    }

    public function registerUser()
    {
        $check = $this->validate([
            'fname' => "required|min_length[2]",
            'lname' => "required|min_length[2]",
            'gotra' => 'required|is_not_unique[gotras.id]',
            'phone' => "required|min_length[10]|is_unique[users.phone]",
            'password' => "required|min_length[6]",
        ], [
            'fname' => [
                "min_length" => "Wrong first name.",
            ],
            'lname' => [
                "min_length" => "Wrong last name.",
            ],
            'phone' => [
                "min_length" => "Not a valid phone no.",
                "is_unique" => "Phone no. already exist",
            ],
            'gotra' => [
                'is_not_unique' => "Not a valid gotra",
            ],
            'password' => [
                "min_length" => "Password must be of 6 characters.",
            ],
        ]);
        if ($check) {
            $umodel = $this->usermodel;
            $pmodel = $this->profilemodel;
            $data = [
                "first_name" => trim(ucwords(strtolower($this->request->getPost('fname')))),
                "last_name" => trim(ucwords(strtolower($this->request->getPost('lname')))),
                "phone" => $this->request->getPost('phone'),
                "password" => md5($this->request->getPost('password')),
            ];
            $id = $umodel->insertData($data);
            $data1 = [
                "user_id" => $id,
                "first_name" => ucwords(strtolower(trim($this->request->getPost('fname')))),
                "last_name" => ucwords(strtolower(trim($this->request->getPost('lname')))),
                "phone" => $this->request->getPost('phone'),
                "self_gotra_id" => $this->request->getPost('gotra'),
            ];
            $pmodel->insertData($data1);
            $data2 = [
                'user_id' => $id,
                'role_id' => 3,
            ];
            model('UserRoles')->insertData($data2);
            $otp = $this->generateOTP($id);
            echo json_encode([
                "status" => 1,
                "msg" => "succesfully insertion",
                "user_id" => $id,
                "phone" => $this->request->getPost('phone'),
            ]);
        } else {
            echo json_encode([
                'status' => 0,
                "msg" => "Form is not validate",
                "errors" => $this->validation->getErrors(),
            ]);
        }
    }

    public function mobileExist()
    {
        $mobile = $this->request->getPost('phone');
        $umodel = $this->usermodel;
        $exist = $umodel->get("phone='$mobile'");
        if ($exist) {
            echo json_encode([
                "status" => 1,
                "msg" => "Phone no. is already exist",
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => "Phone no. is not exist",
            ]);
        }
    }

    public function generateOTP($id)
    {
        $omodel = model("OTP");
        $otp = rand(100000, 999999);
        $data = [
            'otp' => $otp,
            'user_id' => $id,
        ];
        $omodel->insertData($data);
        return $otp;
    }

    public function regenerateOTP()
    {
        $user_id = $this->request->getPost('id');
        $omodel = model("OTP");
        $otp = rand(100000, 999999);
        $data = [
            'otp' => $otp,
        ];
        $omodel->updateOTP($data, "user_id='$user_id'");
        echo json_encode([
            "status" => 1,
            "msg" => "OTP generate successfully",
        ]);
    }

    public function verifyOTP()
    {
        $omodel = model("OTP");
        $otp = $this->request->getPost('otp');
        $id = $this->request->getPost('id');
        $result = $omodel->verify($id, $otp);
        switch ($result) {
            case 0:
                echo json_encode([
                    "status" => 0,
                    "msg" => "OTP does not match",
                ]);
                break;
            case 1:
                $this->usermodel->updateRow(['status' => 1], "id='$id'");
                $user = $this->usermodel->getUser("id='$id'");
                $profile = $this->profilemodel->getUserProfile($id);
                $roles = model('UserRoles')->getRoles($id);
                $this->setSession($roles, $id, 3);
                echo json_encode([
                    "status" => 1,
                    "msg" => "account acctivated",
                ]);
                break;
            case 2:
                echo json_encode([
                    "status" => 2,
                    "msg" => "OTP has been expired",
                ]);
                break;
        }
    }

    public function logout()
    {
        $this->session->set("is_login", 0);
        $this->session->set("user_details", []);

        header("Location:" . base_url());
        exit;
    }

    //forgot password..............
    public function forgot_password()
    {

        return view('auth/forgot_password');
    }
    public function fg_password()
    {
        $value = $this->request->getPost("phone");
        // prd($value);
        $res = $this->usermodel->fg_password($value);
        if ($res) {
            $otpgen = model('OTP')->generateOTP($res->id);
            if ($otpgen) {
                echo json_encode([
                    "status" => 1,
                    "msg" => "OTP generate successfully",
                    'user_id' => $res->id,
                ]);
            } else {
                echo json_encode([
                    "status" => 0,
                    "msg" => "OTP does not generate! Please try after some time",
                ]);
            }
        } else {
            echo json_encode([
                "status" => 0,
                "msg" => "Phone does not exist",
            ]);
        }
    }
    public function changePass()
    {
        $uid = $this->request->getPost("user_id");
        $model = $this->usermodel;
        $new_pass = md5($this->request->getPost('new_pass'));
        $data = [
            'password' => $new_pass,
        ];
        $model->updateRow($data, "id='$uid'");
        echo json_encode([
            "status" => 1,
            "msg" => "Successful",
        ]);
    }

    public function verifyForgotPassOTP()
    {
        $omodel = model("OTP");
        $otp = $this->request->getPost('otp');
        $id = $this->request->getPost('id');
        $result = $omodel->verify($id, $otp);
        switch ($result) {
            case 0:
                echo json_encode([
                    "status" => 0,
                    "msg" => "OTP does not match",
                ]);
                break;
            case 1:
                $this->usermodel->updateRow(['status' => 1], "id='$id'");
                echo json_encode([
                    "status" => 1,
                    "msg" => "account acctivated",
                ]);
                break;
            case 2:
                echo json_encode([
                    "status" => 2,
                    "msg" => "OTP has been expired",
                ]);
                break;
        }
    }
}