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

    public function login() {
        if ($this->input->post('email') != "" && $this->input->post('password') != "") {
            $user = $this->user_model->login($this->input->post('email'), $this->input->post('password'));
            if (!empty($user)) {
                unset($user->password);
                $this->session->set_userdata("loggedIn", TRUE);
                $this->session->set_userdata("isAdmin", ($user->user_type == "admin") ? TRUE : FALSE);
                $this->session->set_userdata("user", $user);
                redirect('/home/dashboard', 'refresh');
            } else {
                $this->session->set_userdata("loggedIn", FALSE);
                redirect('/user/login', 'refresh');
            }
        } else {
            $this->session->set_userdata("loggedIn", FALSE);
            redirect('/');
        }
    }

    public function logout() {
        $this->session->set_userdata("loggedIn", FALSE);
        $this->session->unset_userdata("isAdmin");
        $this->session->unset_userdata("user");
        redirect('/', 'refresh');
    }

    public function delete() {
        //delete all data
        //TODO: figure out how to best do this! some sort of daemon, or just kick off another process.
        //      I do not want the user controller to be to tightly bound.
        $this->session->set_userdata("loggedIn", FALSE);
        $this->session->unset_userdata("isAdmin");
        $this->session->unset_userdata("user");
        $this->session->sess_destroy();
        redirect('/', 'refresh');
    }

    public function forgottenPassword() {
        $this->load->helper("form");
        $this->load->library("form_validation");
        //1 Show form asking for email address
        $this->load->view("header");
        $this->load->view("user/forgottenPassword");
        $this->load->view("footer");
        //2 Verify email address. AAARRRggg, that means email needs to be unique
        //3 Send a link to said email address. Link willhave a UID somewhere in it. 
        //      Which will be tied to a timed window for a password reset say an hour.
        //4 user clicks link and is shown a screen requesting a new password.
        //5 redirect to home page so they can log in.
    }

    public function sendResetEmail() {
        $this->load->helper("form");
        $this->load->library("form_validation");
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_message('email', '<span class="failure">Invalid Email Address</span>');
            $this->forgottenPassword();
        } else {
            // create temporary reset token , where though ????
            echo "here";
            $this->load->library('email');

            $this->email->from('system@solgen.co.za', 'System');
            $this->email->to('campbellfd@gmail.com');
            //$this->email->cc('another@another-example.com');
            //$this->email->bcc('them@their-example.com');

            $this->email->subject('Email Test');
            $this->email->message('Testing the email class.');

            $this->email->send();

            echo $this->email->print_debugger();
            // Create table
            // send email with link to a page which A: accepts the token as a get variable and B shows a form to change the password.
        }
    }

    public function settings() {
        $this->load->helper('auth_helper');
        can_access(TRUE, $this->session);
        $this->load->view('header');
        $this->load->view('user/settings');
        $this->load->view('footer');
    }

}
