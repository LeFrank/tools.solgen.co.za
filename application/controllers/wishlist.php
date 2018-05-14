<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wishlist extends CI_Controller {

    var $toolName = "Wishlist";
    var $toolId = 7;
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('wishlist');
        can_access($this->require_auth, $this->session);
        $this->load->model('wishlist_model');
        $this->load->model('expense_period_model');
        $this->load->model('expense_type_model');
    }

    public function index($id = null) {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');
        $data[] = array();
        $data["priorities"] = getWishlistPriorities();
        $data["statuses"] = getWishlistStatuses();
        $userId = $this->session->userdata("user")->id;
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($userId));
        $data["wishlistItems"] = $this->wishlist_model->getItems($userId, 5, null);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('wishlist/wishlist_nav');
        $this->load->view('wishlist/index', $data);
        $this->load->view('footer');
    }

    public function create() {
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
            $data["message"] = "The item was captured: " . $item->name;
            $this->session->set_flashdata("success", $this->load->view('general/action_status', $data, true));
            redirect("/wishlist/", "refresh");
        }
    }

    public function edit($id = null) {
//        $this->load->library('user_agent');
//        if ($this->agent->is_referral())
//        {
//            echo "<br/>".$this->agent->referrer();
//        }
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data[] = array();
        $data["priorities"] = getWishlistPriorities();
        $data["statuses"] = getWishlistStatuses();
        $userId = $this->session->userdata("user")->id;
        $this->load->helper("array_helper");
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($userId));
        $data["wishlistItem"] = $this->wishlist_model->getItem($userId, $id);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('wishlist/wishlist_nav');
        $this->load->view('wishlist/edit', $data);
        $this->load->view('footer');
    }

    public function filteredSearch() {
        $this->load->helper('url');
        $this->load->helper('form');
        $data["priorities"] = getWishlistPriorities();
        $data["statuses"] = getWishlistStatuses();
        $data["wishlistItemsForPeriod"] = $this->wishlist_model->getItemsByCriteria($this->session->userdata("user")->id);
        //print_r($data["wishlistItemsForPeriod"] );
        $userId = $this->session->userdata("user")->id;
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($userId));
        $data["includeActions"] = True;
        if ($this->input->post("actions") == null || !$this->input->post("actions")) {
            $data["includeActions"] = $this->input->post("actions");
        }
        $data["itemsTable"] = $this->load->view('wishlist/itemTable', $data, true);
        echo $data["itemsTable"];
    }

    /**
     * Get all Wishlist items for a specific date range.
     * Posted date values are given
     * String startDate of a date
     * String endDate of a date
     */
    public function getItemsByDateRange() {
        
    }

    public function history() {
        $this->load->helper("array_helper");
        $this->load->helper("date_helper");
        $this->load->helper("usability_helper");
        $this->load->library('session');
        $userId = $this->session->userdata("user")->id;
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($userId));
        $data["priorities"] = getWishlistPriorities();
        $data["statuses"] = getWishlistStatuses();
        $data["startAndEndDateforYear"] = getStartAndEndDateforYear(date('Y'));
        $data["wishlistItemsForPeriod"] = $this->wishlist_model->getItemsbyDateRange($data["startAndEndDateforYear"][0], $data["startAndEndDateforYear"][1], $this->session->userdata("user")->id);
        $data["expensePeriods"] = $this->expense_period_model->getExpensePeriods($this->session->userdata("user")->id, 5, null);
        $data["itemsTable"] = $this->load->view('wishlist/itemTable', $data, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('wishlist/wishlist_nav');
        $this->load->view('wishlist/history', $data);
        $this->load->view('footer');
    }

    public function delete($id) {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["priorities"] = getWishlistPriorities();
        $data["statuses"] = getWishlistStatuses();
        $userId = $this->session->userdata("user")->id;
        $this->load->helper("array_helper");
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($userId));
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

    public function update($id) {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('cost', 'cost', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('reason', 'reason', 'required');
        $this->load->helper("array_helper");
        $userId = $this->session->userdata("user")->id;
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($userId));
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post("id"));
        } else {
            $data["status"] = "Edit Wishlist Item";
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Item";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the wishlist item";
            $this->wishlist_model->update($id);
            $data["priorities"] = getWishlistPriorities();
            $data["statuses"] = getWishlistStatuses();
            $data["wishlistItems"] = $this->wishlist_model->getItems($userId, 5, null);
            $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
            $this->load->view('wishlist/wishlist_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('wishlist/index', $data);
            $this->load->view('footer');
        }
    }

}
