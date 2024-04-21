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
        $this->load->view('incomes/income_nav');
        $this->load->view('incomes/view', $data);
        $this->load->view('footer');
    }

    public function history(){
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->helper("usability_helper");
        $this->load->library('session');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["expensePeriods"] = $this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id, 5, null);
        //$data["startAndEndDateOfWeek"] = getStartAndEndDateforWeek(date('W'), date('Y'));
        $data["startAndEndDateforMonth"] = getStartAndEndDateforMonth(date("m"), date('Y'));
        $data["incomesForPeriod"] = $this->income_model->getIncomesbyDateRange($data["startAndEndDateforMonth"][0], $data["startAndEndDateforMonth"][1], $this->session->userdata("user")->id);
        $data["history_table"] = $this->load->view('incomes/history_table', $data, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('incomes/income_nav');
        $this->load->view('incomes/history', $data);
        $this->load->view('footer');

    }

    public function delete($id) {
        $data["incomeTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        if ($this->income_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
            $data["income"] = $this->income_model->delete($id);
            $data["income"] = $this->income_model->getIncomes($this->session->userdata("user")->id, 5);
            $data["status"] = "Deleted Income";
            $data["action_classes"] = "success";
            $data["action_description"] = "Deleted an income";
            $data["message_classes"] = "success";
            $data["message"] = "The income was successfully deleted";
            $data["reUrl"] = "/incomes";
            $this->load->view('header', $data);
            $this->load->view('incomes/income_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('incomes/view', $data);
            $this->load->view('footer');
        } else {
            $data["income"] = $this->income_model->getIncomes($this->session->userdata("user")->id, 5);
            $data["status"] = "Delete Income";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete an income";
            $data["message_classes"] = "failure";
            $data["message"] = "The income you are attempting to delete does not exist or does not belong to you.";
            $data["reUrl"] = "/incomes";
            $data["income"] = $this->income_model->getIncomes($this->session->userdata("user")->id, 5);
            $this->load->view('header', $data);
            $this->load->view('incomes/income_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('incomes/view', $data);
            $this->load->view('footer');
        }
    }

    public function filteredSearch() {
        $this->load->helper('url');
        $this->load->helper('form');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        // print_r(array($this->input->post("fromDate"), $this->input->post("toDate")));
        $data["startAndEndDateforMonth"] = array($this->input->post("fromDate"), $this->input->post("toDate"));
        $data['incomesForPeriod'] = $this->income_model->getincomesByCriteria($this->session->userdata("user")->id);
        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        echo $this->load->view('incomes/history_table', $data, true);
    }

}