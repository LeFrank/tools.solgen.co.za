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
        $this->load->helper('tool_info_helper');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
    }

    public function index() {
        $data["error"] = '';
        $this->load->model("user_content_model");
        $data["statusArr"] = $this->session->flashdata('status');
        
        $userId = $this->session->userdata("user")->id;
        $data["resources"] = $this->user_content_model->getUserContentItems($userId);
        $data["tools"] = getAllToolsInfo();
        $this->load->view('header', getPageTitle($data, $this->toolName, "List", ""));
        $this->load->view('resources/resources_nav');
        if(!empty($data["statusArr"])){
            $data["status"] = "Delete Resource";
            $data["action_classes"] = strtolower($data["statusArr"]["status"]);
            $data["action_description"] = $data["statusArr"]["message"];
            $data["message_classes"] = strtolower($data["statusArr"]["status"]);
            $data["message"] = $data["statusArr"]["description"];
            $this->load->view('user/user_status', $data);
        }
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

    public function delete($id=null){
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model("user_content_model");
        $userId = $this->session->userdata("user")->id;
        if($id != null){
            $item = $this->user_content_model->getUserContentitem($userId, $id);
            if(file_exists($item->full_path)){
                if(unlink($item->full_path)){
                    $data["statusArr"] = $this->user_content_model->deleteItem($userId, $id);
                }else{
                    $data["statusArr"]["status"] = "Failure";
                    $data["statusArr"]["message"] = "Unable to delete the resource: error when trying to delete the file.";
                    $data["statusArr"]["description"] =  $item->original_name . " has not been deleted.";
                    $data["statusArr"]["affectedRows"] = 0;
                }
            }else{
                $data["statusArr"] = $this->user_content_model->deleteItem($userId, $id);
            }
        }
        $data["resources"] = $this->user_content_model->getUserContentItems($userId);
        $data["tools"] = getAllToolsInfo();
        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("/resources", "refresh");
    }
}
