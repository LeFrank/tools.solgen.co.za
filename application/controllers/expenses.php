<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Expenses extends CI_Controller {

    var $toolId = 1;
    var $toolName = "Expenses";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('email');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('expense_model');
        $this->load->model('expense_type_model');
        $this->load->model('payment_method_model');
        $this->load->model('expense_period_model');
        //$this->load->model('user_expense_type_model');
        $this->session->keep_flashdata('expenses');
    }

    public function capture() {
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->helper("usability_helper");
        $this->load->library('session');
        $this->load->model("user_content_model");
        $userId = $this->session->userdata("user")->id;
        
        $this->form_validation->set_rules('amount', 'amount', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->view();
        } else {
            $data["expense"] = $this->expense_model->capture_expense();
            $data["remaining_budget"] = $this->getRemainingBudget(
                    $this->session->userdata("user")->id, $this->input->post('expenseType'), ($this->input->post('expenseDate') != "") ? date('Y-m-d H:i', strtotime($this->input->post('expenseDate'))) : date('Y-m-d H:i'));
            $data["status"] = "Expense Captured";
            $data["action_classes"] = "success";
            $data["message_classes"] = "success";
            $data["action_description"] = "Capture an expense";
            $data["message"] = "The expense was captured. " . $data["remaining_budget"];
            $data["user_content"] = 
            $this->user_content_model->uploadContent(
                    $userId, 
                    'csv|txt|png|jpg',
                    $this->toolId,
                    100000000, 
                    $private=0, 
                    $passwordProtect=0,
                    $data["expense"]
            );
            $data['title'] = 'Create an expense';
            if(key_exists("error",$data["user_content"])){
                $this->session->set_flashdata("fail", $this->load->view('general/action_status', $data, true));
            }
            $this->session->set_flashdata("success", $this->load->view('general/action_status', $data, true));
            redirect("/expenses/view", "refresh");
        }
    }

    public function delete($id) {
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        if ($this->expense_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
            $data["expense"] = $this->expense_model->delete($id);
            $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
            $data["status"] = "Deleted Expense";
            $data["action_classes"] = "success";
            $data["action_description"] = "Deleted an expense";
            $data["message_classes"] = "success";
            $data["message"] = "The expense was successfully deleted";
            $data["reUrl"] = "/expenses";
            $this->load->view('header', $data);
            $this->load->view('expenses/expense_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('expenses/view', $data);
            $this->load->view('footer');
        } else {
            $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
            $data["status"] = "Delete Expense";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete an expense";
            $data["message_classes"] = "failure";
            $data["message"] = "The expense you are attempting to delete does not exist or does not belong to you.";
            $data["reUrl"] = "/expenses";
            $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
            $this->load->view('header', $data);
            $this->load->view('expenses/expense_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('expenses/view', $data);
            $this->load->view('footer');
        }
    }

    public function edit($id) {
        $this->load->library('session');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        if ($this->expense_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
            $data["expense"] = $this->expense_model->getExpense($id);
            $this->load->view('header', $data);
            $this->load->view('expenses/expense_nav');
            $this->load->view('expenses/edit', $data);
            $this->load->view('footer');
        } else {
            $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
            $data["status"] = "Edit Expense";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit an expense";
            $data["message_classes"] = "failure";
            $data["message"] = "The expense you are attempting to edit does not exist or does not belong to you.";
            $this->load->view('header', $data);
            $this->load->view('expenses/expense_nav');
            $this->load->view('user/user_status', $data);
            $this->load->view('expenses/view', $data);
            $this->load->view('footer');
        }
    }

    public function filteredSearch() {
        $this->load->helper('url');
        $this->load->helper('form');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["startAndEndDateforMonth"] = array($this->input->post("fromDate"), $this->input->post("toDate"));
        $data['expensesForPeriod'] = $this->expense_model->getexpensesByCriteria($this->session->userdata("user")->id);
//        $this->output->set_content_type('application/json')
//                ->set_output(json_encode($this->expense_model->getexpensesByCriteria($this->session->userdata("user")->id)));
//        return $this->output->get_output();
        echo $this->load->view('expenses/history_table', $data, true);
    }

    // will support csv, json ???
    public function filteredSearchExportTo($output = "csv") {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('data_export_helper');
        $contentType = "application/vnd.ms-excel";
        $data = $this->expense_model->getexpensesByCriteria($this->session->userdata("user")->id);
        $expenseTypes = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $paymentMethods = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        switch ($output) {
            case "csv" :
                $data = csvify($data, $expenseTypes, $paymentMethods);
                $filename = "expenses.csv";
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

    public function forecast() {
        echo __CLASS__ . " > " . __FUNCTION__ . PHP_EOL;
        // echo "Hello {$to}!".PHP_EOL;
    }

    public function getExpenses($expenseIds) {
        $this->load->library("session");
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["expenses"] = $this->expense_model->getExpensesByIds($this->session->userdata("user")->id, array_filter(explode("-", $expenseIds)));

        $this->load->view("header_no_banner");
        $this->load->view("expenses/expense_table", $data);
        $this->load->view("footer");
    }

    public function getRemainingBudget($userId, $expenseTypeId, $date) {
        $data["period"] = $this->getExpensePeriodByDate($userId, $date);

        if (!empty($data["period"])) {
            $this->load->model('expense_type_model');
            $data["expenseType"] = $this->expense_type_model->get_expense_type($expenseTypeId);
            // Get budget using the periodId
            $this->load->model('expense_budget_model');
            $data["budget"] = $this->expense_budget_model->getExpenseBudgetByPeriodId($data["period"]->id);
            //get budget item given budgetId and categoryId
            $this->load->model('expense_budget_item_model');
            $data["budgetItem"] = $this->expense_budget_item_model->getByBudgetIdAndCategoryId($userId, $data["budget"]->id, $expenseTypeId);
            //get expenses for this type between this perid start and end date
            $data["expensesByType"] = $this->expense_model->getbyDateRangeExpenseType($userId, $data["period"]->start_date, $data["period"]->end_date, $expenseTypeId);
            $this->load->helper("expense_statistics_helper");
            $data["totalExpense"] = getExpensesTotal($data["expensesByType"]);
            $remaing = $data["budgetItem"]->limit_amount - $data["totalExpense"];
            return "<br/>Remaining in " . $data["expenseType"]->description . " budget: " . number_format($remaing, 2, '.', ',');
        }
    }

    public function getExpensePeriodByDate($userId, $date) {
        return $this->expense_period_model->getPeriodDateBetween($userId, $date);
    }

    public function history() {
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->helper("usability_helper");
        $this->load->library('session');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["expensePeriods"] = $this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id, 5, null);
        //$data["startAndEndDateOfWeek"] = getStartAndEndDateforWeek(date('W'), date('Y'));
        $data["startAndEndDateforMonth"] = getStartAndEndDateforMonth(date("m"), date('Y'));
        $data["expensesForPeriod"] = $this->expense_model->getExpensesbyDateRange($data["startAndEndDateforMonth"][0], $data["startAndEndDateforMonth"][1], $this->session->userdata("user")->id);
        $data["history_table"] = $this->load->view('expenses/history_table', $data, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/history', $data);
        $this->load->view('footer');
    }

    public function import() {
        $this->load->helper("usability_helper");
        $data[] = array();
        $data["error"] = '';
        $this->load->view('header', getPageTitle($data, $this->toolName, "Expense Import"));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/import/upload');
        $this->load->view('footer');
    }

    public function importUpload() {
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->helper("usability_helper");
        $this->load->library('session');
        $this->load->model('user_content_model');
        $userId = $this->session->userdata("user")->id;
        $data["user_content"] = 
            $this->user_content_model->uploadContent(
                    $userId, 
                    'csv|txt',
                    $this->toolId,
                    100000000, 
                    $private=0, 
                    $passwordProtect=0);
        if(key_exists("error",$data["user_content"])){
            $this->load->view('expenses/import/upload', $data["user_content"]["error"]);
        }else{
            $row = 1;
            $keys["date_column"] = 0;
            $keys["description_column"] = 0;
            $keys["amount_column"] = 0;
            $expenses = array();
            if (($handle = fopen($data["user_content"]["full_path"], "r")) !== FALSE) {
                while (($rowData = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($row == 1) {
                        foreach ($rowData as $k => $v) {
                            if (strtolower($v) == 'date') {
                                $keys["date_column"] = $k;
                            }
                            if (strtolower($v) == 'value' || strtolower($v) == 'cost' || strtolower($v) == 'amount') {
                                $keys["amount_column"] = $k;
                            }
                            if (strtolower($v) == 'description' || strtolower($v) == 'desc') {
                                $keys["description_column"] = $k;
                            }
                        }
                    } else {
                        $num = count($rowData);
//                    echo "<p> $num fields in line $row: <br /></p>\n";
//                    for ($c=0; $c < $num; $c++) {
////                        echo $rowData[$c] . "<br />\n";
//                    }
                        $expense["date"] = $rowData[$keys["date_column"]];
                        $expense["description"] = $rowData[$keys["description_column"]];
                        $expense["amount"] = $rowData[$keys["amount_column"]];
                        $expenses[] = $expense;
                    }
                    $row++;
                }
                fclose($handle);
            }
            $data["expenses"] = $expenses;
//            echo "<pre>";
//            print_r($expenses);
//            echo "</pre>";
            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
            $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
            $data["expenseTypeSelect"] = $this->load->view('expense_types/expense_type_dropdown', $data, true);
            $data["paymentMethodSelect"] = $this->load->view('payment_methods/payment_method_dropdown', $data, true);
            $this->load->view('header', getPageTitle($data, $this->toolName, "Import Uploaded Expenses"));
            $this->load->view('expenses/expense_nav');
            $this->load->view('expenses/import/upload_success', $data);
            $this->load->view('footer');
        }
    }
    
    public function importCapture(){
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $userId = $this->session->userdata("user")->id;
        $createDates = $this->input->post("createDate");
        $expenseTypes = $this->input->post("expenseType");
        $paymentMethods = $this->input->post("paymentMethod");
        $descriptions = $this->input->post("description");
        $locations = $this->input->post("location");
        $amounts = $this->input->post("amount");
//        echo "<pre>";
//        print_r(array($createDates, $expenseTypes, $paymentMethods, $descriptions, $locations, $amounts));
//        echo "</pre>";
        
        foreach($createDates as $k=>$v){
            $expense["amount"] = abs($amounts[$k]);
            $expense["expense_type_id"] = $expenseTypes[$k];
            $expense["description"] = $descriptions[$k];
            $expense["location"] = $locations[$k];
            $expense["location_id"] = 0;
            $expense["expense_date"] = $createDates[$k];
            $expense["user_id"] = $userId;
            $expense["payment_method_id"] = $paymentMethods[$k];
            $expense["status"] = "";
            $expense["statusMessage"] = "";
            $expenses[] = $expense;
        }
        $expenses = $this->expense_model->capture_expenses($expenses);
<<<<<<< HEAD
    //    echo "<pre>";
    //    print_r($expenses);
    //    echo "</pre>";
        $expenseIds = multiArrGetKeyValFromObjById($expenses, 'id');
        // echo "<pre>";
        // print_r($expenseIds);
        // echo "</pre>";
        // exit;
        $this->session->set_flashdata('expenses', $expenseIds, 30);
=======
//        echo "<pre>";
//        print_r($expenses);
//        echo "</pre>";
        $this->session->set_flashdata('expenses', $expenses);
>>>>>>> e3eb8b8e6b4ad524c41d145b1f427ae0ec29de67
        redirect("/expenses/import/captured", "refresh");
        
    }
    
    public function importCaptured(){
        $this->load->library('session');
<<<<<<< HEAD
        $userId = $this->session->userdata("user")->id;
        $data["expenseIds"] = $this->session->flashdata('expenses');
        // echo "<pre>";
        // print_r($data["expenseIds"]);
        // echo "</pre>";
        $data["expenses"] = $this->expense_model->getExpensesByIds($userId  , $data["expenseIds"]);
=======
        $data["expenses"] = $this->session->flashdata('expenses');
>>>>>>> e3eb8b8e6b4ad524c41d145b1f427ae0ec29de67
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($userId), false);
          
        $this->load->view('header', getPageTitle($data, $this->toolName, "Bulk Captured Expenses"));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/import/captured', $data);
        $this->load->view('footer');
    }

    public function options() {
        $this->load->helper("usability_helper");
        $data[] = array();
        $this->load->view('header', getPageTitle($data, $this->toolName, "Options"));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/options');
        $this->load->view('footer');
    }

    public function statistics() {
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        $this->load->helper("usability_helper");
        //get the data ready
        if ( null == $this->input->post()) {
            $data["startAndEndDateforMonth"] = getStartAndEndDateforMonth(date("m") - 1, date('Y'));
        } else {
            $data["startAndEndDateforMonth"] = array($this->input->post("fromDate"), $this->input->post("toDate"));
        }
//        print_r($data["startAndEndDateforMonth"]);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), true);
        $data["expensePeriods"] = $this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id, 5, null);
        $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                $data["startAndEndDateforMonth"][0], $data["startAndEndDateforMonth"][1], $this->session->userdata("user")->id, null, null, "amount", "desc"
        );
        $expensesOverPeriod = $this->expense_model->getExpensesbyDateRange(
                $data["startAndEndDateforMonth"][0], $data["startAndEndDateforMonth"][1], $this->session->userdata("user")->id, null, null, "expense_date", "asc"
        );
        $data["allExpenses"] = $expensesOverPeriod;
        $data["expensesTotal"] = getExpensesTotal($expensesForPeriod);
        $data["averageExpense"] = getAveragePerExpense($data["expensesTotal"], $expensesForPeriod);
        $data["topFiveExpenses"] = array_slice($expensesForPeriod, 0, 5);
        $data["topFiveExpenseTypes"] = array_slice(getArrayOfTypeAmount($expensesForPeriod), 0, 5, true);
        $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
        $data["topFivePaymentMethods"] = array_slice(getArrayOfPaymentMethodAmount($expensesForPeriod), 0, 5, true);
        $data["paymentMethodsTotal"] = getArrayOfPaymentMethodAmount($expensesForPeriod);
        $data["topFiveLocations"] = array_slice(getArrayOfLocationAmount($expensesForPeriod), 0, 5, true);
        $data["expensesOverPeriod"] = json_encode(getExpensesOverPeriodJson($expensesOverPeriod));
        $data["expensesByDayOfWeek"] = getDayOfWeekForExpense($expensesForPeriod);
        $data["expensesByHourOfDay"] = getExpensesForHourOfDay($expensesForPeriod);
        $data["daysOfWeek"] = getDaysOfWeek();

        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["eventsBudget"] = $this->load->view('expense_budget_item/manage', $data, true);
        $data["eventsBudgetItems"] = $this->load->view('expense_budget_item/budget_items_assigned', $data, true);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        $this->load->view('header', getPageTitle($data, $this->toolName, "Stats"));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/statistics', $data);
        $this->load->view('footer');
    }

    public function view() {
        $this->load->library('session');
        $this->load->model("user_content_model");
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
        $data["css"] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';
        $data["js"] = '';
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/view', $data);
        $this->load->view('footer');
    }

    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('amount', 'amount', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post("id"));
        } else {
            $data["status"] = "Edit Expense";
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Expense";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the expense";
            $this->expense_model->update($this->input->post('id'));
            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
            $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
            $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
            $this->load->view('header', $data);
            $this->load->view('expenses/expense_nav');
            $this->load->view('user/user_status', $data);
            $this->load->view('expenses/view', $data);
            $this->load->view('footer');
        }
    }

}
