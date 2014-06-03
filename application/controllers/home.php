<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->helper('form');
    }
    
    function index(){
        $this->load->helper('cookie');
        if(null != $this->input->cookie("tools.remember")){
            //login
            print_r($this->input->cookie("tools.remember"));
        }
        $this->load->helper('email');
        $this->load->library('form_validation');
        $this->load->view('header');
        $this->load->view('home/home');
        $this->load->view('footer');
    }
    
    function dashboard(){
        $this->load->view('header');
        if($this->session->userdata("isAdmin")){
            $this->load->view('home/admin-dashboard');
        }else{
            $this->load->view('home/user-dashboard');
        }
        $this->load->view('footer');
    }
}