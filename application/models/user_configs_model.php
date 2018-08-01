<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class user_configs_model extends CI_Model {

    var $tn = "user_configs";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_user_config($config) {
        $this->load->helper('date');
        $this->load->library("session");
        $date = date('Y/m/d H:i');
        $data = array(
            'toolId' => $config["toolId"],
            'key' => $config["key"],
            'val' => $config["val"],
            'created_date' => $date,
            'user_id' => $this->session->userdata("user")->id
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
    public function getUserConfig($id) {
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
    public function getUserConfigs($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("created_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }

    public function getUserConfigsByIds($userId , $userConfigIds){
        if ($userId == null) {
            return null;
        }
        if($userConfigIds == null){
            return null;
        }
        $this->db->order_by("create_date", "desc");
        $this->db->where_in('id', $userConfigIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }
    
    
    public function getUserConfigsByToolId($userId , $toolId){
        if ($userId == null) {
            return null;
        }
        if($toolId == null){
            return null;
        }
        $this->db->order_by("created_date", "desc");
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'tool_id' => $toolId), 100);
        return $query->result_array();
    }
    
    /**
     * 
     * @return type
     */
    public function update($config) {
        $data = array(
            'toolId' => $config["toolId"],
            'key' => $config["key"],
            'val' => $config["val"],
            'created_date' => $date,
            'user_id' => $this->session->userdata("user")->id
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}
