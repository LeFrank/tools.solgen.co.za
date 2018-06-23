<?php

/**
 * Description of health_metric_model
 *
 * @author francois
 */
class health_exercise_tracker_model extends CI_Model {

    var $tn = "health_exercise_tracker";


    
    
    public function capture_exercise() {
        $data = array(
            'description' => $this->input->post('description'),
            'start_date' => date('Y/m/d H:i', strtotime($this->input->post('exerciseStartDate'))),
            'end_date' => date('Y/m/d H:i', strtotime($this->input->post('exerciseEndDate'))),
            'exercise_type_id' => $this->input->post('exerciseType'),
            'measurement_value' => $this->input->post('measurement_value'),
            'distance' => $this->input->post('distance'),
            'difficulty' => $this->input->post('difficulty'),
            'created_date' => date('Y/m/d H:i:s'),
            'user_id' => $this->session->userdata("user")->id
        );
        return $this->db->insert($this->tn, $data);
    }

    public function doesItBelongToMe($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->num_rows();
    }
    
    public function isItGlobal($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => NULL, 'id' => $id));
        return $query->num_rows();
    }

    public function doesItExist($userId, $description) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'description' => $description));
        return $query->num_rows();
    }

    public function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tn);
    }
    
    public function delete_exercise($userId, $exerciseId){
        return $this->db->delete($this->tn, array('user_id' => $userId, 'id' => $exerciseId));
    }

    public function getUserExerciseById($userId,$id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId,'id' => $id));
        return $query->row();
    }

    public function get_expense_types() {
        $this->db->order_by("description", "asc");
        $query = $this->db->get_where($this->tn, array('enabled' => 1));
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
    public function getuserExercisesByDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("start_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date >=' => $startDate, 'end_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'start_date >=' => $startDate, 'end_date <= ' => $endDate), $limit, $offset);
        }
//        echo $this->db->last_query();
        return $query->result_array();
    }
    

    public function deleteUserData($userId) {
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }

    public function update() {
        $data = array(
            'description' => $this->input->post('description'),
            'start_date' => date('Y/m/d H:i', strtotime($this->input->post('exerciseStartDate'))),
            'end_date' => date('Y/m/d H:i', strtotime($this->input->post('exerciseEndDate'))),
            'exercise_type_id' => $this->input->post('exerciseType'),
            'measurement_value' => $this->input->post('measurement_value'),
            'distance' => $this->input->post('distance'),
            'difficulty' => $this->input->post('difficulty'),
            'update_date' => date('Y/m/d H:i:s')
        );
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }
}