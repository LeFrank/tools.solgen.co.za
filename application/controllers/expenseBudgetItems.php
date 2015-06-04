<?php

class ExpenseBudgetItems extends CI_Controller {

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
        $this->load->model('expense_budget_item_model');
        $this->load->model('expense_model');
        $this->load->model('expense_type_model');
    }

    public function capture() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        echo "<pre>";
        print_r($this->input->post());
        echo "</pre>";
        /*$data['title'] = 'Create an expense';
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
            redirect("/expensesBudget/manage", "refresh");
        }*/
    }

    public function delete($id) {
        
    }

    public function edit($id) {
        
    }

    public function getBudgets($budgetIds) {
        
    }

    public function history() {
        
    }

    public function manage($budgetId = null) {
        if ($budgetId != null) {
            $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($budgetId);
        }
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expense_budget_item/manage', $data);
        $this->load->view('footer');
    }

    public function getExpensesPerTypeFromPeriod($budgetId , $periodId = null) {
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($budgetId);
        if ($periodId != null) {
            $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($periodId);
        }
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                date('Y/m/d H:i', strtotime($data["expensePeriod"]->start_date)), date('Y/m/d H:i', strtotime($data["expensePeriod"]->end_date)), $this->session->userdata("user")->id, null, null, "amount", "desc"
        );
        $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
        $data["expensesTotal"] = getExpensesTotal($expensesForPeriod);
        $data["budgetId"] = $budgetId;
        $data["periodId"] = $periodId;
        $html = $this->load->view('header_no_banner', null, TRUE);
        $html .= $this->load->view("expense_budget_item/previous_expense_limits", $data, TRUE);
        echo $html;
    }

    public function statistics() {
        
    }

    public function view() {
        
    }

    public function update() {
        
    }

}
