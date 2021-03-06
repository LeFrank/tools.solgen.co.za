<?php

class Timetable extends CI_Controller {

    var $toolId = 4;
    var $toolName = "Timetable";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->helper('auth_helper');
        $this->load->helper('json_helper');
        $this->load->helper('array_helper');
        $this->load->helper('usability_helper');
        $this->load->model("timetable_model");
        $this->load->model("timetable_category_model");
        $this->load->model("timetable_repetition_model");
        $this->load->model("expense_type_model");
        $this->load->model("location_model");
        can_access($this->require_auth, $this->session);
    }

    public function capture() {
        $this->load->library("input");
        $user = $this->session->userdata("user");
        if (!$this->session->flashdata('update_token') || $this->input->post("id") == "") {
            $data["status"] = "Create An Event";
            $eventId = $this->timetable_model->create_timetable();
            if ($eventId) {
                $data["action_classes"] = "success";
                $data["message_classes"] = "success";
                $data["fcViewState"] = $this->input->post("fcViewState");
                if ($this->timetable_model->doesItBelongToMe($user->id, $eventId)) {
                    $event = $this->timetable_model->get_user_timetable_event($user->id, $eventId);
                    $data["currentEvent"] = eventify($event);
                    $data["message"] = "The Timetable event: <a href=\"#\" onClick=\"setEventEdit(". $event->id. ");\" >\"".$event->name ."\"</a> was successfully ";
                    if ($this->input->post("id") != "") {
                        $data["action_description"] = "Updated an event";
                        $data["message"] = $data["message"] . "updated";
                    } else {
                        $data["action_description"] = "Create an event";
                        $data["message"] = $data["message"] . "created";
                    }
                }
                $data["events"] = eventifyArray($this->timetable_model->get_user_timetable_events($user->id));
            } else {
                $data["action_classes"] = "failure";
                $data["action_description"] = "Create an Event";
                $data["message_classes"] = "failure";
                $data["message"] = "The event was not saved, please try again";
            }
            $data["reUrl"] = "/timetable";
            $this->session->set_flashdata('update_token', time());
            $this->index($data);
        } else {
            redirect('/timetable/index', 'refresh');
        }
    }
    
    public function edit($eventId){
        $user = $this->session->userdata("user");
        $data["event"] = $this->timetable_model->get_user_timetable_event($user->id, $eventId);
        $data["timetableCategories"] = $this->timetable_category_model->get_user_timetable_Category($user->id);
        $data["eventRepetition"] = $this->timetable_repetition_model->get_timetable_repeats($user->id);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($user->id), true);
        $data["locations"] = $this->location_model->getLocations($user->id);
        $this->load->view('header', getPageTitle($data, $this->toolName,"Edit",""));
        $this->load->view("timetable/timetable_nav");
        $this->load->view("timetable/edit");
        $this->load->view("footer");
    }

    public function getEvent($eventId) {
        $user = $this->session->userdata("user");
        if ($this->timetable_model->doesItBelongToMe($this->session->userdata("user")->id, $eventId)) {
            $data["event"] = $this->timetable_model->get_user_timetable_event($user->id, $eventId);
//            print_r($data["event"]);
            $data["timetableCategories"] = arrayMap($this->timetable_category_model->get_user_timetable_Category($user->id));
            $data["eventRepetition"] = arrayObjMap($this->timetable_repetition_model->get_timetable_repeats($user->id));
            $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($user->id), true);
            $data["locations"] = arrayObjMap($this->location_model->getLocations($user->id));
//            echo "<pre>";
//            print_r($data["locations"]);
//            echo "</pre>";
            $this->load->view("/timetable/event", $data);
        } else {
            $data["status"] = "Timetable Error retrieving the Timetable event";
            $data["action_classes"] = "failure";
            $data["message_classes"] = "failure";
            $data["message"] = "This timetable event does not belong to you. "
                    . "<br/>Please refrain from attempting to view other peoples data!";
            $this->load->view("general/action_status", $data);
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
                    $data["status"] = "Timetable Error Deleting the Timetable event";
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
            $data["reUrl"] = "/timetable";
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
        $this->load->helper("date_helper");
        $data["css"] = "<link href='/css/third_party/fullcalendar/fullcalendar.css' rel='stylesheet' />
                            <link href='/css/third_party/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />";
        $user = $this->session->userdata("user");
        $data["startAndEndDateforMonth"] = getStartAndEndDateforMonth(date("m"), date('Y'));
        $data["timetableCategories"] = mapKeyToId($this->timetable_category_model->get_user_timetable_Category($user->id));
        $data["events"] = eventifyArrayWithCat(
                $this->timetable_model->get_user_timetable_events(
                        $user->id,  
                        $data["startAndEndDateforMonth"][0],  
                        $data["startAndEndDateforMonth"][1]
                    ), $data["timetableCategories"]
                );
//        echo "<pre>";
//        print_r($this->timetable_model->get_user_timetable_events(
//                        $user->id,  
//                        $data["startAndEndDateforMonth"][0],  
//                        $data["startAndEndDateforMonth"][1]
//                    ));
//        echo "</pre>";
//        return;
        $data["eventRepetition"] = $this->timetable_repetition_model->get_timetable_repeats($user->id);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($user->id), true);
        $data["locations"] = $this->location_model->getLocations($user->id);
        $this->load->view('header', getPageTitle($data, $this->toolName,"Overview",""));
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

    public function search() {
        $user = $this->session->userdata("user");
        $data = null;
        $data["timetableCategories"] = $this->timetable_category_model->get_user_timetable_Category($user->id);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_user_expense_types($user->id), true);
        $this->load->view("header", $data);
        $this->load->view("timetable/timetable_nav");
        $this->load->view("timetable/search", $data);
        $this->load->view("footer");
    }

    public function filteredSearch() {
        $user = $this->session->userdata("user");
//        echo "<pre>";
//        print_r($this->input->post());
//        echo "</pre>";
        $search["id"] = $this->input->post("id");
        $search["name"] = $this->input->post("name");
        $search["description"] = $this->input->post("description");
        $search["timetableCategory"] = $this->input->post("timetableCategory");
        $search["allDayEvent"] = $this->input->post("allDayEvent");
        $search["startDate"] = $this->input->post("startDate");
        $search["endDate"] = $this->input->post("endDate");
        $search["locationId"] = $this->input->post("locationId");
        $search["location"] = $this->input->post("location");
        $search["timetableExpenseType"] = $this->input->post("timetableExpenseType");
        $data["entries"] = $this->timetable_model->getFilteredTimetableEvents($user->id, $search);
        $this->load->view("/timetable/searchEntries", $data);
    }

    public function timePeriod() {
//        echo __CLASS__ . " >> " . __FUNCTION__;
        $user = $this->session->userdata("user");
        $data["timetableCategories"] = mapKeyToId($this->timetable_category_model->get_user_timetable_Category($user->id));
        echo eventifyArrayWithCat(
            $this->timetable_model->get_user_timetable_events(
                $user->id,  
                $this->input->post("startDate"),  
               $this->input->post("endDate")
            ), $data["timetableCategories"]
        );
    }

    public function view($id) {
        $user = $this->session->userdata("user");
        $data["event"] = $this->timetable_model->get_user_timetable_event($user->id, $id);
        echo json_encode($data["event"]);
    }

}
