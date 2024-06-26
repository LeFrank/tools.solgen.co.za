<?php

class ExpenseBudget extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Expenses Budget";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        can_access($this->require_auth, $this->session);
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

    public function comment($budgetId) {
        $this->load->library('session');
        $this->load->helper('form');
        $overSpendComment = $this->input->post("over_spend_comment");
        $underSpendComment = $this->input->post("under_spend_comment");
        $overallComment = $this->input->post("overall_comment");
        if (empty($overSpendComment) && empty($underSpendComment) && empty($overallComment)) {
            echo "Invalid Data";
            return "Invalid Data";
        }
        $budget = $this->expense_budget_model->getExpenseBudget($budgetId);
        if (!empty($overSpendComment)) {
            $budget->over_spend_comment = $overSpendComment;
        }
        if (!empty($underSpendComment)) {
            $budget->under_spend_comment = $underSpendComment;
        }
        if (!empty($overallComment)) {
            $budget->overall_comment = $overallComment;
        }
        echo $this->expense_budget_model->updateBudget($budget);
    }

    public function delete($id) {
        $data["expenseBudgets"] = $this->expense_budget_model->delete($id);
        redirect("/expense-budget/manage", "refresh");
    }

    public function edit($id) {
        $this->load->model("expense_period_model");
        $this->load->model("expense_budget_model");
        $this->load->model("expense_model");
        $this->load->model("expense_type_model");
        $this->load->model("expense_budget_item_model");       
        $this->load->helper("array_helper");
        $this->load->helper("expense_statistics_helper");
        $this->load->helper("expense_budget_post_analysis_helper");
        
        
        if ($this->expense_budget_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
            $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($id);
            $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id), false);
            if(!empty($data["expenseBudget"])){
                $data["budgetId"] = $data["expenseBudget"]->id;
                $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($data["budgetId"]);
                $data["expenseBudgetItems"] = $this->expense_budget_item_model->getExpenseBudgetItems($data["budgetId"]);
                $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($data["expenseBudget"]->expense_period_id);
                $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
                $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                        date('Y/m/d H:i', strtotime($data["expensePeriod"]->start_date)), date('Y/m/d H:i', strtotime($data["expensePeriod"]->end_date)), $this->session->userdata("user")->id, null, null, "amount", "desc"
                );
                $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
                $data["eventsBudget"] = $this->load->view('expense_budget_item/manage', $data, true);
                //$this->expenseBudgetItems->manage(7);
            }
            $data["eventsBudgetItems"] = $this->load->view('expense_budget_item/budget_items_assigned', $data, true);

            
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

    public function manage($page = null) {
        if ($page == null) {
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/expense-budget/manage/page/1';
            $config['per_page'] = 10;
            $config['total_rows'] = 10;
            $this->pagination->initialize($config);
        } else {
            $this->pagination->uri_segment = 4;
        }
        $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/expense-budget/manage/page/';
        $this->pagination->per_page = 10;
        $this->pagination->use_page_numbers = TRUE;
        $this->pagination->cur_page = $page;
        $user = $this->session->userdata("user");
        $data["expenseBudgets"] = $this->expense_budget_model->getExpenseBudgets(
            $user->id, 
            $this->pagination->per_page, 
            (($page != null) ? ($page -1) * $this->pagination->per_page : null)
        );
        $this->pagination->total_rows = $this->expense_budget_model->getExpenseBudgets($user->id, null, null, true);
        $data["expensePeriods"] = mapKeyToId($this->expense_period_model->getExpensePeriods($user->id), false);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Budget Management", ""));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expense_budget/manage', $data);
        $this->load->view('footer');
    }

    public function postAnalysis($budgetId = null) {
        $this->load->model('expense_budget_item_model');
        $this->load->model('expense_type_model');
        $this->load->model('expense_model');
        $this->load->helper("array_helper");
        $this->load->helper("expense_statistics_helper");
        $this->load->helper("expense_budget_post_analysis_helper");
        // Get budget
        $budget = $this->expense_budget_model->getExpenseBudget($budgetId);
        // save the end state of the expense budget items
        $data["budgetId"] = $budget->id;
        $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($budget->expense_period_id);
        $data["expenseBudget"] = $budget;
        $data["expenseBudgetItems"] = $this->expense_budget_item_model->getExpenseBudgetItems($budget->id);
        $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($data["expenseBudget"]->expense_period_id);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                date('Y/m/d H:i', strtotime($data["expensePeriod"]->start_date)), date('Y/m/d H:i', strtotime($data["expensePeriod"]->end_date)), $this->session->userdata("user")->id, null, null, "amount", "desc"
        );
        $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
        // process the data
        $postStateBudgetItems = analyseBudgetItemsEndState($data["expenseBudgetItems"], $data["expenseTypesTotals"]);
        $this->expense_budget_item_model->update_expense_budget_items($data["expenseBudgetItems"], $postStateBudgetItems);
        $data["expenseBudgetItems"] = $postStateBudgetItems;
        $data["totalSpent"] = totalSpent($data["expenseTypesTotals"]);
        $data["overSpentCategories"] = overSpentCategories($postStateBudgetItems);
        $data["underSpentCategories"] = underSpentCategories($postStateBudgetItems);
        // give answers to why I went over on those budget items also 
        // see a list of expenses for categories where I went over.
        // Show the overall state of the budget for that period.
        // Overall give an honest account of what went right and what went wrong in this period
        // What do I want to know after a month
        // What did I spend?
        // Where did I go wrong?
        // Where did I go right?
        // what was the category that I spent the most on, and can I shrink it next month?
        // If I had unexpected expenses. What was it, could I have foreseen this expense and planned for it
        //      if yes then add it to the time table and use it for forecasting
        //      if no, make a note of it for retrospective analysis over the year period.
        // 
        $this->load->view('header', getPageTitle($data, $this->toolName, "Budget Management", "Post Analysis: " . $data["expensePeriod"]->name));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expense_budget/post_analysis', $data);
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

    public function export($budgetId = null, $output = "csv") {
        $userId = $this->session->userdata("user")->id;
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('data_export_helper');
        $this->load->model('expense_budget_item_model');
        $this->load->model('expense_type_model');
        $this->load->model('expense_model');
        $this->load->model('payment_method_model');
        $this->load->helper("array_helper");
        $this->load->helper("expense_statistics_helper");
        $this->load->helper("expense_budget_post_analysis_helper");
        // Get budget
        $budget = $this->expense_budget_model->getExpenseBudget($budgetId);
        // save the end state of the expense budget items
        $data["budgetId"] = $budget->id;
        $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($budget->expense_period_id);
        $data["expenseBudget"] = $budget;
        $data["expenseBudgetItems"] = $this->expense_budget_item_model->getExpenseBudgetItems($budget->id);
        $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($data["expenseBudget"]->expense_period_id);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $expenseTypes = $data["expenseTypes"];
        $paymentMethods = $data["expensePaymentMethod"];
        $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                date('Y/m/d H:i', strtotime($data["expensePeriod"]->start_date)), date('Y/m/d H:i', strtotime($data["expensePeriod"]->end_date)), $this->session->userdata("user")->id, null, null, "amount", "desc"
        );
        $contentType = "application/vnd.ms-excel";
        // print_r($data);
        // exit;
        $expenseTypes = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $paymentMethods = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $budget_items = $data["expenseBudgetItems"];
        // $budget = $data["expenseBudget"];
        $expense_period = $data["expensePeriod"];
        // print_r($data["expensePeriod"]);
        // exit;
        switch ($output) {
            case "csv" :
                $data = csvify_budget_items($budget_items, $expenseTypes, $paymentMethods);
                $filename = "Budget_For_".trim($expense_period->name)."_Created_on_".date('YmdHi').".csv";
                $temp = tmpfile();
                foreach ($data as $k => $line) {
                    fputcsv($temp, $line);
                }
                $meta_data = stream_get_meta_data($temp);
                header('Content-Length: ' . filesize($meta_data["uri"])); //<-- sends filesize header
                header('Content-Type: ' . $contentType); //<-- send mime-type header
                header('Content-Disposition: inline; filename="' . $filename . '";'); //<-- sends filename header
                readfile($meta_data["uri"]); //<--reads and outputs the file onto the output buffer
                fclose($temp);
                die(); //<--cleanup
                exit; //and exit  
                break;
            case "json" :
                $contentType = "application/json";
                $data = json_encode($data);
                $this->output->set_content_type($contentType)->set_output($data);
                return $this->output->get_output();
                break;
            default:
                echo "Output type not supportted. Only .CSV & .JSON is presently supportted.";
                break;
        }
    }

}
