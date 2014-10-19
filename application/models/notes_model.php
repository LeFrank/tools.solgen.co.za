<?php

class Notes_model extends CI_Model
{
    
    var $tn = "notes";
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    	$this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_note() {
        $this->load->helper('date');
        $this->load->library("session");
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'heading' => $this->input->post('title'),
            'body' => $this->input->post('body'),
            'tagg' => $this->input->post('tags'),
            'create_date' =>  date('Y/m/d H:i', strtotime($this->input->post('noteDate')))
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
    public function getNote($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    /**
     * Get notes bases on certain criteria
     * @param type $userId if present return this users notes.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getNotes($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("create_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
        return $query->result_array();
    }

    public function getNotesByIds($userId , $noteIds){
        if ($userId == null) {
            return null;
        }
        if($noteIds == null){
            return null;
        }
        $this->db->order_by("create_date", "desc");
        $this->db->where_in('id', $noteIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }
    
    /**
     * 
     * @return type
     */
    public function update() {
        $updateCount = $this->getNote($this->input->post('id'))->update_count + 1;
        echo $updateCount;
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'heading' => $this->input->post('title'),
            'body' => $this->input->post('body'),
            'tagg' => $this->input->post('tags'),
            'create_date' =>  date('Y/m/d H:i', strtotime($this->input->post('noteDate'))),
            'update_date' => date('Y/m/d H:i'),
            'update_count' => $updateCount
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }
}