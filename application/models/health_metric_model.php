<?php
/**
 * Description of health_metric_model
 *
 * @author francois
 */
class health_metric_model extends CI_Model {

    var $tn = "health_metric";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_metric() {
        $this->load->helper('date');
        $this->load->library("session");
        $date = ($this->input->post('metricDate') != "") ? date('Y/m/d H:i', strtotime($this->input->post('metricDate'))): date('Y/m/d H:i');
        $data = array(
            'measurement_date' => $date,
            'weight'    => $this->input->post('weight'),
            'waist'     => $this->input->post('waist'),
            'sleep'     => $this->input->post('sleep'),
            'user_id'   => $this->session->userdata("user")->id,
            'note'      => $this->input->post('note'),
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
    public function getHealthMetricByDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
        if(null != $orderBy){
            $this->db->order_by($orderBy, $direction);
        }else{
            $this->db->order_by("measurement_date", "desc");
        }
        if ($userId === null) {
            return null;
        }
        if (null == $limit) {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'measurement_date >=' => $startDate, 'measurement_date <= ' => $endDate));
        } else {
            $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'measurement_date >=' => $startDate, 'measurement_date <= ' => $endDate), $limit, $offset);
        }
//        echo $this->db->last_query();
        return $query->result_array();
    }
    
}