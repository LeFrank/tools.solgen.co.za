<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wishlist extends CI_Controller {

    var $toolName = "Wishlist";
    var $require_auth = TRUE;
    var $priorities = array(
        0 => "None" , 
        1 => "Low",
        2 => "Low/Medium",
        3 => "Medium", 
        4 => "Medium/High", 
        5 => "High", 
        6 => "High/Summit", 
        7 => "Summit");
    var $statuses = array(
        0 => "None",
        1 => "Some Day",
        2 => "Awaiting Action",
        3 => "In Progress",
        4 => "Stopped, needs rethink",
        5 => "Completed/Acquired/Done"
    );
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        can_access($this->require_auth, $this->session);
        $this->load->model('wishlist_model');
    }

    public function index($id=null) {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data[] = array();
        $data["statuses"] = $this->statuses;
        $data["priorities"] = $this->priorities;
        $userId = $this->session->userdata("user")->id;

        $data["wishlistItems"] = $this->wishlist_model->getItems($userId, 5, null);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('wishlist/wishlist_nav');
        $this->load->view('wishlist/index', $data);
        $this->load->view('footer');

    }
    
    public function create(){
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $userId = $this->session->userdata("user")->id;
        $data['title'] = 'Create an Wishlist Item';

        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('cost', 'cost', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('reason', 'reason', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data["wishlistItem"] = $this->wishlist_model->capture_item();
            $item = $this->wishlist_model->getItem($userId, $data["wishlistItem"]);
            $data["status"] = "Wishlist Item Captured";
            $data["action_classes"] = "success";
            $data["message_classes"] = "success";
            $data["action_description"] = "Captured A Wishlist Item.";
            $data["message"] = "The item was captured: ". $item->Name;
            $this->session->set_flashdata("success", $this->load->view('general/action_status', $data,true));
            redirect("/expense-wishlist/" , "refresh");
        }
    }
    
    public function edit($id=null){
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data[] = array();
        $data["statuses"] = $this->statuses;
        $data["priorities"] = $this->priorities;
        $userId = $this->session->userdata("user")->id;
        $data["wishlistItem"] = $this->wishlist_model->getItem($userId, $id);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('wishlist/wishlist_nav');
        $this->load->view('wishlist/edit', $data);
        $this->load->view('footer');
    }
    
    public function history() {
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->helper("usability_helper");
        $this->load->library('session');
        $data["statuses"] = $this->statuses;
        $data["priorities"] = $this->priorities;
        $data["startAndEndDateforYear"] = getStartAndEndDateforYear(date('Y'));
        $data["expensesForPeriod"] = $this->wishlist_model->getItemsbyDateRange($data["startAndEndDateforYear"][0], $data["startAndEndDateforYear"][1], $this->session->userdata("user")->id);
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('wishlist/wishlist_nav');
        $this->load->view('wishlist/history', $data);
        $this->load->view('footer');
    }
    
    public function update($id){
        echo __CLASS__ .  "  >  " . __FUNCTION__ . " > ". __LINE__; 
    }
    
    public function delete($id){
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["statuses"] = $this->statuses;
        $data["priorities"] = $this->priorities;
        $userId = $this->session->userdata("user")->id;
        if ($this->wishlist_model->doesItBelongToMe($userId, $id)) {
            $data["wishlistItem"] = $this->wishlist_model->delete($id);
            $data["status"] = "Deleted Wishlist Item";
            $data["action_classes"] = "success";
            $data["action_description"] = "Deleted a Wishlist Item";
            $data["message_classes"] = "success";
            $data["message"] = "The wishlist item was successfully deleted";
            $data["wishlistItems"] = $this->wishlist_model->getItems($userId, 5, null);
            $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
            $this->load->view('wishlist/wishlist_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('wishlist/index', $data);
            $this->load->view('footer');
        } else {
            $data["wishlistItems"] = $this->wishlist_model->getItems($userId, 5, null);
            $data["status"] = "Delete Wishlist Item";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete a Wishlist Item";
            $data["message_classes"] = "failure";
            $data["message"] = "The wishlist item you are attempting to delete does not exist or does not belong to you.";
            $this->load->view('header', $data);
            $this->load->view('wishlist/wishlist_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('wishlist/index', $data);
            $this->load->view('footer');
        } 
    }
    
    public function filteredSearch() {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($this->expense_model->getexpensesByCriteria($this->session->userdata("user")->id)));
        return $this->output->get_output();
    }

}
