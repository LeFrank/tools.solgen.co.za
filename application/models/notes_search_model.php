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
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'text' => $this->input->post("searchText"),
            'start_date' => date('Y/m/d H:i', strtotime($this->input->post('fromDate'))),
            'end_date' => date('Y/m/d H:i', strtotime($this->input->post('toDate'))),
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
}
