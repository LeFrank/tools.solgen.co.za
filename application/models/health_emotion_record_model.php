<?php

class health_emotion_record_model extends CI_Model {

    var $tn = "health_emotion_record";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_emotion($emotion) {
        $this->load->helper('date');
        $this->load->library("session");
        $date = date('Y/m/d H:i');
        $data = array(
            'emotion_id' => $emotion["emotion_id"],
            'created_date' => $date,
            'description' => $emotion["description"],
            'user_id' => $this->session->userdata("user")->id
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
    public function getEmotionRecordbyId($id) {
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
    public function getEmotionRecords($userId = null, $limit = null, $offset = 0) {
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

    public function getEmotionRecordByIds($userId , $userConfigIds){
        if ($userId == null) {
            return null;
        }
        if($userConfigIds == null){
            return null;
        }
        $this->db->order_by("created_date", "desc");
        $this->db->where_in('id', $userConfigIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }
    
    /**
     * Get health metrics by date range. Can be filtered by user and delimited
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
    public function getEmotionRecordsByDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0, $orderBy = null, $direction = "asc") {
        if (null != $orderBy) {
            $this->db->order_by($orderBy, $direction);
        } else {
            $this->db->order_by("created_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'created_date >=' => $startDate, 'created_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'created_date >=' => $startDate, 'created_date <= ' => $endDate), $limit, $offset);
        }
//        echo $this->db->last_query();
        return $query->result_array();
    }
    
    /**
     * 
     * @return type
     */
    public function update($emotion) {
        $data = array(
            'emotion_id' => $emotion["emotion_id"],
            'created_date' => date('Y/m/d H:i', strtotime($emotion["date"])),
            'description' => $emotion["description"],
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

}
