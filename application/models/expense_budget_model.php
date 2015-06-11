<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class expense_budget_model extends CI_Model {

    var $tn = "expense_budget";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users budget from a post request. 
     * @return type
     */
    public function capture_expense_budget() {
        echo __CLASS__ . " >> ". __FUNCTION__ . " >> ". __LINE__;
        $this->load->helper('date');
        $this->load->library("session");
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'user_id' => $this->session->userdata("user")->id,
            'expense_period_id' =>  $this->input->post('expensePeriod'),
            'create_date' => date('Y/m/d H:i')
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
    
    public function doesItExist($userId, $description) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'description' => $description));
        return $query->num_rows();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getExpenseBudget($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    /**
     * Get budgets bases on certain criteria
     * @param type $userId if present return this users expenses.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getExpenseBudgets($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("expense_period_id", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }

    /**
     * 
     * @return type
     */
    public function update() {
        $this->load->helper('date');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'user_id' => $this->session->userdata("user")->id,
            'expense_period_id' =>  $this->input->post('expensePeriod'),
            'update_date' => date('Y/m/d H:i')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}