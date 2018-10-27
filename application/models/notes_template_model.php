<?php

class Notes_template_model extends CI_Model {

    var $tn = "notes_templates";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
//        $this->load->model("note_tag_model");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_note_template() {
        $this->load->helper('date');
        $this->load->library("session");
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'template_title' => $this->input->post('template_title'),
            'template_content' => $this->input->post('template_content'),
            'create_date' => date('Y/m/d H:i', strtotime($this->input->post('create_date')))
        );
//        echo $id = $this->db->insert($this->tn, $data);
//        $tags = explode(",", $this->input->post('tags'));
//        foreach($tags as $k=>$v){
//            echo $v;
//            $
//        }
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
    public function getNotesTemplate($user_id, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $user_id,'id' => $id));
        return $query->row();
    }

    /**
     * Get notes bases on certain criteria
     * @param type $userId if present return this users notes.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getNotesTemplates($userId = null, $limit = null, $offset = 0, $count = false) {
//        echo "userId: ".$userId." >> limit: ".$limit . " >> offset: ". $offset ." >> count: ". $count;
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("create_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId), $limit, $offset);
        }
//        echo $this->db->last_query();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }

    public function getNotesTempatesByIds($userId, $noteIds) {
        if ($userId == null) {
            return null;
        }
        if ($noteIds == null) {
            return null;
        }
        $this->db->order_by("create_date", "desc");
        $this->db->where_in('id', $noteIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }

    public function getTotalNumberOfNotesTemplatesForUser($userId, $dateFrom = null, $dateTo = null) {
        if ($dateFrom != null) {
            $this->db->where('create_date >=', $dateFrom);
        }
        if ($dateTo != null) {
            $this->db->where('create_date <=', $dateTo);
        }
        $this->db->where('user_id', $userId);
        $this->db->from($this->tn);
        return $this->db->count_all_results();
    }
    
    
    public function getNotesTemplatesForPeriod($userId = null, $dateFrom = null, $dateTo = null) {
        if ($dateFrom != null) {
            $this->db->where('create_date >=', $dateFrom);
        }
        if ($dateTo != null) {
            $this->db->where('create_date <=', $dateTo);
        }
        $this->db->order_by("create_date", "desc");
        $query = $this->db->get_where($this->tn, array('user_id' => $userId));
//        echo $this->db->last_query();
        return $query->result_array();
    }

    /**
     * Update the note, expects post and session data to be present.
     * @return type
     */
    public function update() {
        $note_template = $this->getNotesTemplate($this->session->userdata("user")->id, $this->input->post('id'));
        $updateCount = $note_template->update_count + 1;
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'template_title' => $this->input->post('template_title'),
            'template_content' => $this->input->post('template_content'),
            'create_date' => date('Y/m/d H:i', strtotime($this->input->post('create_date'))),
            'update_date' => date('Y/m/d H:i'),
            'update_count' => $updateCount
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }
}
