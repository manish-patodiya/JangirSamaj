<?php

namespace App\Controllers;

class Gotras extends BaseController
{
    public $gotramodel;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('common');
        $uri = service('uri');
        if (!$this->session->get('is_login') && !($uri->getTotalSegments() > 1 && $uri->getSegment(2) == 'validgotra')) {
            header("Location:" . base_url());
            exit;
        } else if ($this->session->user_details['active_role_id'] > 1) {
            header("Location:" . base_url('dashboard'));
            exit;
        } else if (!$this->session->get('user_details')['complete_profile']) {
            header("Location:" . base_url("profile/editProfile/" . base64_encode($this->session->get('user_details')['id'])));
            exit;
        }
        $this->gotramodel = model('Gotra');
    }

    public function index()
    {
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
        ];
        return view('dashboard/content/gotras', $data);
    }
// function to check entered gotra is valid or not
    public function validGotra()
    {
        $gmodel = $this->gotramodel;
        $id = $this->request->getPost('gotra_id');
        $gotra = $gmodel->getGotra($id);
        if (!$gotra) {
            echo json_encode([
                "status" => 0,
                "msg" => "Enterd gotra is not correct",
            ]);
        } else {
            echo json_encode([
                "status" => 1,
                "msg" => "Enterd gotra is correct",
            ]);
        }
    }
    //function to get all gotras and show them in tabular format
    public function gotras()
    {
        $gmodel = $this->gotramodel->getAll();
        $arr = [];
        foreach ($gmodel as $k => $v) {
            $arr[] = [
                $v->gotra,
                "<a class='fas fa-edit me-1 btn-edit' title ='Edit gotra' uid='$v->id'></a><a  class='fas fa-trash text-danger me-1 btn-dlt' title='Delete gotra' uid='$v->id'></a>",
            ];
        }
        echo json_encode([
            "status" => 1,
            "gotras" => $arr,
        ]);
    }
    // function to add new gotra on click add button
    public function insertGotra()
    {
        $gmodel = $this->gotramodel;
        $gotra = $this->request->getPost('name');
        $data = [
            "gotra" => $gotra,
        ];
        $gmodel->insertData($data);
        echo json_encode([
            "status" => 1,
            "msg" => "New gotra inserted successfully",
        ]);
    }
    // function to edit gotra on click edit icon
    public function editGotra()
    {
        $gmodel = $this->gotramodel;
        $id = $this->request->getpost('uid');
        $column = [
            "gotra" => $this->request->getPost('name'),
        ];
        $data = $gmodel->updateRow($column, "id='$id'");
        echo json_encode([
            "status" => 1,
            "msg" => "Your gotra edited successfully",
        ]);
    }
    public function getGotra()
    {
        $gmodel = $this->gotramodel;
        $id = $this->request->getPost('id');
        $name = $gmodel->getField('gotra', "id='$id'")['gotra'];
        echo json_encode([
            "status" => 1,
            "name" => $name,
        ]);
    }
    // function to delete gotra on click delete icon
    public function deleteGotra()
    {
        $gmodel = $this->gotramodel;
        $id = $this->request->getPost('id');
        $gmodel->deleteRow($id);
        echo json_encode([
            "status" => 1,
            "msg" => "Gotra was deleted successfully",
        ]);
    }
}