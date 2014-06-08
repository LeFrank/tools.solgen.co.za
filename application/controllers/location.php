<?php
class Location extends CI_Controller {

    var $toolId = 3;
    var $toolName = "Locations";
    var $geoIdApiDetails = "";
    var $require_auth = TRUE;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_location_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper("form");
        $this->load->library("form_validation");
        $this->load->helper('auth_helper');
    }
 
     public function manage() {
        $this->load->library('session');
        can_access(TRUE, $this->session);
        $this->load->model("user_location_model");
        $data["locations"] = $this->user_location_model->getLocations($this->session->userdata("user")->id);
        $this->load->view("header");
        $this->load->view("location/index", $data);
        $this->load->view("location/capture_form", $data);
        $this->load->view("footer");
    }
    
    public function save() {
        $this->load->library('session');
        $this->load->model('user_location_model');
        $locationId = $this->input->post("locationId");
        $data["action_description"] = "Save Location";
        if ($this->user_location_model->set_user_location($this->session->userdata("user")->id, $locationId)) {
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
        echo $this->load->view('general/action_status', $data, TRUE);
    }
    
    public function view($locationId){
        echo __CLASS__ . " > ". __FUNCTION__ . " > locationId : " . $locationId;
        
    }
}
