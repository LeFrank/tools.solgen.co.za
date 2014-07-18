<?php

class Timetable extends CI_Controller {

    var $toolId = 3;
    var $toolName = "Timetable";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->helper('auth_helper');
        $this->load->helper('json_helper');
        $this->load->helper('array_helper');
        $this->load->model("timetable_model");
        $this->load->model("timetable_category_model");
        $this->load->model("expense_type_model");
        $this->load->model("location_model");
        can_access($this->require_auth, $this->session);
    }

    public function capture() {
        $this->load->library("input");
        if (!$this->session->flashdata('update_token') || $this->input->post("id") == "") {
            $data["status"] = "Create An Event";
            if ($this->timetable_model->create_timetable()) {
                $data["action_classes"] = "success";
                $data["message_classes"] = "success";
                if($this->input->post("id")!= ""){
                    $data["action_description"] = "Updated an event";
                    $data["message"] = "The Timetable event was successfully updated";
                }else{
                    $data["action_description"] = "Create an event";
                    $data["message"] = "The Timetable event was successfully created";
                }
                
            } else {
                $data["action_classes"] = "failure";
                $data["action_description"] = "Create an Event";
                $data["message_classes"] = "failure";
                $data["message"] = "The event was not saved, please try again";
            }
            $this->session->set_flashdata('update_token', time());
            $this->index($data);
        } else {
            redirect('/timetable/index', 'refresh');
        }
    }

    public function delete($id) {
        $this->load->library("input");
        if (!$this->session->flashdata('delete_token')) {
            $data["action_description"] = "Delete Timetable Event";
            if (null != $id) {
                if ($this->timetable_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
                    $this->timetable_model->delete($id);
                    $data["status"] = "Timetable Event Deleted Successfully";
                    $data["action_classes"] = "success";
                    $data["message_classes"] = "success";
                    $data["message"] = "The event has been deleted.";
                } else {
                    $data["status"] = "Location Error Deleting the Timetable event";
                    $data["action_classes"] = "failure";
                    $data["message_classes"] = "failure";
                    $data["message"] = "This timetable event does not belong to you. "
                            . "<br/>Please refrain from attempting to perform harmful actions to others data!";
                }
            } else {
                $data["status"] = "Error Deleteing Timetable Event";
                $data["action_classes"] = "failure";
                $data["message_classes"] = "failure";
                $data["message"] = "No timetable event was provided, please provide a valid timetable event ID.";
            }
            $this->session->set_flashdata('delete_token', time());
            $this->index($data);
        } else {
            redirect('/timetable/index', 'refresh');
        }
    }

    public function eventCategories() {
        $user = $this->session->userdata("user");
        $data["eventCategories"] = $this->timetable_category_model->get_only_user_timetable_category($user->id);
        $this->load->view("header");
        $this->load->view("timetable/event_categories", $data);
        $this->load->view("footer");
    }

    public function index($data = null) {
        $data["css"] = "<link href='/css/third_party/fullcalendar/fullcalendar.css' rel='stylesheet' />
                            <link href='/css/third_party/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />";
        $user = $this->session->userdata("user");
        $data["events"] = eventifyArray($this->timetable_model->get_user_timetable_events($user->id));
        $data["timetableCategories"] = $this->timetable_category_model->get_user_timetable_Category($user->id);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($user->id), true);
        $data["locations"] = $this->location_model->getLocations($user->id);
        $this->load->view("header", $data);
        $this->load->view("timetable/timetable_nav");
        if (!empty($data["status"])) {
            $this->load->view("general/action_status", $data);
        }
        $this->load->view("timetable/index", $data);
        $this->load->view("footer");
    }

    public function options() {
        $this->load->view("header");
        $this->load->view("timetable/options");
        $this->load->view("footer");
    }

    public function view($id) {
        $user = $this->session->userdata("user");
        $data["event"] = $this->timetable_model->get_user_timetable_event($user->id, $id);
        echo json_encode($data["event"]);
    }

}
