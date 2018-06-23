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
        $weight = ($this->input->post('weight') != 0 )?$this->input->post('weight') : NULL;
        $waist = ($this->input->post('waist') != 0 )?$this->input->post('waist') : NULL;
        $sleep = ($this->input->post('sleep') != 0 )?$this->input->post('sleep') : NULL;
        $data = array(
            'measurement_date' => $date,
            'weight'    => $weight,
            'waist'     => $waist,
            'sleep'     => $sleep,
            'user_id'   => $this->session->userdata("user")->id,
            'note'      => $this->input->post('note'),
        );
        return $this->db->insert($this->tn, $data);
    }
    
    /**
     * 
     * @param type $id
     */
    public function delete_metric($userId, $id) {
        return $this->db->delete($this->tn, array('user_id' => $userId, 'id' => $id));
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
    
    public function getUserMetricById($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->row();
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
    
    
    public function getOverallUserStatsByDateRange($startDate, $endDate, $userId = null) {
        $sql = 
        "SELECT 
            count(*) as `total_captured`, 
            avg(weight) as `average_weight`, 
            min(weight) as `minimum_weight`, 
            max(weight) as `maximum_weight`, 
            avg(waist) as `average_waist`, 
            min(waist) as `minimum_waist`, 
            max(waist) as `maximum_waist`, 
            avg(sleep)  as `average_sleep`,
            min(sleep)  as `minimum_sleep`, 
            max(sleep)  as `maximum_sleep`
        FROM 
            ".$this->tn."
        WHERE
            user_id = ".$userId."
            AND measurement_date between ? and ?";
        return $this->db->query($sql, array( $startDate, $endDate))->row();
//        return $query->row();
    }
    
    public function update() {
        $data = array(
            'measurement_date' => $this->input->post('metricDate'),
            'weight'    => $this->input->post('weight'),
            'waist'     => $this->input->post('waist'),
            'sleep'     => $this->input->post('sleep'),
            'note'      => $this->input->post('note'),
            'update_date' => date('Y/m/d H:i:s')
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }
}