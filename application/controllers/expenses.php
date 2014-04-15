<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Expenses extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        //$this->load->model('expense_model');
        $this->load->model('expense_type_model');
        //$this->load->model('user_expense_type_model');
    }
    
    public function view(){
        echo "view<br/>";
        $expenseTypes = $this->expense_type_model->get_expense_types();
        foreach($expenseTypes as $k=>$v){
            echo $k . " => " . $v["description"] ."<br/>";
        }
        exit;
    }
    
    public function capture(){
        echo "capture";
        exit;
    }
    
    public function delete(){
        echo _FUNCTION_;
        exit;
    }
    
    public function history(){
        echo _FUNCTION_;
        exit;
    }
}
