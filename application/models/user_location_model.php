<?php

class User_location_model extends CI_Model {

    var $tn = "user_location";

    public function __construct() {
        $this->load->database();
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function getLocation($userId) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        return $query->row();
    }
    
    public function getLocations($userId) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        return $query->result();
    }

    public function set_user_location($userId, $id = null) {
        $this->load->helper('date');
        $data = array(
            'user_id' => $userId,
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'longitude' => $this->input->post('longitude'),
            'latitude' => $this->input->post('latitude'),
            'address' => $this->input->post('address'),
            'ktoi' => 0,
            'priority' => intval($this->input->post('priority')),
            'create_date' => date('Y/m/d H:i:s')
        );
        if (null != $id) {
            unset($data["create_date"]);
            $data["last_updated"] = date('Y/m/d H:i:s');
            $this->db->where('id', $id);
            return $this->db->update($this->tn, $data);
        } else {
            return $this->db->insert($this->tn, $data);
        }
    }

}
