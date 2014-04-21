<?php
class Payment_method_model extends CI_Model {
    var $tn = "payment_method";

    public function __construct() {
        $this->load->database();
    }

    public function get_payment_method() {
        $this->db->order_by("description", "asc");
        $query = $this->db->get_where($this->tn, array('enabled' => TRUE));
        return $query->result_array();
    }
    
    public function get_user_payment_method($userId) {
        $this->db->order_by("description", "asc");
        $this->db->or_where("user_id =" , $userId); 
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn, array('enabled' => TRUE));
        //print "SQL Query: ".$this->db->last_query(); 
        return $query->result_array();
    }
}
