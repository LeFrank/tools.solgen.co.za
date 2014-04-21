<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Expenses extends CI_Controller {

    var $require_auth = true;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('expense_model');
        $this->load->model('expense_type_model');
        $this->load->model('payment_method_model');
        //$this->load->model('user_expense_type_model');
    }

    public function view() {
        $this->load->library('session');
        $this->load->helper("array_helper");
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id));
        $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/view', $data);
        $this->load->view('footer');
    }

    public function capture() {
        echo "capture";
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('amount', 'amount', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->view();
        } else {
            $data["expense"] = $this->expense_model->capture_expense();
            redirect("/expenses/view", "refresh");
        }
    }

    public function delete() {
        echo __FUNCTION__;
        exit;
    }

    public function history() {
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->library('session');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id));
        $data["startAndEndDateOfWeek"] = getStartAndEndDate(date('W'), date('Y'));
        $data["expensesForWeek"] = $this->expense_model->getExpensesbyDateRange($data["startAndEndDateOfWeek"][0], $data["startAndEndDateOfWeek"][1], $this->session->userdata("user")->id);
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/history', $data);
        $this->load->view('footer');
    }

    public function filteredSearch() {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($this->expense_model->getexpensesByCriteria($this->session->userdata("user")->id)));
        return $this->output->get_output();
    }
}
