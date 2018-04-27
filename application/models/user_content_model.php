<?php

class user_content_model extends CI_Model {

    var $tn = "user_content";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a user's content from a post request. 
     * @return type
     */
    public function capture_user_content( $userContent ) {
        $this->load->helper('date');
        $this->load->library("session");
        $date = date('Y/m/d H:i');
//        echo "<pre>";
//        print_r($userContent);
//        echo "</pre>";
        $data = array(
            'tool_id' => $userContent["tool_id"],
            'user_id' => $userContent["user_id"],
            'tool_entity_id' => $userContent["tool_entity_id"],
            'filename' => $userContent["filename"],
            'file_type' => $userContent["file_type"],
            'file_path' => $userContent["file_path"],
            'full_path' => $userContent["full_path"],
            'raw_name' => $userContent["raw_name"],
            'original_name' => $userContent["original_name"],
            'client_name' => $userContent["client_name"],
            'file_extension' => $userContent["file_extension"],
            'filezise' => $userContent["filezise"],
            'is_image' => $userContent["is_image"],
            'image_widgth' => $userContent["image_widgth"],
            'image_height' => $userContent["image_height"],
            'image_type' => $userContent["image_type"],
            'image_size_string' => $userContent["image_size_string"],
            'created_by' => $userContent["created_by"],
            'created_on' => $userContent["created_on"],
            'private' => $userContent["private"],
            'password_protect' => $userContent["password_protect"],
            'mdf5_hash' => $userContent["mdf5_hash"]
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
    public function getUserContentitem($id) {
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
    public function getUserContentItems($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("created_on", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }

    public function getUserContentByIds($userId , $userContentIds){
        if ($userId == null) {
            return null;
        }
        if($userContentIds == null){
            return null;
        }
        $this->db->order_by("created_on", "desc");
        $this->db->where_in('id', $userContentIds);
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
    public function getUserContentByCriteria($userId = null, $limit = null, $offset = 0) {
        if (null != $userId) {
            $this->db->order_by("created_on", "desc");
            if ($this->input->post("keyword") != "") {
                $this->db->like("filename", $this->input->post("keyword"));
                $this->db->like("description", $this->input->post("keyword"));
            }
            if (null == $limit) {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'created_on >=' => $this->input->post("fromDate"), 'created_on <= ' => $this->input->post("toDate")));
            } else {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'created_on >=' => $this->input->post("fromDate"), 'created_on <= ' => $this->input->post("toDate")), $limit, $offset);
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
    public function getUserContentDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("created_on", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'created_on >=' => $startDate, 'created_on <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'created_on >=' => $startDate, 'created_on <= ' => $endDate), $limit, $offset);
        }
//        echo $this->db->last_query();
        return $query->result_array();
    }

     /**
      * Get expenses by date range, userId and expenseTypeId
      * @param type $startDate
      * @param type $endDate
      * @param type $userId
      * @param type $expenseTypeId
      * @return type
      */
    public function getbyDateRangeuserContentType($userId, $startDate, $endDate, $userContentType) {
        if ($userId === null) {
            return null;
        }
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'created_on >=' => $startDate, 'created_on <= ' => $endDate, 'file_extension' => $userContentType ));
        return $query->result_array();
    }
}
