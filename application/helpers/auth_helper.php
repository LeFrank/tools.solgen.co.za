<?php

if (!function_exists('can_access')) {
    function can_access($shouldCheck, $session) {
        $instance = & get_instance();
        $instance->load->helper('url');
        $instance->load->library('session');
        if ($shouldCheck) {
            if (empty($session->userdata["loggedIn"])) {
                $session->set_userdata("targetUrl", str_replace("index.php/", "", current_url()));
                redirect('/', 'refresh');
            }else if(!$session->userdata["loggedIn"]){
                $session->set_userdata("targetUrl", str_replace("index.php/", "", current_url()));
                redirect('/', 'refresh');
            }
        }
    }
}

