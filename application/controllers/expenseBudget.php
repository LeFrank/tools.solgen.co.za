<?php

class ExpenseBudget extends CI_Controller {

    var $require_auth = true;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('expense_budget_model');
        $this->load->model('expense_period_model');
    }

    public function capture() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data['title'] = 'Create an expense';
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data["expenseBudgets"] = $this->expense_budget_model->getExpenseBudgets();
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
            $this->load->view('header');
            $this->load->view('expenses/expense_nav');
            $this->load->view('expense_budget/manage', $data);
            $this->load->view('footer');
        } else {
            $data["expenseBudgets"] = $this->expense_budget_model->capture_expense_budget();
            redirect("/expense-budget/manage", "refresh");
        }
    }

    public function delete($id) {
        $data["expenseBudgets"] = $this->expense_budget_model->delete($id);
        redirect("/expense-budget/manage", "refresh");
    }

    public function edit($id) {
        if ($this->expense_budget_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
            $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($id);
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
        } else {
            
        }
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expense_budget/edit', $data);
        $this->load->view('footer');
    }

    public function getBudgets($budgetIds) {
        
    }

    public function history() {
        
    }

    public function manage() {
        $data["expenseBudgets"] = $this->expense_budget_model->getExpenseBudgets($this->session->userdata("user")->id, 12, false);
        $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expense_budget/manage', $data);
        $this->load->view('footer');
    }

    public function statistics() {
        
    }

    public function view() {
        
    }

    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post("id"));
        } else {
            $this->expense_budget_model->update();
            $data["status"] = "Edit Budget";
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Budget";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the budget";
            $data["expenseBudgets"] = $this->expense_budget_model->getExpenseBudgets($this->session->userdata("user")->id, 12, false);
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
            $this->load->view('header');
            $this->load->view('expenses/expense_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('expense_budget/manage', $data);
            $this->load->view('footer');
        }
    }

}
