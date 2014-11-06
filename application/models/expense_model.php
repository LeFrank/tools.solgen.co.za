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

    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_expense() {
        $this->load->helper('date');
        $this->load->library("session");
        $date = ($this->input->post('expenseDate') != "") ? date('Y/m/d H:i', strtotime($this->input->post('expenseDate'))): date('Y/m/d H:i');
        $data = array(
            'amount' => $this->input->post('amount'),
            'expense_type_id' => $this->input->post('expenseType'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'expense_date' => $date,
            'user_id' => $this->session->userdata("user")->id,
            'payment_method_id' => $this->input->post('paymentMethod')
        );
        return $this->db->insert($this->tn, $data);
    }

    /**
     * 
     * @param type $id
     */
    public function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tn);
    }

    /**
     * 
     * @param type $userId
     */
    public function deleteUserData($userId) {
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }

    /**
     * 
     * @param type $userId
     * @param type $id
     * @return type
     */
    public function doesItBelongToMe($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->num_rows();
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getExpense($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    /**
     * Get expenses bases on certain criteria
     * @param type $userId if present return this users expenses.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
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

    public function getExpensesByIds($userId , $expenseIds){
        if ($userId == null) {
            return null;
        }
        if($expenseIds == null){
            return null;
        }
        $this->db->order_by("expense_date", "desc");
        $this->db->where_in('id', $expenseIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }
    
    /**
     * 
     * @param type $userId
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getexpensesByCriteria($userId = null, $limit = null, $offset = 0) {
        if (null != $userId) {
            $this->db->order_by("expense_date", "desc");
            if ($this->input->post("fromAmount") != $this->input->post("toAmount")) {
                $this->db->where("amount >=", $this->input->post("fromAmount"));
                $this->db->where("amount <=", $this->input->post("toAmount"));
            }
            if ($this->input->post("keyword") != "") {
                $this->db->like("description", $this->input->post("keyword"));
            }
            $expenseTypeArr = $this->input->post("expenseType");
            $paymentMethodArr = $this->input->post("paymentMethod");
            if (!empty($expenseTypeArr) && $expenseTypeArr[0] != "all") {
                $this->db->where_in("expense_type_id", array_map('intval', $this->input->post("expenseType")));
            }
            if (!empty($paymentMethodArr) && $paymentMethodArr[0] != "all") {
                $this->db->where_in("payment_method_id", array_map('intval', $this->input->post("paymentMethod")));
            }
            if (null == $limit) {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'expense_date >=' => $this->input->post("fromDate"), 'expense_date <= ' => $this->input->post("toDate")));
            } else {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'expense_date >=' => $this->input->post("fromDate"), 'expense_date <= ' => $this->input->post("toDate")), $limit, $offset);
            }
            return $query->result_array();
        }
    }

    /**
     * Get expenses by date range. Can be filtered by user and delimited
     * 
     * @param type $startDate
     * @param type $endDate
     * @param type $userId
     * @param type $limit
     * @param type $offset
     * @param type $orderBy
     * @param type $direction
     * @return null
     */
    public function getExpensesbyDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("expense_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'expense_date >=' => $startDate, 'expense_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'expense_date >=' => $startDate, 'expense_date <= ' => $endDate), $limit, $offset);
        }
//        echo $this->db->last_query();
        return $query->result_array();
    }

    /**
     * 
     * @return type
     */
    public function update() {
        $data = array(
            'amount' => $this->input->post('amount'),
            'expense_type_id' => $this->input->post('expenseType'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'expense_date' => date('Y/m/d H:i', strtotime($this->input->post('expenseDate'))),
            'user_id' => $this->session->userdata("user")->id,
            'payment_method_id' => $this->input->post('paymentMethod')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}
