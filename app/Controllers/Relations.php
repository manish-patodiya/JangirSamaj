<?php

namespace App\Controllers;

class Relations extends BaseController
{
    public $session;
    public $relationsmodel;
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
        $this->relationsmodel = model('Relations');

    }
    public function index()
    {
        $data = [
            'session' => $this->session,
            'messages' => model('MembersProfileModel')->getUnseenMessages(),
        ];
        return view('dashboard/content/relations', $data);
    }
    // function to get relations and show them in table format with actions
    public function relations()
    {
        $rmodel = $this->relationsmodel->getAll();
        $arr = [];
        foreach ($rmodel as $k => $v) {
            $arr[] = [
                $v->relation,
                "<a class='fas fa-edit me-1 btn-edit' title ='Edit relations' uid='$v->id'></a><a  class='fas fa-trash text-danger me-1 btn-dlt' title='Delete relations' uid='$v->id'></a>",
            ];
        }
        echo json_encode([
            "status" => 1,
            "relations" => $arr,
        ]);
    }
    // function to add new relation in database on click add button
    public function insertRelations()
    {
        $rmodel = $this->relationsmodel;
        $relations = $this->request->getPost('name');
        $data = [
            "relation" => $relations,
        ];
        $rmodel->insertData($data);
        echo json_encode([
            "status" => 1,
            "msg" => "New relations inserted successfully",
        ]);
    }
    // function to edit relations
    public function editRelations()
    {
        $rmodel = $this->relationsmodel;
        $id = $this->request->getpost('uid');
        $column = [
            "relation" => $this->request->getPost('name'),
        ];
        $data = $rmodel->updateRow($column, "id='$id'");
        echo json_encode([
            "status" => 1,
            "msg" => "Your relation edited successfully",
        ]);
    }
    // function to get all relations from database and show them in table
    public function getRelations()
    {
        $rmodel = $this->relationsmodel;
        $id = $this->request->getPost('id');
        $name = $rmodel->getFields('relation', "id='$id'")['relation'];
        echo json_encode([
            "status" => 1,
            "name" => $name,
        ]);
    }
    // function to delete relation from table
    public function deleteRelations()
    {
        $rmodel = $this->relationsmodel;
        $id = $this->request->getPost('id');
        $rmodel->deleteRow($id);
        echo json_encode([
            "status" => 1,
            "msg" => "Relations was deleted successfully",
        ]);
    }
}