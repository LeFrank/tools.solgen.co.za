<?php

class Expense_type_model extends CI_Model {

    var $tn = "expense_type";

    public function __construct() {
        $this->load->database();
    }

    public function get_expense_types() {
        $this->db->order_by("description", "asc");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
        return $query->result_array();
    }
    
    public function get_user_expense_types($userId) {
        $this->db->order_by("description", "asc");
        $this->db->or_where("user_id =" , $userId); 
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
        //print "SQL Query: ".$this->db->last_query(); 
        return $query->result_array();
    }
    
    public function deleteUserData($userId){
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }
}
