<?php
class health_model extends CI_Model {

    var $tn = "health";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
}