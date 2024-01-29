<?php

namespace App\Controllers;

class States extends BaseController
{
    public $usermodel;
    public $statemodel;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('common');
        $uri = service('uri');

        $this->usermodel = model('UserModel');
        $this->statemodel = model('State');
    }
    public function index()
    {
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
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
        ];
        return view('dashboard/content/states', $data);
    }
// function to get districts and show them in tabular format
    public function getDistricts($id)
    {
        echo json_encode([
            'status' => 1,
            'msg' => 'districts fetch successfully',
            'districts' => model('District')->getFields('district,id', "state_id='$id'"),
        ]);
    }
    // function to get tahsil
    public function getTahsil()
    {
        $id = $this->request->getPost('district_id');
        $tahsil = model('MembersProfileModel')->tahsil($id);
        // prd($tahsil);
        echo json_encode([
            'status' => 1,
            'msg' => 'tahsil fetch successfully',
            'tahsil' => model('MembersProfileModel')->tahsil($id),
        ]);
    }
    // function to get states
    public function states()
    {
        $smodel = $this->statemodel->getAll();
        $arr = [];
        foreach ($smodel as $k => $v) {
            $arr[] = [
                $v->state,
                "<a class='fas fa-edit me-1 btn-edit' title ='Edit state' uid='$v->id'></a><a  class='fas fa-trash text-danger me-1 btn-dlt' title='Delete state' uid='$v->id'></a>",
            ];
        }
        echo json_encode([
            "status" => 1,
            "state" => $arr,
        ]);
    }
    // function to add new state in database on click add button
    public function insertState()
    {
        if (!$this->session->get('is_login')) {
            header("Location:" . base_url());
            exit;
        } else if ($this->session->user_details['active_role_id'] > 1) {
            header("Location:" . base_url('dashboard'));
            exit;
        }
        $smodel = $this->statemodel;
        $state = $this->request->getPost('name');
        $data = [
            "state" => $state,
        ];
        $smodel->insertData($data);
        echo json_encode([
            "status" => 1,
            "msg" => "New state inserted successfully",
        ]);
    }
    // function to edit state on click edit icon
    public function editState()
    {
        if (!$this->session->get('is_login')) {
            header("Location:" . base_url());
            exit;
        } else if ($this->session->user_details['active_role_id'] > 1) {
            header("Location:" . base_url('dashboard'));
            exit;
        }
        $smodel = $this->statemodel;
        $id = $this->request->getpost('uid');
        $column = [
            "state" => $this->request->getPost('name'),
        ];
        $data = $smodel->updateRow($column, "id='$id'");
        echo json_encode([
            "status" => 1,
            "msg" => "Your state edited successfully",
        ]);
    }
    // function to get state
    public function getState()
    {
        $smodel = $this->statemodel;
        $id = $this->request->getPost('id');
        $name = $smodel->getField('state', "id='$id'")['state'];
        echo json_encode([
            "status" => 1,
            "name" => $name,
        ]);
    }
    // function to delete state
    public function deleteState()
    {
        if (!$this->session->get('is_login')) {
            header("Location:" . base_url());
            exit;
        } else if ($this->session->user_details['active_role_id'] > 1) {
            header("Location:" . base_url('dashboard'));
            exit;
        }
        $smodel = $this->statemodel;
        $id = $this->request->getPost('id');
        $smodel->deleteRow($id);
        echo json_encode([
            "status" => 1,
            "msg" => "State was deleted successfully",
        ]);
    }
}