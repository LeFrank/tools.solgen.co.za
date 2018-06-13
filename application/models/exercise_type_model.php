<?php
/**
 * Description of health_metric_model
 *
 * @author francois
 */
class exercise_type_model extends CI_Model {

    var $tn = "exercise_type";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_exercise_type() {
        $this->load->helper('date');
        $this->load->library("session");
//        $date = ($this->input->post('metricDate') != "") ? date('Y/m/d H:i', strtotime($this->input->post('metricDate'))): date('Y/m/d H:i');
//        $data = array(
//            'measurement_date' => $date,
//            'weight'    => $this->input->post('weight'),
//            'waist'     => $this->input->post('waist'),
//            'sleep'     => $this->input->post('sleep'),
//            'user_id'   => $this->session->userdata("user")->id,
//            'note'      => $this->input->post('note'),
//        );
//        return $this->db->insert($this->tn, $data);
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
    
    public function get_user_exercise_types($userId) {
        $this->db->order_by("name", "asc");
        $this->db->or_where("user_id =", $userId);
        $this->db->or_where("user_id is null");
        $query = $this->db->get_where($this->tn);
        //print "SQL Query: ".$this->db->last_query(); 
        return $query->result_array();
    }
    
}