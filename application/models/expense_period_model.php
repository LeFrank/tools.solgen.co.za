<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class expense_period_model extends CI_Model {

    var $tn = "expense_period";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_expense_period() {
        $this->load->helper('date');
        $this->load->library("session");
        if($this->input->post('active') == 1){
            //update all other periods for this user to active = 0 (false)
            $data = array("user_id" => $this->session->userdata("user")->id,
                "active" => 0 );
            $this->db->where('user_id', $this->session->userdata("user")->id);
            $this->db->update($this->tn, $data);
        }
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'start_date' => date('Y/m/d H:i', strtotime($this->input->post('startDate'))),
            'end_date' => date('Y/m/d H:i', strtotime($this->input->post('endDate'))),
            'create_date' => date('Y/m/d H:i'),
            'user_id' => $this->session->userdata("user")->id,
            'active' => $this->input->post('active')
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
     * Get the current live expense period
     * @return type
     */
    public function getCurrentExpensePeriod(){
        $query = $this->db->get_where($this->tn, array("active" => 1));
        return $query->row();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getExpensePeriod($id) {
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
    public function getExpensePeriods($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("start_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }

    public function getExpensePeriodsByIds($userId , $expensePeriodIds){
        if ($userId == null) {
            return null;
        }
        if($expenseIds == null){
            return null;
        }
        $this->db->order_by("start_date", "desc");
        $this->db->where_in('id', $expensePeriodIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }
    
    /**
     * Get expensePeriod by date range. Can be filtered by user and delimited
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
    public function getExpensePeriodByDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("start_date", "desc");
            $this->db->order_by("end_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date >=' => $startDate, 'end_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date >=' => $startDate, 'end_date <= ' => $endDate), $limit, $offset);
        }
//        echo $this->db->last_query();
        return $query->result_array();
    }

    /**
     * 
     * @return type
     */
    public function update() {
        $this->load->helper('date');
        if($this->input->post('active') == 1){
            //update all other periods for this user to active = 0 (false)
            $data = array("user_id" => $this->session->userdata("user")->id,
                "active" => 0 );
            $this->db->where('user_id', $this->session->userdata("user")->id);
            $this->db->update($this->tn, $data);
        }
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'start_date' => date('Y/m/d H:i', strtotime($this->input->post('startDate'))),
            'end_date' => date('Y/m/d H:i', strtotime($this->input->post('endDate'))),
            'user_id' => $this->session->userdata("user")->id,
            'active' => $this->input->post('active')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}