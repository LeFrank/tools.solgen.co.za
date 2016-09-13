<?php

class timetable_repetition_model extends CI_Model {

    var $tn = "timetable_repetition";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function create_timetable_event() {
		$data = array(
			"name"			=> $this->input->post("name"),
			"val" 			=> $this->input->post("val"),
			"create_date"	=> date('Y/m/d H:i:s')
        );
        if ($this->input->post('id') != "") {
            $data["update_date"] = date('Y/m/d H:i:s');
            $this->db->where('id', $this->input->post('id'));
            return $this->db->update($this->tn, $data);
        } else {
            return $this->db->insert($this->tn, $data);
        }
    }

    public function delete($repeatId) {
        $this->db->where("id", $repeatId);
        $this->db->delete($this->tn);
    }

    /**
     * 
     * @param type $userId
     * @param type $Id
     * @return type
     */
    public function doesItBelongToMe($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->num_rows();
    }

    public function get_user_timetable_repeats($userId) {
        $this->db->order_by("val", "asc");
        $this->db->or_where("user_id =", $userId);
        $query = $this->db->get_where($this->tn);
        return $query->result();
    }

    public function get_timetable_repeats($userId) {
        $this->db->order_by("val", "asc");
        $this->db->or_where("user_id =", $userId);
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn);
        // echo $this->db->last_query();
        return $query->result();
    }

    public function get_user_timetable_repetition($userId, $id) {
        $this->db->or_where("user_id =", $userId);
        $query = $this->db->get_where($this->tn, array("id" => $id));
        return $query->result();
    }

    public function get_timetable_repitition($id){
        $query = $this->db->get_where($this->tn, array("id" => $id));
        return $query->result();
    }
}