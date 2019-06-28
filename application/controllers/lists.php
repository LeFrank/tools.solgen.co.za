<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class lists extends CI_Controller {

    var $toolId = 10;
    var $toolName = "Lists";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
    }

    public function index() {
        $this->load->library('session');
        $data["css"] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';
        $data["js"] = '';
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('lists/lists_nav');
        $this->load->view('lists/index', $data);
        $this->load->view('footer');
    }
}
