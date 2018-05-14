<?php

class ExpenseBudgetItems extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Expenses Budget Items";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->helper('wishlist');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('expense_budget_model');
        $this->load->model('expense_period_model');
        $this->load->model('expense_budget_item_model');
        $this->load->model('expense_model');
        $this->load->model('expense_type_model');
        $this->load->model('wishlist_model');
    }

    public function capture() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->expense_budget_item_model->capture_expense_budget_items();
        redirect("/expense-budget-items/items/". $this->input->post('budget-id'), "refresh");
    }

    public function comment($itemId){
        $this->load->library('session');
        $this->load->helper('form');
        $comment = $this->input->post("value");
        if(empty($comment)){
            echo "Invalid Data";
            return "Invalid Data";
        }
        $item = $this->expense_budget_item_model->getItemById($itemId);
        //$item->comment = $this->input->post("comment");
         $item->comment = $this->input->post("value");
        //echo $this->expense_budget_item_model->updateByItem($item);
        $this->expense_budget_item_model->updateByItem($item);
        echo $this->expense_budget_item_model->getItemById($itemId)->comment;
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
        $this->load->helper("usability_helper");
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
//        print_r($data["expensePeriod"]);
        $data["wishlistItemsForPeriod"] = $this->wishlist_model->getItemsbyDateRange($data["expensePeriod"]->start_date, $data["expensePeriod"]->end_date, $this->session->userdata("user")->id);
//        $data["wishlistItems"] = mapKeyTo($data["wishlistItemsForPeriod"], "expense_type_id");
//        echo  "<pre>";
//        print_r(array($data["wishlistItemsForPeriod"], $data["wishlistItems"]));
//        echo  "</pre>";
        $data["priorities"] = getWishlistPriorities();
        $data["statuses"] = getWishlistStatuses();
        $data["includeActions"] = FALSE;
        $data["itemsTable"] = $this->load->view('wishlist/itemTable', $data, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Budget Item limits"));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expense_budget_item/manage', $data);
        $this->load->view('expense_budget_item/budget_items_assigned', $data);
        $this->load->view('footer');
    }

    public function getExpensesPerTypeFromPeriod($budgetId) {
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        $userId = $this->session->userdata("user")->id;
        $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($budgetId);
        $data['previousBudget'] = $this->expense_budget_model->getPreviousBudget($userId, $budgetId);
        $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($data['previousBudget']->expense_period_id);
        $data["currentBudgetExpensePeriod"] = $this->expense_period_model->getExpensePeriod($data["expenseBudget"]->expense_period_id);
        $data["previousExpenseBudgetItems"] = mapKeyTo($this->expense_budget_item_model->getExpenseBudgetItems($data['previousBudget']->id) , "expense_type_id" );
//        echo "<pre>";
//        print_r($data["previousExpenseBudgetItems"]);
//        echo "</pre>";
        $data["wishlistItemsForPeriod"] = $this->wishlist_model->getItemsbyDateRange($data["currentBudgetExpensePeriod"]->start_date, $data["currentBudgetExpensePeriod"]->end_date, $this->session->userdata("user")->id);
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
