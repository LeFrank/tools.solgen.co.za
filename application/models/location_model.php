<?php

class location_model extends CI_Model {

    var $tn = "user_location";

    public function __construct() {
        $this->load->database();
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function delete($locationId) {
        $this->db->where("id", $locationId);
        $this->db->delete($this->tn);
    }

    /**
     * 
     * @param type $userId
     * @param type $locationId
     * @return type
     */
    public function doesItBelongToMe($userId, $locationId) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $locationId));
        return $query->num_rows();
    }

    public function getLocation($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->row();
    }

    public function getLocations($userId , $limit = null, $default = null) {
        $whereArray = array('user_id' => $userId);
        if(null != $default){
            $whereArray["priority"] = 1;
        }
        if (null != $limit) {
            $query = $this->db->get_where($this->tn, $whereArray, $limit);
        }else{
            $query = $this->db->get_where($this->tn, $whereArray);
        }
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
        if($data["priority"] == 1){
            $this->unDefaultOtherLocations($userId);
        }
        if (null != $id) {
            unset($data["create_date"]);
            $data["last_updated"] = date('Y/m/d H:i:s');
            $this->db->where('id', $id);
            return $this->db->update($this->tn, $data);
        } else {
            return $this->db->insert($this->tn, $data);
        }
    }
    
    private function unDefaultOtherLocations($userId){
        $this->db->where('user_id', $userId);
        return $this->db->update($this->tn, array("priority"=> 0));
    }

}
