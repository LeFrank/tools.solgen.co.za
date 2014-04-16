<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function register() {
        $this->load->helper('form');
        $this->load->helper('email');
        $this->load->library('form_validation');
        

        $data['title'] = 'Register';

        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('user/register');
            $this->load->view('footer');
        } else {
            $this->user_model->set_user();
            $this->load->view('user/registered');
        }
    }
    
    public function login(){
        $user = $this->user_model->login($this->input->post('email') , $this->input->post('password'));
        if(!empty($user)){
            unset($user->password);
            $this->session->set_userdata("loggedIn",TRUE);
            $this->session->set_userdata("isAdmin",($user->user_type == "admin") ?TRUE: FALSE);
            $this->session->set_userdata("user",$user);
            redirect('/home/dashboard', 'refresh');
        }else{
            $this->session->set_userdata("loggedIn",FALSE);
            redirect('/user/login', 'refresh');
        }
    }
    
    public function logout(){
        $this->session->set_userdata("loggedIn",FALSE);
        $this->session->unset_userdata("isAdmin");
        $this->session->unset_userdata("user");
        redirect('/', 'refresh');
    }
}