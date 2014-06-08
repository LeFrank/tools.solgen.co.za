<?php

class Weather extends CI_Controller {
    var $toolId = 2;
    var $toolName = "Weather";
    var $weatherApiDetails = "";
    var $require_auth = TRUE;
    
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        can_access($this->require_auth, $this->session);
        $this->load->model("webservice_details_model");
        $this->weatherApiDetails = $this->webservice_details_model->getDetailsByToolId($this->toolId);
    }

    public function index() {
        //forecast forecast/daily?&mode=json&lat=-33.924868&lon=18.424055&units=metric&cnt=7
        $forecastDayCount = 7;
        $callType = "forecast/daily";
        $user = $this->session->userdata("user");
        $userLocation = null;
        $data["user"] = $user;
        if(!empty($user) && !empty($this->weatherApiDetails)){
            //get user location
            $this->load->model("user_location_model");
            $userLocation  = $this->user_location_model->getLocation($user->id);
        }
        if(null == $userLocation || empty($userLocation)){
            //Display error with instructions for how the user should go about capturing location details. 
            //Or display a form to get them
            //Or get them
            echo    "Display error with instructions for how the user should go about capturing location details. ".
                    "Or display a form to get them".
                    "Or get them";
            exit;
        }
        //build api URL
        $url = $this->weatherApiDetails->url. "/".$callType. "?mode=json";
        $url .= "&lat=".$userLocation->latitude."&lon=".$userLocation->longitude."&units=metric&cnt=".$forecastDayCount;
        $url .= "&APPID=".$this->weatherApiDetails->api_key;
        //call api
        $data["myWeather"] = json_decode(file_get_contents($url));
        //parse through data
        
        //store data for next 12 hours
        //apply data suggestions
        //display data
        $this->load->view("header");
        $this->load->view("weather/index", $data);
        $this->load->view("footer");
    }

}
