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
        $this->expense_budget_item_model->capture_expense_budget_items();
        redirect("/expense-budget-items/items/". $this->input->post('budget-id'), "refresh");
    }

    public function comment($itemId){
        $this->load->library('session');
        if(empty($this->input->post("comment"))){
            echo "Invalid Data";
            return "Invalid Data";
        }
        $item = $this->expense_budget_item_model->getItemById($itemId);
        $item->comment = $this->input->post("comment");
        echo $this->expense_budget_item_model->updateByItem($item);
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
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        if ($budgetId != null) {
            $data["budgetId"] = $budgetId;
            $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($budgetId);
            $data["expenseBudgetItems"] = $this->expense_budget_item_model->getExpenseBudgetItems($budgetId);
            $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($data["expenseBudget"]->expense_period_id);
            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
            $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                    date('Y/m/d H:i', strtotime($data["expensePeriod"]->start_date)), date('Y/m/d H:i', strtotime($data["expensePeriod"]->end_date)), $this->session->userdata("user")->id, null, null, "amount", "desc"
            );
            $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
        }
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expense_budget_item/manage', $data);
        $this->load->view('expense_budget_item/budget_items_assigned', $data);
        $this->load->view('footer');
    }

    public function getExpensesPerTypeFromPeriod($budgetId) {
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($budgetId);
        $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($data["expenseBudget"]->expense_period_id - 1);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                date('Y/m/d H:i', strtotime($data["expensePeriod"]->start_date)), date('Y/m/d H:i', strtotime($data["expensePeriod"]->end_date)), $this->session->userdata("user")->id, null, null, "amount", "desc"
        );
        $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
        $data["expensesTotal"] = getExpensesTotal($expensesForPeriod);
        $data["budgetId"] = $budgetId;
        $data["periodId"] = $data["expenseBudget"]->expense_period_id;
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
