<?php

class Notes_search_model extends CI_Model {

    var $tn = "notes_search";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture note search parameters 
     * @return type
     */
    public function capture_note_search() {
        $this->load->helper('date');
        $this->load->library("session");
        print_r(($this->input->post('fromDate') == "") ? "is Empty" :"Has Value");
        $query = $this->db->get_where($this->tn, 
            array(
                'user_id' => $this->session->userdata("user")->id, 
                'text' => $this->input->post("searchText"), 
                'start_date' => (($this->input->post('fromDate') == "") ? "0000-00-00 00:00:00" : date('Y/m/d H:i', strtotime($this->input->post('fromDate')))),
                'end_date' => (($this->input->post('toDate') == "") ? "0000-00-00 00:00:00" : date('Y/m/d H:i', strtotime($this->input->post('toDate'))))
                ));
        if($query->num_rows() > 0){
            $res = $query->result_array();
            $this->updateReSearchCount($res[0]["id"]);
            return $res[0]["id"];
        }else{
            $data = array(
                'user_id' => $this->session->userdata("user")->id,
                'text' => $this->input->post("searchText"),
                'start_date' => (($this->input->post('fromDate') == "") ? "0000-00-00 00:00:00" : date('Y/m/d H:i', strtotime($this->input->post('fromDate')))),
                'end_date' => (($this->input->post('toDate') == "") ? "0000-00-00 00:00:00" : date('Y/m/d H:i', strtotime($this->input->post('toDate')))),
                'create_date' => date('Y/m/d H:i')
            );
            $this->db->insert($this->tn, $data);
            return $this->db->insert_id();
        }
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
     * Get notes bases on certain criteria
     * @param type $userId if present return this users notes.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getSearches($userId = null, $limit = null, $offset = 0, $count = false) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("re_search_count", "desc");
        $this->db->order_by("create_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }

    public function getSearchById($user_id, $searchId) {
        if ($user_id == null) {
            return null;
        }
        if ($searchId == null) {
            return null;
        }
        $this->db->order_by("create_date", "desc");
        $this->db->where_in('id', $searchId);
        $query = $this->db->get_where($this->tn, array('user_id' => $user_id), 100);
        return $query->result_array();
    }
    
    public function updateReSearchCount($searchId){
        $this->db->where('id',$searchId);
        $this->db->set('re_search_count', 're_search_count+1', FALSE);
        $this->db->update($this->tn);
    }

}
