<?php

class IncomeTypes extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Income Types";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');
        $this->load->helper("usability_helper");
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('income_type_model');
    }

    public function manage() {
        $this->load->helper("array_helper");
        $data["incomeTypes"] = mapKeyToId($this->income_type_model->get_only_user_income_types($this->session->userdata("user")->id), false);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Manage Income Types"));
        $this->load->view('incomes/income_nav');
        $this->load->view("income_types/manage", $data);
        $this->load->view("footer");
    }

    public function capture() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view("header");
            $this->load->view("income_types/manage");
            $this->load->view("footer");
        } else {
            if (!$this->income_type_model->doesItExist($this->session->userdata("user")->id, $this->input->post('description'))) {
                $this->income_type_model->create_income_type();
            }
            $data["status"] = "Created Income Type";
            $data["action_classes"] = "success";
            $data["action_description"] = "Create personalized Income type";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully created your own Income_type";

            $data["incomeTypes"] = mapKeyToId($this->income_type_model->get_only_user_income_types($this->session->userdata("user")->id), false);
            unset($_POST);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_types/manage", $data);
            $this->load->view("footer");
        }
    }

    public function delete($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Delete Income Type";
        //check if this income type belongs to you?
        if ($this->income_type_model->doesItBelongToMe($mySession, $id)) {
            $data["action_classes"] = "success";
            $data["action_description"] = "Delete Income Type";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully deleted the Income type";
            $this->income_type_model->delete($id);
            $data["incomeTypes"] = mapKeyToId($this->income_type_model->get_only_user_income_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_types/manage", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete Income Type";
            $data["message_classes"] = "failure";
            $data["message"] = "The income type does not exist or it does not belong to you.";

            $data["incomeTypes"] = mapKeyToId($this->income_type_model->get_only_user_income_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_types/manage", $data);
            $this->load->view("footer");
        }
    }

    public function edit($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Edit income Type";
        //check if this income type belongs to you?
        if ($this->income_type_model->doesItBelongToMe($mySession, $id) || $this->income_type_model->isItGlobal($mySession, $id)) {
            $data['incomeType'] = $this->income_type_model->get_income_type($id);
            //show new page
            $this->load->view("header");
            $this->load->view("income_types/edit", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit Income Type";
            $data["message_classes"] = "failure";
            $data["message"] = "The Income type does not exist or it does not belong to you.";

            $data["incomeTypes"] = mapKeyToId($this->income_type_model->get_only_user_income_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_types/manage", $data);
            $this->load->view("footer");
        }
    }

    public function getincomeTypeById($id=null){
        if(null == $id){
            echo json_encode(array("error" => "invalid ID" ));
        }
        $mySession = $this->session->userdata("user")->id;
//        $this->income_type_model->doesItBelongToMe($mySession, $id);
        $data['incomeType'] = $this->income_type_model->get_income_type($id);
        echo json_encode($data['incomeType']);
    }
    
    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["status"] = "Update Income Type";
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id'));
        } else {
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Income Type";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the Income type";
            $this->income_type_model->update($this->input->post('id'));
            $data["incomeTypes"] = mapKeyToId($this->income_type_model->get_only_user_income_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_types/manage", $data);
            $this->load->view("footer");
        }
    }

}
