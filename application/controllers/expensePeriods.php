<?php

class ExpensePeriods extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Expense Periods";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');
        $this->load->helper("usability_helper");
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('expense_period_model');
        $this->load->library('pagination');
    }

    public function manage($page=null) {
        $this->load->helper("array_helper");
        if ($page == null) {
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/expense-periods/manage/page/1';
            $config['per_page'] = 10;
            $config['total_rows'] = 10;
            $this->pagination->initialize($config);
        } else {
            $this->pagination->uri_segment = 4;
        }
        $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/expense-periods/manage/page/';
        $this->pagination->per_page = 10;
        $this->pagination->use_page_numbers = TRUE;
        $this->pagination->cur_page = $page;
        $user = $this->session->userdata("user");
        $data["statusArr"] = $this->session->flashdata('status');
        $data["expensePeriods"] = mapKeyToId(
            $this->expense_period_model->getExpensePeriods($user->id,$this->pagination->per_page, (($page != null) ? ($page-1) * $this->pagination->per_page : null)), false);
        $data["totalExpensePeriods"] = $this->pagination->total_rows = $this->expense_period_model->getExpensePeriods($user->id, null, null, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Manage Expense Periods"));
        $this->load->view('expenses/expense_nav');
        if (!empty($data["statusArr"])) {
            $data["status"] = $data["statusArr"]["status"];
            $data["action_classes"] = strtolower($data["statusArr"]["status"]);
            $data["action_description"] = $data["statusArr"]["message"];
            $data["message_classes"] = strtolower($data["statusArr"]["status"]);
            $data["message"] = $data["statusArr"]["description"];
            $this->load->view('user/user_status', $data);
        }
        $this->load->view("expense_periods/manage", $data);
        $this->load->view("footer");
    }

    public function capture() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');

        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view("header");
            $this->load->view('expenses/expense_nav');
            $this->load->view("expense_periods/manage");
            $this->load->view("footer");
        } else {
            if (!$this->expense_period_model->doesItExist($this->session->userdata("user")->id, $this->input->post('description'))) {
                $this->expense_period_model->capture_expense_period();
            }
//            $data["status"] = "Created Expense Period";
//            $data["action_classes"] = "success";
//            $data["action_description"] = "Create expense period";
//            $data["message_classes"] = "success";
//            $data["message"] = "You have successfully created an expense period";
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Created Expense Period";
            $data["statusArr"]["description"] = "You have successfully created an expense period";
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
            unset($_POST);
            $this->load->view("header");
            $this->load->view('expenses/expense_nav');
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_periods/manage", $data);
            $this->load->view("footer");
            $this->session->set_flashdata('status', $data["statusArr"]);
            redirect("/expense-periods/manage", "refresh");
        }
        
    }

    public function delete($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Delete Expense Period";
        //check if this expense period belongs to you?
        $this->load->view("header");
        $this->load->view('expenses/expense_nav');
        if ($this->expense_period_model->doesItBelongToMe($mySession, $id)) {
            $data["action_classes"] = "success";
            $data["action_description"] = "Delete Expense Period";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully deleted the expense period";
            $this->expense_period_model->delete($id);
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
            $this->load->view("general/action_status", $data);
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete Expense Period";
            $data["message_classes"] = "failure";
            $data["message"] = "The expense period does not exist or it does not belong to you.";
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
        }
        $this->load->view("user/user_status", $data);
        $this->load->view("expense_periods/manage", $data);
        $this->load->view("footer");
    }

    public function edit($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Edit Expense Period";
        //check if this expense type belongs to you?
        if ($this->expense_period_model->doesItBelongToMe($mySession, $id)) {
            $data['expensePeriod'] = $this->expense_period_model->getExpensePeriod($id);
            //show new page
            $this->load->view("header");
            $this->load->view("expense_periods/edit", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit Expense Period";
            $data["message_classes"] = "failure";
            $data["message"] = "The expense period does not exist or it does not belong to you.";

            $data["expenseTypes"] = mapKeyToId($this->expense_period_model->get_only_user_expense_periods($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_periods/manage", $data);
            $this->load->view("footer");
        }
    }

    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["status"] = "Update Expense Period";
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id'));
        } else {
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Expense Period";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the expense period";
            $this->expense_period_model->update($this->input->post('id'));
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("expense_periods/manage", $data);
            $this->load->view("footer");
        }
    }

}
