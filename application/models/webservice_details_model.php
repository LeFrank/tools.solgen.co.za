<?php

class Webservice_details_model extends CI_Model {

    var $tn = "webservice_details";

    public function __construct() {
        $this->load->database();
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function getDetailsByToolId($toolId) {
        $query = $this->db->get_where($this->tn, array('tool_id' => $toolId));
        return $query->row();
    }

}
