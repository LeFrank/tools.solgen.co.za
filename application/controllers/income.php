<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Income extends CI_Controller {

    var $toolId = 1;
    var $toolName = "Income";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
        $this->load->helper('tool_info_helper');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('income_model');
        // $this->load->model('income_type_model');
        $this->load->model('expense_type_model');
        $this->load->model('payment_method_model');
        $this->load->model('expense_period_model');
        // $this->load->model('user_expense_type_model');
//        $this->session->keep_flashdata('expenses');
        $this->load->model("user_content_model");
    }

    public function capture() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $userId = $this->session->userdata("user")->id;
        $data['title'] = 'Capture Income';

        $this->form_validation->set_rules('amount', 'amount', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->view();
        } else {
            // print_r($this->input->post());
            $data["income"] = $this->income_model->capture_income();
            $data["status"] = "Income Captured";
            $data["action_classes"] = "success";
            $data["message_classes"] = "success";
            $data["action_description"] = "Capture an Income";
            $data["message"] = "The income was captured. ";
            $this->session->set_flashdata("success", $this->load->view('general/action_status', $data, true));
            redirect("/income/view", "refresh");
        }
    }

    public function view() {
        $this->load->library('session');
        $data["incomeTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["income"] = $this->income_model->getIncomes($this->session->userdata("user")->id, 5);
        // // echo "<pre>";
        // // print_r($data["expense"]);
        // // echo "</pre>";
        // // exit;
        $data["css"] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';
        $data["js"] = '';
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('income/income_nav');
        $this->load->view('income/view', $data);
        $this->load->view('footer');
    }
}