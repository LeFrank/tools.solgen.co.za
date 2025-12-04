<?php
/**
 * Status key and values for tasks domains
 * @author Solgen Technologies (Pty) Ltd
 * {0:"Disabled" ,1: "Enabled", 2: "Archived", 3:"Deleted"}
 */
class Tasks_domains_model extends CI_Model {

    var $tn = "tasks_domain";

    public function __construct() {
        $this->load->database();
    }

    public function create_tasks_domain() {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'text_colour' => $this->input->post('text_colour'),
            'background_colour' => $this->input->post('background_colour'),
            'emoji' => json_encode($this->input->post('emoji')),
            'user_id' => $this->session->userdata("user")->id,
            'create_date' => date('Y/m/d H:i:s')
        );
        return $this->db->insert($this->tn, $data);
    }

    public function doesItBelongToMe($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->num_rows();
    }
    
    public function isItGlobal($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => NULL, 'id' => $id));
        return $query->num_rows();
    }

    public function doesItExist($userId, $name) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'name' => $name));
        return $query->num_rows();
    }

    public function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tn);
    }

    public function get_tasks_domain($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    public function get_tasks_domains() {
        $this->db->order_by("name", "asc");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
        return $query->result_array();
    }

    public function get_user_tasks_domains($userId) {
        $this->db->order_by("name", "asc");
        $this->db->or_where("user_id =", $userId);
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn, array('status_id' => 1,'status_id' => NULL ));
        //print "SQL Query: ".$this->db->last_query(); 
        return $query->result_array();
    }

    public function get_only_user_tasks_domains($userId) {
        $this->db->order_by("name", "asc");
        $query = $this->db->get_where($this->tn, array('user_id' =>$userId));
        return $query->result_array();
    }

    public function deleteUserData($userId) {
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }

    public function update() {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'text_colour' => $this->input->post('text_colour'),
            'background_colour' => $this->input->post('background_colour'),
            'emoji' => json_encode($this->input->post('emoji')),
            "update_date" => date('Y/m/d H:i:s')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}
