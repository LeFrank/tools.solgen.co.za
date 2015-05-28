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

    public function manage() {
        $this->load->library('session');
        $data["css"] = '<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />';
        $data["js"] = '<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>';
        can_access(TRUE, $this->session);
        $data["locations"] = $this->location_model->getLocations($this->session->userdata("user")->id);
        $this->load->view("header", $data);
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
        $data["locations"] = $this->location_model->getLocations($this->session->userdata("user")->id);
        $this->load->view('general/action_status', $data);
        $this->load->view("location/index", $data);
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
