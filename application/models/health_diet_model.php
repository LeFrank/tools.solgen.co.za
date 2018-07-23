<?php
/**
 * Description of health_metric_model
 *
 * @author francois
 */
class health_diet_model extends CI_Model {

    var $tn = "health_diet_items";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    /**
     * Capture a users expense from a post request. 
     * @return type
     */
    public function capture_diet_item() {
        $this->load->helper('date');
        $this->load->library("session");
        $date = ($this->input->post('consumptionDate') != "") ? date('Y/m/d H:i', strtotime($this->input->post('consumptionDate'))): date('Y/m/d H:i');
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'create_date' => $date,
            'intake_type' => $this->input->post('intakeType'),
            'measurement' => $this->input->post('measurement_value'),
            'deliciousness' => $this->input->post('deliciousness'),
            'healthiness' => $this->input->post('healthiness'),
            'description' => $this->input->post('description'),
        );
        return $this->db->insert($this->tn, $data);
    }
    
    /**
     * 
     * @param type $id
     */
    public function delete_item($userId, $id) {
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
    
    public function getUserItemById($userId, $id) {
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
    public function getHealthDietItemsByDateRange($startDate, $endDate, $userId = null, $limit = null, $offset = 0 , $orderBy=null, $direction = "asc") {
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
            'create_date' => $this->input->post('consumptionDate'),
            'intake_type' => $this->input->post('intakeType'),
            'measurement' => $this->input->post('measurement_value'),
            'deliciousness' => $this->input->post('deliciousness'),
            'healthiness' => $this->input->post('healthiness'),
            'description' => $this->input->post('description'),
        );
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($this->tn, $data);
    }
}