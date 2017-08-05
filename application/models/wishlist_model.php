<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wishlist_item_model
 *
 * @author francois
 */
class wishlist_model extends CI_Model {

    var $tn = "wishlist";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    
    public function capture_item(){
        $this->load->helper('date');
        $this->load->library("session");
        $date = ($this->input->post('targetDate') != "") ? date('Y/m/d H:i', strtotime($this->input->post('targetDate'))): date('Y/m/d H:i');
        $data = array(
            'name' => $this->input->post('name'),
            'cost' => $this->input->post('cost'),
            'description' => $this->input->post('description'),
            'reason' => $this->input->post('reason'),
            'priority' => $this->input->post('priority'),
            'target_date' => $date,
            'status' => $this->input->post('status'),
            'user_id' => $this->session->userdata("user")->id,
            'creation_date' => date('Y/m/d H:i'),
            'expense_type_id' => $this->input->post('expenseType')
        );
        $this->db->insert($this->tn, $data);
        return $this->db->insert_id();
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
    public function getItem($userId,  $id) {
        if ($userId == null) {
            return null;
        }
        $query = $this->db->get_where($this->tn, array('user_id' => $userId,'id' => $id));
        return $query->row();
    }

    /**
     * Get expenses bases on certain criteria
     * @param type $userId if present return this users expenses.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getItems($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("creation_date", "desc");
        $this->db->order_by("priority", "desc");
        $this->db->order_by("status", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }

    public function getItemsByIds($userId , $itemIds){
        if ($userId == null) {
            return null;
        }
        if($itemIds == null){
            return null;
        }
        $this->db->order_by("creation_date", "desc");
        $this->db->where_in('id', $itemIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }
    
    /**
     * Get wishlist items by date range. Can be filtered by user and delimited
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
    public function getItemsbyDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("creation_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'target_date >=' => $startDate, 'target_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'target_date >=' => $startDate, 'target_date <= ' => $endDate), $limit, $offset);
        }
        //echo $this->db->last_query();
        return $query->result_array();
    }

    
    public function getItemsByCriteria($userId = null, $limit = null, $offset = 0) {
        if (null != $userId) {
            $this->db->order_by("priority", "desc");
            $this->db->order_by("status", "desc");
            if ($this->input->post("fromAmount") != $this->input->post("toAmount")) {
                $this->db->where("cost >=", $this->input->post("fromAmount"));
                $this->db->where("cost <=", $this->input->post("toAmount"));
            }
            if ($this->input->post("keyword") != "") {
                $this->db->like("description", $this->input->post("keyword"));
                $this->db->like("reason", $this->input->post("keyword"));
            }
            $statusArr = $this->input->post("statuses");
            $priorityArr = $this->input->post("priorities");
            if (!empty($statusArr) && $statusArr[0] != "all") {
                $this->db->where_in("status", array_map('intval', $statusArr));
            }
            if (!empty($priorityArr) && $priorityArr[0] != "all") {
                $this->db->where_in("priority", array_map('intval', $priorityArr));
            }
            if (null == $limit) {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'target_date >=' => $this->input->post("fromDate"), 'target_date <= ' => $this->input->post("toDate")));
            } else {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'target_date >=' => $this->input->post("fromDate"), 'target_date <= ' => $this->input->post("toDate")), $limit, $offset);
            }
            return $query->result_array();
        }
    }
    
    /**
     * 
     * @return type
     */
    public function update($id=null) {
        $data = array(
            'name' => $this->input->post('name'),
            'cost' => $this->input->post('cost'),
            'description' => $this->input->post('description'),
            'reason' => $this->input->post('reason'),
            'priority' => $this->input->post('priority'),
            'target_date' => date('Y/m/d H:i', strtotime($this->input->post('targetDate'))),
            'status' => $this->input->post('status'),
            'user_id' => $this->session->userdata("user")->id,
            'update_date' => date('Y/m/d H:i'),
            'expense_type_id' => $this->input->post('expenseType')
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tn, $data);
    }
}
