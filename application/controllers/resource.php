<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of resource
 *
 * @author francois
 */
class resource extends CI_Controller {

    var $toolId = 9;
    var $toolName = "Resources";
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
        $data["error"] = '';
        $this->load->view('header', getPageTitle($data, $this->toolName, "List", ""));
        $this->load->view('resources/resources_nav');
        $this->load->view('resources/view', $data);
        $this->load->view('footer');
    }

    public function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|txt';
        $config['max_size'] = 100000000;
//        $config['max_width'] = 1024;
//        $config['max_height'] = 768;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('resources/view', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('resources/upload_success', $data);
        }
    }

}
