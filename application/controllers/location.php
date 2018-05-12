<?php

class Location extends CI_Controller {

    var $toolId = 3;
    var $toolName = "Locations";
    var $geoIdApiDetails = "";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->model('location_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper("form");
        $this->load->library("form_validation");
        $this->load->helper('auth_helper');
        $this->load->helper("usability_helper");
        $this->load->library('pagination');
        can_access($this->require_auth, $this->session);
    }

    /**
     * Delete location when given the location ID
     * It checks whether this location belongs to the current session user
     * Returns status and view.
     * @param type $locationId
     */
    public function delete($locationId = null) {
        $data["action_description"] = "Delete Location";
        if (null != $locationId) {
            if ($this->location_model->doesItBelongToMe($this->session->userdata("user")->id, $locationId)) {
                $this->location_model->delete($locationId);
                $data["status"] = "Location Deleted Successfully";
                $data["action_classes"] = "success";
                $data["message_classes"] = "success";
                $data["message"] = "The location has been deleted.";
                $data["reUrl"] = "/locations";
            } else {
                $data["status"] = "Location Error Deleting the Location";
                $data["action_classes"] = "failure";
                $data["message_classes"] = "failure";
                $data["message"] = "This location does not belong to you. "
                        . "<br/>Please refrain from attempting to perform harmful actions to others data!";
                $data["reUrl"] = "/locations";
            }
        } else {
            $data["status"] = "Error Deleteing Location";
            $data["action_classes"] = "failure";
            $data["message_classes"] = "failure";
            $data["message"] = "No location was provided, please provide a valid location ID.";
            $data["reUrl"] = "/locations";
        }
        $data["locations"] = $this->location_model->getLocations($this->session->userdata("user")->id);
        $this->load->view("header");
        $this->load->view('general/action_status', $data);
        $this->load->view("location/index", $data);
        $this->load->view("location/capture_form");
        $this->load->view("footer");
    }

    public function manage($page = null) {
        $data["css"] = '<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />';
        $data["js"] = '<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>';
        if ($page == null) {
            $page = 1;
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/locations/page/1';
            $config['per_page'] = 10;
            $config['total_rows'] = 10;
            $config['cur_page'] = 1;
            $this->pagination->initialize($config);
        } else {
            $this->pagination->uri_segment = 3;
        }
        $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/locations/page/';
        $this->pagination->per_page = 10;
        $this->pagination->use_page_numbers = TRUE;
        $this->pagination->cur_page = $page;
        $data["cur_page"] = $page;
        $data["per_page"] = 10;
        $user = $this->session->userdata("user");
        $data["locations"] = $this->location_model->getLocations(
            $user->id, 
            $this->pagination->per_page, 
            (($page == null || $page== 1 ) ? null : $page * $this->pagination->per_page -10)
        );
        $this->pagination->total_rows = $this->location_model->getLocations($user->id, null, null, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Manage Locations"));
        $this->load->view("location/index", $data);
        $this->load->view("location/capture_form", $data);
        $this->load->view("footer");
    }

    public function save() {
        $this->load->library('session');
        $this->load->library('form_validation');
        $data["action_description"] = "Save Location";
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('latitude', 'latitude', 'required');
        $this->form_validation->set_rules('longitude', 'longitude', 'required');
        $this->form_validation->set_rules('email', 'email');
        if ($this->form_validation->run() == TRUE) {
            $locationId = $this->input->post("locationId");
            $data["action_description"] = "Save Location";
            if ($this->location_model->set_user_location($this->session->userdata("user")->id, $locationId)) {
                $data["status"] = "Location Saved Successfully";
                $data["action_classes"] = "success";
                $data["message_classes"] = "success";
                $data["message"] = "The location has been saved.";
            } else {
                $data["status"] = "Location Error Saving Location";
                $data["action_classes"] = "failure";
                $data["message_classes"] = "failure";
                $data["message"] = "The location was not saved, please try again.";
            }
        } else {
            $data["status"] = "Location Error Saving Location";
            $data["action_classes"] = "failure";
            $data["message_classes"] = "failure";
            $data["message"] = "Please complete the form fields";
        }
        $data["cur_page"] = 1;
        $data['per_page'] = 10;
        $config['per_page'] = 10;
        if(!empty($this->session->userdata($this->toolName."CurPage"))){
            $data["cur_page"] = $this->session->userdata($this->toolName."CurPage");
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/locations/page/';
            $config['total_rows'] = 10;
            $this->pagination->initialize($config);
        }
        $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/locations/page/';
        $this->pagination->per_page = 10;
        $this->pagination->use_page_numbers = TRUE;
        $data["locations"] = $this->location_model->getLocations(
                $this->session->userdata("user")->id, 
                $this->pagination->per_page, 
                (($data["cur_page"] == null || $data["cur_page"]== 1 ) ? null : $data["cur_page"] * $this->pagination->per_page -10), null,null);
        $this->pagination->total_rows = $this->location_model->getLocations(
                $this->session->userdata("user")->id, 
                null, 
                null, true,null);
        $this->session->set_userdata($this->toolName."CurPage", $data["cur_page"]);
        $data["locations"] = $this->location_model->getLocations($this->session->userdata("user")->id);
        $this->load->view('general/action_status', $data);
        $this->load->view("location/index", $data);
        $this->load->view("footer");
    }

    public function search($locationNameStr = "",$json=false) {
        $this->load->helper('form');
        //echo __CLASS__ ." > ". __METHOD__ . " > ". $locationNameStr;
//        print_r(Array($this->input->post(),$this->input->get()));
        if($json){
            echo json_encode($this->location_model->search($locationNameStr, $this->session->userdata("user")->id), 15);
        }else{
            $page = 1;
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/locations/page/';
            $config['per_page'] = 10;
            $config['total_rows'] = 10;
            $config['cur_page'] = 1;
            $this->pagination->initialize($config);
            $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/locations/page/';
            $this->pagination->per_page = 10;
            $this->pagination->use_page_numbers = TRUE;
            $this->pagination->cur_page = $page;
            $data["cur_page"] = $page;
            $data["per_page"] = 10;
            $user = $this->session->userdata("user");
            if(!empty($locationNameStr)){
                $data["locations"] = $this->location_model->search($locationNameStr,
                    $user->id, $this->pagination->per_page, (($page == null || $page== 1 ) ? null : $page * $this->pagination->per_page -10));
                $this->pagination->total_rows = $this->location_model->search($locationNameStr,$user->id, null, null, true);
            }else{
                $data["locations"] = $this->location_model->getLocations($user->id, $this->pagination->per_page, 
                    (($data["cur_page"] == null || $data["cur_page"]== 1 ) ? null : $data["cur_page"] * $this->pagination->per_page -10), null,null);
                $this->pagination->total_rows = $this->location_model->getLocations($user->id, null, null, true, null);
            }
            $output =  $this->load->view("location/result_table", $data, TRUE);
            echo $output;
        }
    }
    
    public function searchJson($locationNameStr = "" ){
        $this->load->helper('form');
        $this->load->helper('json_helper');
        echo locationAutocompletify($this->location_model->search($locationNameStr, $this->session->userdata("user")->id), 15);
    }
    

    public function getLocationData($locationId) {
        if ($this->location_model->doesItBelongToMe($this->session->userdata("user")->id, $locationId)) {
            $data["location"] = $this->location_model->getLocation($this->session->userdata("user")->id, $locationId);
            $data["status"] = "1";
        } else {
            $data["status"] = "0";
            $data["message"] = "This location does not belong to this user.";
        }
        echo json_encode($data);
    }

}
