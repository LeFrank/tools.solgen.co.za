<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class expense_model extends CI_Model {

    var $tn = "expense";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function getExpenses($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("expense_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }

    public function getExpensesbyDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("expense_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'expense_date >='=> $startDate , 'expense_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'expense_date >='=> $startDate , 'expense_date <= ' => $endDate), $limit, $offset);
        }
        return $query->result_array();
    }
    
    public function capture_expense() {
        $this->load->helper('date');
        $this->load->library("session");
        $data = array(
            'amount' => $this->input->post('amount'),
            'expense_type_id' => $this->input->post('expenseType'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'expense_date' => date('Y/m/d H:i', strtotime($this->input->post('expenseDate'))),
            'user_id' => $this->session->userdata("user")->id
        );
        return $this->db->insert($this->tn, $data);
    }

}
