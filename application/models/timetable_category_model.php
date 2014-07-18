<?php

class timetable_category_model extends CI_Model {

    var $tn = "timetable_category";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    public function capture(){
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'description' => $this->input->post('description'),
            'name' => $this->input->post('name'),
            'create_date' => date('Y/m/d H:i:s'),
            'enabled' => ($this->input->post('enabled')) ? 1 : 0
        );
        if ($this->input->post('id') != "") {
            $data["update_date"] = date('Y/m/d H:i:s');
            $this->db->where('id', $this->input->post('id'));
            return $this->db->update($this->tn, $data);
        } else {
            return $this->db->insert($this->tn, $data);
        }
    }

    public function doesItBelongToMe($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->num_rows();
    }

    public function doesItExist($userId, $description) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'description' => $description));
        return $query->num_rows();
    }

    public function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tn);
    }

    public function get_timetable_category($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    public function get_timetable_categories() {
        $this->db->order_by("name", "asc");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
        return $query->result_array();
    }

    public function get_user_timetable_category($userId) {
        $this->db->order_by("name", "asc");
        $this->db->or_where("user_id =", $userId);
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
        //print "SQL Query: ".$this->db->last_query(); 
        return $query->result_array();
    }

    public function get_only_user_timetable_category($userId) {
        $this->db->order_by("description", "asc");
        $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        return $query->result_array();
    }

    public function deleteUserData($userId) {
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }

    public function update() {
        $data = array(
            "description" => $this->input->post('description'),
            "enabled" => ($this->input->post('enabled')) ? 1 : 0,
            "update_date" => date('Y/m/d H:i:s')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}
