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
        if ($this->session->userdata("isAdmin")) {
            $this->load->model("timetable_model");
            $this->load->model("timetable_category_model");
            $this->load->model("expense_period_model");
            $this->load->model("expense_budget_model");
            $this->load->model("expense_model");
            $this->load->model("expense_type_model");
            $this->load->model("expense_budget_item_model");
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
            //$this->expenseBudgetItems->manage(7);
            // get admin data
            // what is admin data?
            $data["registered_users"] = $this->user_model->get_admin_data();
            $this->load->view('home/admin-dashboard', $data);
        } else {
            $this->load->model("timetable_model");
            $this->load->model("timetable_category_model");
            $this->load->model("expense_period_model");
            $this->load->model("expense_budget_model");
            $this->load->model("expense_model");
            $this->load->model("expense_type_model");
            $this->load->model("expense_budget_item_model");
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
            $this->load->view('home/user-dashboard');
        }
        $this->load->view('footer');
    }

}
