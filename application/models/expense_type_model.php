<?php

class Expense_type_model extends CI_Model {

    var $tn = "expense_type";

    public function __construct() {
        $this->load->database();
    }

    public function create_expense_type() {
        $data = array(
            'description' => $this->input->post('description'),
            'template' => $this->input->post('template'),
            'enabled' => ($this->input->post('enabled')) ? 1 : 0,
            'create_date' => date('Y/m/d H:i:s'),
            'user_id' => $this->session->userdata("user")->id
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

    public function doesItExist($userId, $description) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'description' => $description));
        return $query->num_rows();
    }

    public function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tn);
    }

    public function get_expense_type($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    public function get_expense_types() {
        $this->db->order_by("description", "asc");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
        return $query->result_array();
    }

    public function get_user_expense_types($userId) {
        $this->db->order_by("description", "asc");
        $this->db->or_where("user_id =", $userId);
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
        //print "SQL Query: ".$this->db->last_query(); 
        return $query->result_array();
    }

    public function get_only_user_expense_types($userId) {
        $this->db->order_by("description", "asc");
        $query = $this->db->get_where($this->tn, array('user_id' =>$userId));
        return $query->result_array();
    }

    public function deleteUserData($userId) {
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }

    public function update() {
        $data = array(
            "description" => $this->input->post('description'),
            'template' => $this->input->post('template'),
            "enabled" => ($this->input->post('enabled')) ? 1 : 0,
            "update_date" => date('Y/m/d H:i:s')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}
