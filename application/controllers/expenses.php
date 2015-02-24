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
        $this->load->helper("array_helper");
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

    public function capture() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $data['title'] = 'Create an expense';

        $this->form_validation->set_rules('amount', 'amount', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->view();
        } else {
            $data["expense"] = $this->expense_model->capture_expense();
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
            $this->load->view('header');
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
            $this->load->view('header');
            $this->load->view('expenses/expense_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('expenses/view', $data);
            $this->load->view('footer');
        }
    }

    public function edit($id) {
        $this->load->library('session');
        //is it mine?
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        if ($this->expense_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
            $data["expense"] = $this->expense_model->getExpense($id);
            $this->load->view('header');
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
            $this->load->view('header');
            $this->load->view('expenses/expense_nav');
            $this->load->view('user/user_status', $data);
            $this->load->view('expenses/view', $data);
            $this->load->view('footer');
        }
    }

    public function filteredSearch() {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($this->expense_model->getexpensesByCriteria($this->session->userdata("user")->id)));
        return $this->output->get_output();
    }


    // will support csv, json ???
    public function filteredSearchExportTo($output="csv") {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('data_export_helper');
        $contentType = "application/vnd.ms-excel";
        $data = $this->expense_model->getexpensesByCriteria($this->session->userdata("user")->id);
        $expenseTypes = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $paymentMethods = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        switch($output){
            case "csv" :
                $data = csvify($data, $expenseTypes, $paymentMethods);
                $filename = "expenses.csv";
                $temp = tmpfile();
                foreach ($data as $k=>$line){
                    fputcsv($temp,$line);
                }
                $meta_data = stream_get_meta_data($temp);
                header('Content-Length: '.filesize($meta_data["uri"])); //<-- sends filesize header
                header('Content-Type: '.$contentType); //<-- send mime-type header
                header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
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

    public function forecast(){
        echo __CLASS__. " > ".__FUNCTION__;
    }
    
    public function getExpenses($expenseIds){
        $this->load->library("session");
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["expenses"] = $this->expense_model->getExpensesByIds($this->session->userdata("user")->id , array_filter(explode("-",$expenseIds)));
        
        $this->load->view("header_no_banner");
        $this->load->view("expenses/expense_table", $data);
        $this->load->view("footer");
    }
    
    public function history() {
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->library('session');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        //$data["startAndEndDateOfWeek"] = getStartAndEndDateforWeek(date('W'), date('Y'));
        $data["startAndEndDateforMonth"] = getStartAndEndDateforMonth(date("m"), date('Y'));
        $data["expensesForPeriod"] = $this->expense_model->getExpensesbyDateRange($data["startAndEndDateforMonth"][0], $data["startAndEndDateforMonth"][1], $this->session->userdata("user")->id);
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/history', $data);
        $this->load->view('footer');
    }

    public function options() {
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/options');
        $this->load->view('footer');
    }

    public function statistics() {
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        //get the data ready
        if(sizeOf($this->input->post()) == 1){
            $data["startAndEndDateforMonth"] = getStartAndEndDateforMonth(date("m")-1, date('Y'));
        }else{
            $data["startAndEndDateforMonth"] = array($this->input->post("fromDate"), $this->input->post("toDate"));
        }
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), true);
        
        $expensesForPeriod = $this->expense_model->getExpensesbyDateRange(
                $data["startAndEndDateforMonth"][0], 
                $data["startAndEndDateforMonth"][1], 
                $this->session->userdata("user")->id,
                null,
                null,
                "amount",
                "desc"
        );
        $expensesOverPeriod = $this->expense_model->getExpensesbyDateRange(
                $data["startAndEndDateforMonth"][0], 
                $data["startAndEndDateforMonth"][1], 
                $this->session->userdata("user")->id,
                null,
                null,
                "expense_date",
                "asc"
        );
        $data["allExpenses"] = $expensesOverPeriod;
        $data["expensesTotal"] = getExpensesTotal($expensesForPeriod);
        $data["averageExpense"] = getAveragePerExpense($data["expensesTotal"], $expensesForPeriod);
        $data["topFiveExpenses"] = array_slice($expensesForPeriod, 0, 5);
        $data["topFiveExpenseTypes"] = array_slice(getArrayOfTypeAmount($expensesForPeriod),0,5,true);
        $data["expenseTypesTotals"] = getArrayOfTypeAmount($expensesForPeriod);
        $data["topFivePaymentMethods"] = array_slice(getArrayOfPaymentMethodAmount($expensesForPeriod),0,5,true);
        $data["paymentMethodsTotal"] = getArrayOfPaymentMethodAmount($expensesForPeriod);
        $data["topFiveLocations"] = array_slice(getArrayOfLocationAmount($expensesForPeriod),0,5,true);
        $data["expensesOverPeriod"] = json_encode(getExpensesOverPeriodJson($expensesOverPeriod));
        $data["expensesByDayOfWeek"] = getDayOfWeekForExpense($expensesForPeriod);
        $data["expensesByHourOfDay"] = getExpensesForHourOfDay($expensesForPeriod);
        $data["daysOfWeek"] = getDaysOfWeek();
        
        $this->load->view('header');
        $this->load->view('expenses/expense_nav');
        $this->load->view('expenses/statistics', $data);
        $this->load->view('footer');
    }

    public function view() {
        $this->load->library('session');
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($this->session->userdata("user")->id));
        $data["expensePaymentMethod"] = mapKeyToId($this->payment_method_model->get_user_payment_method($this->session->userdata("user")->id), false);
        $data["expense"] = $this->expense_model->getExpenses($this->session->userdata("user")->id, 5);
        $this->load->view('header');
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
            $this->load->view('header');
            $this->load->view('expenses/expense_nav');
            $this->load->view('user/user_status', $data);
            $this->load->view('expenses/view', $data);
            $this->load->view('footer');
        }
    }

}
