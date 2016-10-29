<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wishlist extends CI_Controller {

    var $toolName = "Wishlist";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        can_access($this->require_auth, $this->session);
        $this->load->model('wishlist_model');
    }

    public function index() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data[] = array();
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('wishlist/wishlist_nav');
        $this->load->view('wishlist/index', $data);
        $this->load->view('footer');

    }
    
    public function create(){
        echo __CLASS__ .  "  >  " . __FUNCTION__ . " > ". __LINE__; 
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $data['title'] = 'Create an Wishlist Item';

        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('cost', 'cost', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('reason', 'reason', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data["wishlistItem"] = $this->wishlist_model->capture_item();
            $data["remaining_budget"] = $this->getRemainingBudget(
                $this->session->userdata("user")->id, 
                $this->input->post('expenseType'), 
                ($this->input->post('expenseDate') != "") ? date('Y-m-d H:i', strtotime($this->input->post('expenseDate'))): date('Y-m-d H:i'));
            $data["status"] = "Expense Captured";
            $data["action_classes"] = "success";
            $data["message_classes"] = "success";
            $data["action_description"] = "Capture an expense";
            $data["message"] = "The expense was captured. ".$data["remaining_budget"];
            $this->session->set_flashdata("success", $this->load->view('general/action_status', $data,true));
            redirect("/expenses/view", "refresh");
        }
    }
    
    public function update($id){
        echo __CLASS__ .  "  >  " . __FUNCTION__ . " > ". __LINE__; 
    }
    
    public function delete($id){
        echo __CLASS__ .  "  >  " . __FUNCTION__ . " > ". __LINE__; 
    }

}
