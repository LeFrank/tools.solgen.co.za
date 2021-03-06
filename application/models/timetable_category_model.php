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
            'appear_on_dashboard' => ($this->input->post('showOnDashboard')) ? 1 : 0,
            'reminder' => ($this->input->post('reminder')) ? 1 : 0,
            'enabled' => ($this->input->post('enabled')) ? 1 : 0,
            'text_colour' => $this->input->post('textColour'),
            'background_colour' => $this->input->post('backgroundColour')
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
    
    public function get_filtered_timetable_categories($search) {
//        print_r($search);
        $this->db->order_by("name", "asc");
        if(array_key_exists("showOnDashboard" , $search) && isset($search["showOnDashboard"])){
            $query = $this->db->get_where($this->tn, array('appear_on_dashboard' => 1, 'enabled' => 1));
        }else{
            $query = $this->db->get_where($this->tn, array('enabled' => 1));
        }
//        print "SQL Query: ".$this->db->last_query();
        return $query->result_array();
    }

    public function get_user_timetable_category($userId) {
        $this->db->order_by("name", "asc");
        $this->db->or_where("user_id =", $userId);
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
//        print "SQL Query: ".$this->db->last_query(); 
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
            "appear_on_dashboard" => ($this->input->post('showOnDashboard')) ? 1 : 0,
            "reminder" => ($this->input->post('reminder')) ? 1 : 0,
            'text_colour' => $this->input->post('textColour'),
            'background_colour' => $this->input->post('backgroundColour'),
            "update_date" => date('Y/m/d H:i:s')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}
