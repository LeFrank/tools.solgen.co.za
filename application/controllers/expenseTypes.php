<?php

class ExpenseTypes extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Expense Types";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');
        $this->load->helper("usability_helper");
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('expense_type_model');
    }

    public function manage() {
        $this->load->helper("array_helper");
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Manage Expense Types"));
        $this->load->view('expenses/expense_nav');
        $this->load->view("expense_types/manage", $data);
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
            $this->load->view("expense_types/manage");
            $this->load->view("footer");
        } else {
            if (!$this->expense_type_model->doesItExist($this->session->userdata("user")->id, $this->input->post('description'))) {
                $this->expense_type_model->create_expense_type();
            }
            $data["status"] = "Created Expense Type";
            $data["action_classes"] = "success";
            $data["action_description"] = "Create personalized expense type";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully created your own expense_type";

            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
            unset($_POST);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_types/manage", $data);
            $this->load->view("footer");
        }
    }

    public function delete($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Delete Expense Type";
        //check if this expense type belongs to you?
        if ($this->expense_type_model->doesItBelongToMe($mySession, $id)) {
            $data["action_classes"] = "success";
            $data["action_description"] = "Delete Expense Type";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully deleted the expense type";
            $this->expense_type_model->delete($id);
            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_types/manage", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete Expense Type";
            $data["message_classes"] = "failure";
            $data["message"] = "The expense type does not exist or it does not belong to you.";

            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_types/manage", $data);
            $this->load->view("footer");
        }
    }

    public function edit($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Edit Expense Type";
        //check if this expense type belongs to you?
        if ($this->expense_type_model->doesItBelongToMe($mySession, $id) || $this->expense_type_model->isItGlobal($mySession, $id)) {
            $data['expenseType'] = $this->expense_type_model->get_expense_type($id);
            //show new page
            $this->load->view("header");
            $this->load->view("expense_types/edit", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit Expense Type";
            $data["message_classes"] = "failure";
            $data["message"] = "The expense type does not exist or it does not belong to you.";

            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_types/manage", $data);
            $this->load->view("footer");
        }
    }

    public function getExpenseTypeById($id=null){
        if(null == $id){
            echo json_encode(array("error" => "invalid ID" ));
        }
        $mySession = $this->session->userdata("user")->id;
//        $this->expense_type_model->doesItBelongToMe($mySession, $id);
        $data['expenseType'] = $this->expense_type_model->get_expense_type($id);
        echo json_encode($data['expenseType']);
    }
    
    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["status"] = "Update Expense Type";
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id'));
        } else {
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Expense Type";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the expense type";
            $this->expense_type_model->update($this->input->post('id'));
            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_types/manage", $data);
            $this->load->view("footer");
        }
    }

}
