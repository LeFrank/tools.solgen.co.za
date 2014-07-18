<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eventCategory
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class eventCategory extends CI_Controller {

    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model("timetable_category_model");
    }

    public function capture() {
        $this->load->library("input");
        if (!$this->session->flashdata('update_token')) {
            $data["status"] = "Create An Event Category";
            if ($this->timetable_category_model->capture()) {
                $data["action_classes"] = "success";
                $data["action_description"] = "Create an event category";
                $data["message_classes"] = "success";
                $data["message"] = "The event category was successfully created";
            } else {
                $data["action_classes"] = "failure";
                $data["action_description"] = "Create an Event Category";
                $data["message_classes"] = "failure";
                $data["message"] = "The event category was not saved, please try again";
            }
            $this->session->set_flashdata('update_token', time());
            redirect('/timetable/event-categories', 'refresh');
        } else {
            redirect('/timetable/event-categories', 'refresh');
        }
    }
    
    public function edit($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Edit Event Category";
        //check if this expense type belongs to you?
        if ($this->timetable_category_model->doesItBelongToMe($mySession, $id)) {
            $data['eventCategory'] = $this->timetable_category_model->get_timetable_category($id);
            //show new page
            $this->load->view("header");
            $this->load->view("event_category/edit", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit Event Category";
            $data["message_classes"] = "failure";
            $data["message"] = "The event category does not exist or it does not belong to you.";

            $data["eventCategories"] = mapKeyToId($this->timetable_category_model->get_only_user_timetable_category($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("general/action_status", $data);
            $this->load->view("event_category/edit", $data);
            $this->load->view("footer");
        }
    }
}
