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
            'description' => $userContent["description"],
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
    public function deleteItem($userId, $id) {
        if($this->doesItBelongToMe($userId, $id) > 0 ){
            $item = $this->getUserContentitem($userId, $id);
            $this->db->where("id", $id);
            $this->db->where("user_id", $userId);
            if($this->db->delete($this->tn)){
                $data["status"] = "Success";
                $data["message"] = "This resource has been deleted.";
                $data["description"] =  $item->original_name . " has been deleted.";
                $data["affectedRows"] = $this->db->affected_rows();
            }else{
                $data["status"] = "Failure";
                $data["message"] = "Unable to delete the resource: " .$this->db->_error_message();
                $data["description"] =  $item->original_name . " has not been deleted.";
                $data["affectedRows"] = $this->db->affected_rows();
            }
            
        }else{
            $data["status"] = "Failure";
            $data["message"] = "This resource does not belong to you!";
            $data["description"] =  "Do not attempt to delete data which does not belong to you. Repeated attempts to cause malicious damage will result in your account being deleted.";
            $data["affectedRows"] = 0;
        }
        return $data;
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
    public function getUserContentitem($userId, $id) {
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
    public function getUserContentItems($userId = null, $limit = null, $offset = 0, $count = false) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("created_on", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
//        return $query->result_array();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
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
    
    public function getUserContentStats($userId){
        /*
         * Global for User, general
         */
        $this->db->start_cache();
        $this->db->where("user_id", $userId);
        $this->db->from($this->tn);
        $this->db->stop_cache();
        $stats["total_count"] = $this->db->count_all_results();
        $this->db->flush_cache();
        
        $this->db->start_cache();
//        echo "Total Files: ".$stats["total_count"] . "<br/>";
        $this->db->select_sum('filezise');
        $query = $this->db->get_where($this->tn,array('user_id'=> $userId));
        $this->db->stop_cache();
        $stats["total_filesizes"] = $query->row()->filezise;
        $this->db->flush_cache();
//        echo "Total Files for All Users: ".$stats["total_filesizes"]. "<br/>";
        /*
         * tool Specific
         */
        $this->db->start_cache();
        $this->db->select('count(*) as "file_count", sum(filezise) as "file_size", tool_id');
        $this->db->group_by('tool_id'); 
        $this->db->order_by('file_size', 'desc'); 
        $query = $this->db->get_where($this->tn,array('user_id'=> $userId));
        $this->db->stop_cache();
        $stats["total_for_user_per_tool"] = $query->result_array();
        $this->db->flush_cache();

        return($stats);
    }
    
    public function uploadContent(
        $userId, 
        $allowedFileTypes, 
        $toolId=0, 
        $maxSize=100000000, 
        $private=1, 
        $passwordProtect=1, 
        $description="",
        $toolEntityId = 0
            
    ){
        $config['upload_path'] = './user_content/' . $userId . '/' . date('Y') . '/' . date('m') . '/' . date('d');
        if (!file_exists($config['upload_path'])) {
            if (mkdir($config['upload_path'], 0755, true)) {
                // echo "Folder created successfully";
            } else {
                // echo "Folder unable to be created";
            }
        }
        $config['allowed_types'] = $allowedFileTypes;
        $config['max_size'] = $maxSize;
//        $config['max_width'] = 1024;
//        $config['max_height'] = 768;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            return array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
            // print_r($data['upload_data']);
            //Write to db
            $this->load->helper('date');
            $date = date('Y/m/d H:i');
            $userContent["tool_id"] = $this->toolId;
            $userContent["user_id"] = $userId;
            $userContent["tool_entity_id"] = $toolEntityId;
            $userContent["filename"] = $data['upload_data']["file_name"];
            $userContent["description"] = $description;
            $userContent["filezise"] = $data['upload_data']["file_size"];
            $userContent["file_type"] = $data['upload_data']["file_type"];
            $userContent["file_path"] = $data['upload_data']["file_path"];
            $userContent["full_path"] = trim($data['upload_data']["full_path"]);
            $userContent["raw_name"] = $data['upload_data']["raw_name"];
            $userContent["original_name"] = $data['upload_data']["orig_name"];
            $userContent["client_name"] = $data['upload_data']["client_name"];
            $userContent["file_extension"] = $data['upload_data']["file_ext"];
            $userContent["is_image"] = (empty($data['upload_data']["is_image"])) ? 0 : 1;
            $userContent["image_widgth"] = (empty($data['upload_data']["image_width"])) ? 0 : 1;
            $userContent["image_height"] = (empty($data['upload_data']["image_height"])) ? 0 : 1;
            $userContent["image_type"] = $data['upload_data']["image_type"];
            $userContent["image_size_string"] = $data['upload_data']["image_size_str"];
            $userContent["created_by"] = $userId;
            $userContent["created_on"] = $date;
            $userContent["private"] = $private;
            $userContent["password_protect"] = $passwordProtect;
            $userContent["mdf5_hash"] = md5_file($userContent["full_path"]);
            $userContent["id"] = $this->capture_user_content($userContent);
            chmod($userContent["full_path"], 0755 );
            return $userContent;
        }
    }


    public function getUserContentByToolData($userId , $toolId, $toolEntityId){
        if ($userId == null) {
            return null;
        }
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'tool_id' => $toolId, 'tool_entity_id' => $toolEntityId), 100);
        return $query->result_array();
    }
}
