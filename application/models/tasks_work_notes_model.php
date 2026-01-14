<?php

class Tasks_work_notes_model extends CI_Model {

    var $tn = "tasks_work_notes";

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
    public function capture_work_note() {
        $this->load->helper('date');
        $this->load->library("session");
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'task_id' => $this->input->post('task_id'),
            'work_note' => $this->input->post('work_note'),
            'create_date' => date('Y/m/d H:i', strtotime($this->input->post('note_work_date')))
        );
        return $this->db->insert($this->tn, $data);
    }

    public function createWorkNote($user_id, $tasks_id, $work_note){
        $data = array(
            'user_id' => $user_id,
            'task_id' => $tasks_id,
            'work_note' => $work_note,
            'create_date' => date('Y/m/d H:i', strtotime(date("Y-m-d H:i:s")))
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

    public function deleteWorkNoteByTaskId($id, $taskId) {
        $this->db->where(array("id" => $id, "task_id" => $taskId));
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
    public function getTasksWorkNote($user_id, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $user_id,'id' => $id));
        return $query->row();
    }

    public function getTasksWorkNoteByTaskId($user_id, $id, $taskId) {
        $query = $this->db->get_where($this->tn, array('user_id' => $user_id,'id' => $id, 'task_id' => $taskId));
        return $query->row();
    }

    /**
     * Get notes bases on certain criteria
     * @param type $userId if present return this users notes.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getTasksWorkNotesByTaskId($userId = null, $taskId = null, $limit = null, $offset = 0, $count = false) {
//        echo "userId: ".$userId." >> limit: ".$limit . " >> offset: ". $offset ." >> count: ". $count;
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("create_date", "desc");
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'task_id' => $taskId));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'task_id' => $taskId), $limit, $offset);
        }
//        echo $this->db->last_query();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }

    public function getTasksWorkNotesByIds($userId, $WorkNoteIds) {
        if ($userId == null) {
            return null;
        }
        if ($WorkNoteIds == null) {
            return null;
        }
        $this->db->order_by("create_date", "desc");
        $this->db->where_in('id', $WorkNoteIds);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        return $query->result_array();
    }


    public function getTotalNumberOfTasksWorkNotesForUser($userId, $dateFrom = null, $dateTo = null) {
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


    public function getTasksWorkNotesForPeriod($userId = null, $dateFrom = null, $dateTo = null) {
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

    public function searchTasksWorkNotes($userId = null, $limit = null, $offset = 0, $count = false) {
        if ($userId == null) {
            return null;
        }
        if ($this->input->post("fromDate") != "") {
            $fromDate = date('Y/m/d H:i', strtotime($this->input->post('fromDate')));
            $this->db->where('create_date >= ', $fromDate);
        }
        if ($this->input->post("toDate") != "") {
            $toDate = date('Y/m/d H:i', strtotime($this->input->post('toDate')));
            $this->db->where('create_date <= ', $toDate);
        }
        $this->db->order_by("create_date", "desc");
        if ($this->input->post("searchText") != "") {
            $search = $this->input->post("searchText");
            $this->db->or_like('work_note', $search);
        }
        $query = $this->db->get_where($this->tn, array('user_id' => $userId), 100);
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }

    public function searchTasksWorkNotesCriteria($userId = null, $limit = null, $offset = 0, $count = false , $text= null, $start_date = null, $end_date = null){
       if ($userId == null) {
            return null;
        }
//        print_r(array($start_date, $end_date));
        if ($start_date != "") {
            $fromDate = date('Y/m/d H:i', strtotime($start_date));
            $this->db->where('create_date >= ', $fromDate);
        }
        if ($end_date != "") {
            $toDate = date('Y/m/d H:i', strtotime($end_date));
            $this->db->where('create_date <= ', $toDate);
        }
        $this->db->order_by("create_date", "desc");
        if ($text != null) {
            // $where = "(heading like '%".$text."%' or body like '%".$text."%' or tagg like '%".$text."%')";
//            $this->db->or_like('heading', $text);
//            $this->db->or_like('body', $text);
//            $this->db->or_like('tagg', $text);
            $this->db->or_like('work_note', $search);
            // $this->db->where($where);
        }
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

    /**
     * Update the note, expects post and session data to be present.
     * @return type
     */
    public function update() {
        $note = $this->getTasksWorkNote($this->session->userdata("user")->id, $this->input->post('tasks_work_note_id'));
        // $updateCount = $note->update_count + 1;
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'task_id' => $this->input->post('task_id'),
            'work_note' => $this->input->post('work_note'),
            'update_date' => date('Y/m/d H:i')
            // ,            'update_count' => $updateCount
        );
//        print_r($data);
//        exit;
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }


    public function updateWorkNote($work_note_id, $work_note){
        $note = $this->getTasksWorkNote($this->session->userdata("user")->id, $work_note_id);
        // $updateCount = $note->update_count + 1;
        $data = array(
            'work_note' => $work_note,
            'update_date' => date('Y/m/d H:i')
            // ,'update_count' => $updateCount
        );
        $this->db->where(array('user_id' => $this->session->userdata("user")->id, 'id' => $work_note_id));
        return $this->db->update($this->tn, $data);
    }
}