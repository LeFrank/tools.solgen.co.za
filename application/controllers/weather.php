<?php

class Weather extends CI_Controller {

    var $toolId = 2;
    var $toolName = "Weather";
    var $sevenDay = 7;
    var $current = 1;
    var $weatherApiDetails = "";
    var $require_auth = TRUE;
    var $measure = array(
        "imperial" => "°F",
        "imperialWord" => "Fahrenheit",
        "metric" => "°C",
        "metricWord" => "Celsius");

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper('usability_helper');
        can_access($this->require_auth, $this->session);
        $this->load->model("location_model");
        $this->load->model("webservice_details_model");
        $this->load->model("weather_data_model");
        $this->load->model("weather_settings_model");
        $this->weatherApiDetails = $this->webservice_details_model->getDetailsByToolId($this->toolId);
    }

    public function index() {
        $forecastDayCount = 7;
        $callType = "forecast/daily";
        $user = $this->session->userdata("user");
        $userLocation = null;
        $data["locations"] = $this->location_model->getLocations($user->id);
        $data["user"] = $user;
        if (!empty($user) && !empty($this->weatherApiDetails)) {
            //get user location
            $userLocations = $this->location_model->getLocations($user->id, null, null,null, 1);
        }
        //build api URL
        foreach ($userLocations as $k => $v) {
            // first check our stored/cached data
            $weatherData = $this->weather_data_model->getWeatherData($user->id, $v->id, date('Y/m/d H:i'), $this->sevenDay);
            if (null == $weatherData || empty($weatherData)) {
                $url = $this->weatherApiDetails->url . "/" . $callType . "?mode=json";
                $url .= "&lat=" . $v->latitude . "&lon=" . $v->longitude . "&units=metric&cnt=" . $forecastDayCount;
                $url .= "&APPID=" . $this->weatherApiDetails->api_key;
                //call api
                $raw_data = file_get_contents($url);
                //store data for next 12 hours
                $this->weather_data_model->save($user->id, $v->id, $raw_data, $this->sevenDay);
                $data["myWeather"][$k]["weather"] = json_decode($raw_data);
                $data["myWeather"][$k]["location"] = $v;
            } else {
                $raw_data = $weatherData[0]->data;
                $data["myWeather"][$k]["weather"] = json_decode($raw_data);
                $data["myWeather"][$k]["location"] = $v;
            }
        }
        $data["weatherSettings"] = $this->weather_settings_model->getSetting($this->session->userdata("user")->id);
        $data["weatherSettings"] = $data["weatherSettings"][0];
        unset($data["weatherSettings"]->id);
        unset($data["weatherSettings"]->user_id);
        $data["measure"] = $this->measure;
        //apply data suggestions
        //display data
        $this->load->view('header', getPageTitle($data, $this->toolName));
        $this->load->view("weather/weather_nav");
        $this->load->view("weather/index", $data);
        $this->load->view("weather/locations", $data);
        $this->load->view("footer");
    }

    /**
     * Gets Todays weather for the posted data
     * returns json data, rendered via javascript handlebars templates
     * js templates found in /js/weather/template/ directory
     */
    public function getTodaysWeather() {
        $this->load->library("input");
        $callType = "weather";
        $user = $this->session->userdata("user");
        $data["location"] = $this->location_model->getLocation($user->id, $this->input->post("locationId"));
        $data["user"] = $user;
        // first check our stored/cached data
        $weatherData = $this->weather_data_model->getWeatherData($user->id, $data["location"]->id, date('Y/m/d H:i'), $this->current);
        if (null == $weatherData || empty($weatherData)) {
            $url = $this->weatherApiDetails->url . "/" . $callType . "?";
            $url .= "lat=" . $data["location"]->latitude . "&lon=" . $data["location"]->longitude . "&units=metric";
            $url .= "&APPID=" . $this->weatherApiDetails->api_key;
            //call api
            $raw_data = file_get_contents($url);
            //store data for next 12 hours
            $this->weather_data_model->save($user->id, $data["location"]->id, $raw_data, $this->current);
            $data["myWeather"]["weather"] = $raw_data;
        } else {
            $raw_data = $weatherData[0]->data;
        }
        $data["weatherSettings"] = $this->weather_settings_model->getSetting($this->session->userdata("user")->id);
        $data["measure"] = $this->measure;
        $data["myWeather"]["weather"] = json_decode($raw_data);
        $data["myWeather"]["location"] = $data["location"];
        echo json_encode($data["myWeather"]);
    }

    /**
     * Gets seven days worth of weather for the posted data
     * returns json data, rendered via javascript handlebars templates
     * js templates found in /js/weather/template/ directory
     */
    public function getSevenDaysWeather() {
        $this->load->library("input");
        $forecastDayCount = 7;
        $callType = "forecast/daily";
        $user = $this->session->userdata("user");
        $data["location"] = $this->location_model->getLocation($user->id, $this->input->post("locationId"));
        $data["user"] = $user;
        // first check our stored/cached data
        $weatherData = $this->weather_data_model->getWeatherData($user->id, $data["location"]->id, date('Y/m/d H:i'), $this->sevenDay);
        if (null == $weatherData || empty($weatherData)) {
            $url = $this->weatherApiDetails->url . "/" . $callType . "?mode=json";
            $url .= "&lat=" . $data["location"]->latitude . "&lon=" . $data["location"]->longitude . "&units=metric&cnt=" . $forecastDayCount;
            $url .= "&APPID=" . $this->weatherApiDetails->api_key;
            //call api
            $raw_data = file_get_contents($url);
            //store data for next 12 hours
            $this->weather_data_model->save($user->id, $data["location"]->id, $raw_data, $this->sevenDay);
        } else {
            $raw_data = $weatherData[0]->data;
        }
        $data["weatherSettings"] = $this->weather_settings_model->getSetting($this->session->userdata("user")->id);
        $data["measure"] = $this->measure;
        $data["myWeather"]["weather"] = json_decode($raw_data);
        $data["myWeather"]["location"] = $data["location"];
        echo json_encode($data["myWeather"]);
    }

    public function options() {
        $weatherSettings = $this->weather_settings_model->getSetting($this->session->userdata("user")->id);
        $data["weatherSetting"] = new stdClass();
        $data["weatherSetting"]->measurement = "";
        if (!empty($weatherSettings)) {
            $data["weatherSetting"]->measurement = $weatherSettings[0]->measurement;
        }
        $data["measure"] = $this->measure;
        $this->load->view('header', getPageTitle($data, $this->toolName, "Options"));
        $this->load->view("weather/weather_nav");
        $this->load->view("weather/options", $data);
        $this->load->view("footer");
    }

    public function saveMeasurement() {
        $this->load->library("input");
        $this->load->model("weather_settings_model");
        echo $this->weather_settings_model->setMeasurement($this->session->userdata("user")->id, $this->input->post("measurement"));
    }

}
