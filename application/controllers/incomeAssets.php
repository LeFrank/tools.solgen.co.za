<?php

class IncomeAssets extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Income Assets";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');
        $this->load->helper("usability_helper");
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('income_asset_model');
    }

    public function manage() {
        $this->load->helper("array_helper");
        $data["incomeAssets"] = mapKeyToId($this->income_asset_model->get_only_user_income_assets($this->session->userdata("user")->id), false);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Manage Income Assets"));
        $this->load->view('expenses/expense_nav');
        $this->load->view("income_assets/manage", $data);
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
            $this->load->view("income_assets/manage");
            $this->load->view("footer");
        } else {
            if (!$this->income_asset_model->doesItExist($this->session->userdata("user")->id, $this->input->post('description'))) {
                $this->income_asset_model->createIncomeAsset();
            }
            $data["status"] = "Created Payment Method";
            $data["action_classes"] = "success";
            $data["action_description"] = "Create personalized payment method";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully created your own payment method";

            $data["incomeAssets"] = mapKeyToId($this->income_asset_model->get_only_user_income_assets($this->session->userdata("user")->id), false);
            unset($_POST);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_assets/manage", $data);
            $this->load->view("footer");
        }
    }

    public function delete($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Delete Payment Method";
        //check if this payment method belongs to you?
        if ($this->income_asset_model->doesItBelongToMe($mySession, $id)) {
            $data["action_classes"] = "success";
            $data["action_description"] = "Delete Payment Method";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully deleted the expense type";
            $this->income_asset_model->delete($id);
            $data["incomeAssets"] = mapKeyToId($this->income_asset_model->get_only_user_income_assets($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_assets/manage", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete Payment Method";
            $data["message_classes"] = "failure";
            $data["message"] = "The payment method does not exist or it does not belong to you.";

            $data["incomeAssets"] = mapKeyToId($this->income_asset_model->get_only_user_income_assets($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_assets/manage", $data);
            $this->load->view("footer");
        }
    }

    public function edit($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Edit Payment Method";
        //check if this payment method belongs to you?
        if ($this->income_asset_model->doesItBelongToMe($mySession, $id)) {
            $data['paymentMethod'] = $this->income_asset_model->get_payment_method($id);
            //show new page
            $this->load->view("header");
            $this->load->view("income_assets/edit", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit Payment Method";
            $data["message_classes"] = "failure";
            $data["message"] = "The payment method does not exist or it does not belong to you.";

            $data["incomeAssets"] = mapKeyToId($this->income_asset_model->get_only_user_income_assets($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_assets/manage", $data);
            $this->load->view("footer");
        }
    }

    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["status"] = "Update Payment Method";
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id'));
        } else {
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Payment Method";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the payment method";
            $this->income_asset_model->update($this->input->post('id'));
            $data["incomeAssets"] = mapKeyToId($this->income_asset_model->get_only_user_income_assets($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("income_assets/manage", $data);
            $this->load->view("footer");
        }
    }

}
