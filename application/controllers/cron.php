<?php

class cron extends CI_Controller {

    var $require_auth = false;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
    }

    public function send_reminders(){
        
    }

}
