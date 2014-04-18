<?php

class Expense_type_model extends CI_Model {

    var $tn = "expense_type";

    public function __construct() {
        $this->load->database();
    }

    public function get_expense_types() {
        $this->db->order_by("description", "asc");
        $query = $this->db->get($this->tn);
        return $query->result_array();
    }

}
