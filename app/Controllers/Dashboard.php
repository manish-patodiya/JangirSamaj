<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
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
        } else if (!$this->session->user_details['active_role_id']) {
            header("Location:" . base_url("auth/loginAs"));
            exit;
        } else if (!$this->session->get('user_details')['complete_profile']) {
            header("Location:" . base_url("profile/editProfile/" . base64_encode($this->session->get('user_details')['id'])));
            exit;
        }
        $this->userroles = model('UserRoles');
    }
    public function index()
    {
        switch ($this->session->user_details['active_role_id']) {
            case 1:
                return $this->adminDashboard();
                break;
            case 2:
                return $this->moderatorDashboard();
                break;
            case 3:
                return $this->memberDashboard();
                break;
        }
    }

    public function c()
    {
        return view('c');
    }

    public function b()
    {
        // prd($this->request->getFile('webcam'));
        $profile = $this->request->getFile('webcam');
        if ($profile->isValid()) {
            $img_name = $profile->getRandomName();
            $profile->move('public/uploads/members_profile/', $img_name);
        }
    }

    private function adminDashboard()
    {
        $id = $this->session->get("user_details")["id"];
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'moderatorscount' => $this->userroles->getCount(2),
            'userscount' => $this->userroles->getCount(3),
            'matrimonialcount' => model('MembersProfileModel')->countMatrimonialMember(),
            'membercount' => model('MembersProfileModel')->countshabMember(),
        ];

        return view('dashboard/content/dashboard_admin', $data);

    }

    private function moderatorDashboard()
    {
        $id = $this->session->get("user_details")["id"];
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'userscount' => $this->userroles->getCount(3),
            'matrimonialcount' => model('MembersProfileModel')->countMatrimonialMember($id),
            'membercount' => model('MembersProfileModel')->countshabMember(),
        ];
        return view('dashboard/content/dashboard_moderator', $data);

    }

    private function memberDashboard()
    {
        $id = $this->session->get("user_details")["id"];
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
            'userscount' => $this->userroles->getCount(3),
            'matrimonialcount' => model('MembersProfileModel')->countMatrimonialMember($id),
        ];
        return view('dashboard/content/dashboard_member', $data);
    }

}