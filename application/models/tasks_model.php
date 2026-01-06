<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tasks_model extends CI_Model {

    var $tn = "tasks";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    /**
     * Capture a users task from a post request. 
     * @return type
     */
    public function capture_task() {
        $this->load->helper('date');
        $this->load->library("session");
        $date = ($this->input->post('start_date') != "") ? date('Y/m/d H:i', strtotime($this->input->post('start_date'))): date('Y/m/d H:i');
        $data = array(
            'name' => $this->input->post('name'),
            'domain_id' => $this->input->post('domain_id'),
            'description' => $this->input->post('description'),
            'status_id' => $this->input->post('status'),
            'start_date' => date('Y/m/d H:i', strtotime($this->input->post('start_date'))),
            'end_date' => date('Y/m/d H:i', strtotime($this->input->post('end_date'))),
            'target_date' => date('Y/m/d H:i', strtotime($this->input->post('target_date'))),
            'user_id' => $this->session->userdata("user")->id,
            'importance_level_id' => $this->input->post('importance_level_id'),
            'urgency_level_id' => $this->input->post('urgency_level_id'),
            'risk_level_id' => $this->input->post('risk_level_id'),
            'gain_level_id' => $this->input->post('gain_level_id'),
            'reward_category_id' => $this->input->post('reward_category_id'),
            'cycle_id' => $this->input->post('cycle_id'),
            'scale_id' => $this->input->post('scale_id'),
            'scope_id' => $this->input->post('scope_id'),
            'difficulty_level_id' => $this->input->post('difficulty_level_id')
        );
        $this->db->insert($this->tn, $data);
        return $this->db->insert_id();
    }

    /**
     * Get tasks bases on certain criteria
     * @param type $userId if present return this users expenses.
     * @param type $limit if preset return a limited result set
     * @param type $offset if present offset the result by this value else no offset
     * @return null
     */
    public function getTasks($userId = null, $limit = null, $offset = 0) {
        if ($userId === null) {
            return null;
        }
        $this->db->order_by("create_date", "desc");
        // $this->db->join('user_content', 'user_content.tool_entity_id = expense.id', 'LEFT');
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('tasks.user_id' => $userId));
        } else {
            $query = $this->db->get_where($this->tn, array('tasks.user_id' => $userId), $limit, $offset);
        }

        return $query->result_array();
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
    public function getTask($id) {
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }


    /**
     * Get tasks by date range. Can be filtered by user and delimited
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
    public function getTasksByDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("create_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'create_date >=' => $startDate, 'create_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'create_date >=' => $startDate, 'create_date <= ' => $endDate), $limit, $offset);
        }
    //    echo $this->db->last_query();
        return $query->result_array();
    }


    /**
     * Get tasks by date range. Can be filtered by user and delimited
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
    public function getActiveTasks( $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        $month = date('m');
        $year = date('Y');
        $return[0] = date('Y/m/d H:i',mktime(0, 0, 0, $month, 1,   $year));
        $return[1] = date('Y/m/d H:i',mktime(23, 59, 0, $month+1, 1-1,   $year));
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("create_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            // $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'target_date >=' => $startDate, 'target_date <= ' => $endDate));
            $query = $this->db->get_where(
                $this->tn, 
                array(
                    'user_id' => $userId, 
                    'start_date <=' => date('Y/m/d H:i'), 
                    'target_date >= ' => date('Y/m/d H:i'),
                    // 'start_date >=' => $return[0],
                    // 'start_date <= ' => $return[1],
                    'target_date >=' => $return[0],
                    'target_date <= ' => $return[1]
                    )
                );
        } else {
            $query = $this->db->get_where(
                $this->tn, 
                array(
                        'user_id' => $userId, 
                        'start_date >=' => $startDate, 
                        'target_date <= ' => $endDate, 
                        // 'start_date >=' => $return[0],
                        // 'start_date <= ' => $return[1],
                        'target_date >=' => $return[0],
                        'target_date <= ' => $return[1],
                        $limit, 
                        $offset
                )
            );
        }
    //    echo $this->db->last_query();
        return $query->result_array();
    }

    /**
     * 
     * @param type $userId
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getTasksByCriteria($userId = null, $limit = null, $offset = 0) {
        if (null != $userId) {
            $this->db->order_by("start_date", "desc");
            // if ($this->input->post("fromAmount") != $this->input->post("toAmount")) {
            //     $this->db->where("amount >=", $this->input->post("fromAmount"));
            //     $this->db->where("amount <=", $this->input->post("toAmount"));
            // }
            if ($this->input->post("keyword") != "") {
                $this->db->like("description", $this->input->post("keyword"));
            }
            $tasksDomainArr = $this->input->post("tasksDomains");
            $tasksStatusdArr = $this->input->post("tasksStatuses");
            
            $FilterDateField = "start_date";
            if($this->input->post("date_filter") == "create_date"){
                $FilterDateField = "create_date";
            }else if($this->input->post("date_filter") == "target_date"){
                $FilterDateField = "target_date";
            }                       

            if (!empty($tasksDomainArr) && $tasksDomainArr[0] != "all") {
                $this->db->where_in("domain_id", array_map('intval', $tasksDomainArr));
            }
            if (!empty($tasksStatusdArr) && $tasksStatusdArr[0] != "all") {
                $this->db->where_in("status_id", array_map('intval', $tasksStatusdArr));
            }
            if (null == $limit) {
                if($FilterDateField == "create_date")
                {
                    $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'create_date >=' => $this->input->post("fromDate"), 'create_date <= ' => $this->input->post("toDate")));
                }
                else if($FilterDateField == "target_date")
                {
                    $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'target_date >=' => $this->input->post("fromDate"), 'target_date <= ' => $this->input->post("toDate")));
                }
                else{
                    $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date >=' => $this->input->post("fromDate"), 'start_date <= ' => $this->input->post("toDate")));
                }
            } else {
                if($FilterDateField == "create_date")
                {
                    $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'create_date >=' => $this->input->post("fromDate"), 'create_date <= ' => $this->input->post("toDate")), $limit, $offset);
                }
                else if($FilterDateField == "target_date")
                {
                    $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'target_date >=' => $this->input->post("fromDate"), 'target_date <= ' => $this->input->post("toDate")), $limit, $offset);
                }
                else{
                    $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date >=' => $this->input->post("fromDate"), 'start_date <= ' => $this->input->post("toDate")), $limit, $offset);
                }
            }
            // echo $this->db->last_query();
            return $query->result_array();
        }
    }

    public function getTasksPastStartDate($userId = null, $currentDate = null, $statuses = array(), $limit = null, $offset = 0) {
        if (null != $userId) {
            $this->db->order_by("start_date", "asc");
            if (!empty($statuses)) {
                $this->db->where_in("status_id", array_map('intval', $statuses));
            }
            if (null == $limit) {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date <=' => $currentDate));
            } else {
                $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date <=' => $currentDate), $limit, $offset);
            }
            // echo $this->db->last_query();
            return $query->result_array();
        }
    }


    /**
     * 
     * @return type
     */
    public function update() {
        $data = array(
            'name' => $this->input->post('name'),
            'domain_id' => $this->input->post('domain_id'),
            'description' => $this->input->post('description'),
            'status_id' => $this->input->post('status'),
            'start_date' => date('Y/m/d H:i', strtotime($this->input->post('start_date'))),
            'end_date' => date('Y/m/d H:i', strtotime($this->input->post('end_date'))),
            'target_date' => date('Y/m/d H:i', strtotime($this->input->post('target_date'))),
            'user_id' => $this->session->userdata("user")->id,
            'importance_level_id' => $this->input->post('importance_level_id'),
            'urgency_level_id' => $this->input->post('urgency_level_id'),
            'risk_level_id' => $this->input->post('risk_level_id'),
            'gain_level_id' => $this->input->post('gain_level_id'),
            'reward_category_id' => $this->input->post('reward_category_id'),
            'cycle_id' => $this->input->post('cycle_id'),
            'scale_id' => $this->input->post('scale_id'),
            'scope_id' => $this->input->post('scope_id'),
            'difficulty_level_id' => $this->input->post('difficulty_level_id')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }

    /**
     * markAsDone
     * @param type $id
     */
    public function markAsDone($id){
        $data = array(
            'status_id' => 2,
            'end_date' => date('Y/m/d H:i')
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tn, $data);
    }

    /**
     * markAsUnDone
     * @param type $id
     */
    public function markAsUnDone($id){
        $data = array(
            'status_id' => 4
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tn, $data);
    }
}
