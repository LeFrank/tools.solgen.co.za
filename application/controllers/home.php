<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('json_helper');
        $this->load->helper('date_helper');
        $this->load->helper('array_helper');
        $this->load->helper('expense_statistics_helper');
    }

    public function attributions(){
        $this->load->view('header');
        $this->load->view('copyright_and_attributions');
        $this->load->view('footer');
    }
    
    function index() {
        $this->load->helper('cookie');
        if (null != $this->input->cookie("tools.remember")) {
            //login
            print_r($this->input->cookie("tools.remember"));
        }
        $this->load->helper('email');
        $this->load->library('form_validation');
        $this->load->view('header');
        $this->load->view('home/home');
        $this->load->view('footer');
    }

    function dashboard() {
        $this->load->view('header');
        $this->load->helper('url');
        if (empty($this->session->userdata["loggedIn"])) {
                redirect('/', 'refresh');
        }else if(!$this->session->userdata["loggedIn"]){
            redirect('/', 'refresh');
        }
        $this->load->model("timetable_model");
        $this->load->model("timetable_category_model");
        $this->load->model("expense_period_model");
        $this->load->model("expense_budget_model");
        $this->load->model("expense_model");
        $this->load->model("expense_type_model");
        $this->load->model("expense_budget_item_model");

        // Load user tasks table for this coming week. 
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        $this->load->library('form_validation');
        $this->load->model("tasks_model");
        $this->load->model("tasks_domains_model");
        $this->load->model("tasks_status_model");
        $this->load->library("../controllers/tasks");
        $userId = $this->session->userdata("user")->id;
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        $data["importanceLevels"] = $this->tasks->importanceLevels;
        $data["urgencyLevels"] = $this->tasks->urgencyLevels;
        $data["riskLevels"] = $this->tasks->riskLevels;
        $data["gainLevels"] = $this->tasks->gainLevels;
        $data["rewardsCategory"] = $this->tasks->rewardsCategory;
        $data["cycles"] = $this->tasks->cycles;
        $data["scales"] = $this->tasks->scales;
        $data["scopes"] = $this->tasks->scopes;
        $data["startAndEndDateforMonth"] = getStartAndEndDateforWeek(date("w"), date('Y'));
        // print_r($data["startAndEndDateforMonth"]);
        $this->load->helper("tasks_helper");
        $tasks = $this->tasks_model->getActiveTasks($userId, null, 0, "target_date", "asc");
        foreach($tasks as $task){
            $age = getTaskAgeByCreateDate($task);
            $task["age"] = $age;
            if (!in_array($task['status_id'], array(2))) {
                $data["tasks"][] = $task;
            }
        }
        // print_r($data["tasks"]);
        $data["history_table"] = $this->load->view('tasks/history_table', $data, true);

        if ($this->session->userdata("isAdmin")) {
            $data["css"] = "<link href='/css/third_party/fullcalendar/fullcalendar.css' rel='stylesheet' />
                            <link href='/css/third_party/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />";
            $user = $this->session->userdata("user");
            //get calendar data
            $data["startAndEndDateOfWeek"] = getNextSevenDays(date('N'), date('Y'));
            $search["startDate"] = $data["startAndEndDateOfWeek"][0];
            $search["endDate"] = $data["startAndEndDateOfWeek"][1];
            $search["showOnDashboard"] = 1;
            $search["dashboardCategories"] = $this->timetable_category_model->get_filtered_timetable_categories($search);
            $data["entries"] = $this->timetable_model->getFilteredTimetableEvents($user->id, $search);
            $data["eventsView"] = $this->load->view("/timetable/searchEntries", $data, true);
            // get budget data
            $data["currentExpensePeriod"] = $this->expense_period_model->getCurrentExpensePeriod($user->id);

            $data["currentExpenseBudget"] = $this->expense_budget_model->getExpenseBudgetByPeriodId($data["currentExpensePeriod"]->id);
            if(!empty($data["currentExpenseBudget"])){
            $data["budgetId"] = $data["currentExpenseBudget"]->id;
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
            // get admin data
            // what is admin data?
            $data["registered_users"] = $this->user_model->get_admin_data();
            $this->load->view('home/admin-dashboard', $data);
        } else {

            $data["css"] = "<link href='/css/third_party/fullcalendar/fullcalendar.css' rel='stylesheet' />
                            <link href='/css/third_party/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />";
            $user = $this->session->userdata("user");
            //get calendar data
            $data["startAndEndDateOfWeek"] = getNextSevenDays(date('N'), date('Y'));
            $search["startDate"] = $data["startAndEndDateOfWeek"][0];
            $search["endDate"] = $data["startAndEndDateOfWeek"][1];
            $search["showOnDashboard"] = 1;
            $search["dashboardCategories"] = $this->timetable_category_model->get_filtered_timetable_categories($search);
            $data["entries"] = $this->timetable_model->getFilteredTimetableEvents($user->id, $search);
            $data["eventsView"] = $this->load->view("/timetable/searchEntries", $data, true);
            // get budget data
            $data["currentExpensePeriod"] = $this->expense_period_model->getCurrentExpensePeriod($user->id);
            if (!empty($data["currentExpensePeriod"])) {
                $data["currentExpenseBudget"] = $this->expense_budget_model->getExpenseBudgetByPeriodId($data["currentExpensePeriod"]->id);
                $data["budgetId"] = $data["currentExpenseBudget"]->id;
                $data["expenseBudget"] = $this->expense_budget_model->getExpenseBudget($data["budgetId"]);
                $data["expenseBudgetItems"] = $this->expense_budget_item_model->getExpenseBudgetItems($data["budgetId"]);
                $data["expensePeriod"] = $this->expense_period_model->getExpensePeriod($data["expenseBudget"]->expense_period_id);
                $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
                $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                        date('Y/m/d H:i', strtotime($data["expensePeriod"]->start_date)), date('Y/m/d H:i', strtotime($data["expensePeriod"]->end_date)), $this->session->userdata("user")->id, null, null, "amount", "desc"
                );
                $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
                $data["eventsBudget"] = $this->load->view('expense_budget_item/manage', $data, true);
                $data["eventsBudgetItems"] = $this->load->view('expense_budget_item/budget_items_assigned', $data, true);
            }
            //$this->expenseBudgetItems->manage(7);
//            print_r($data);
            $this->load->view('home/user-dashboard');

            
        }


        $this->load->view('footer');
    }
    
    public function termsAndConditions(){
        $this->load->view('header');
        $this->load->view('terms_and_conditions');
        $this->load->view('footer');
    }

    public function test(){
        echo "-->>";
    }
}
