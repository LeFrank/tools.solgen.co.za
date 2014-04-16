<?php

if (!function_exists('can_access')) {
    function can_access($shouldCheck, $session) {
        $instance = & get_instance();
        $instance->load->helper('url');
        $instance->load->library('session');
        if ($shouldCheck) {
            if (empty($session->userdata["loggedIn"])) {
                redirect('/', 'refresh');
            }else if(!$session->userdata["loggedIn"]){
                redirect('/', 'refresh');
            }
        }
    }
}

