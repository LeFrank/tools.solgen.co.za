<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Expenses extends CI_Controller
{
    var $require_auth = true;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, 
                $this->session);
        //$this->load->model('expense_model');
        $this->load->model('expense_type_model');
        //$this->load->model('user_expense_type_model');
    }
    
    public function view(){
        $this->load->library('session');
        $expenseTypes = $this->expense_type_model->get_expense_types();
        $data["expenseTypes"] = $expenseTypes;
        $this->load->view('header');
        $this->load->view('expenses/view' ,$data);
        $this->load->view('footer');
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
