<?php
class Weather_data_model extends CI_Model {

    var $tn                 = "weather_data";
    var $hoursToExpiration  = 6; 

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    private function clearExpiredData($userId){
        $this->db->where("user_id", $userId);
        $this->db->where('expiration_date <', date('Y/m/d H:i'));
        $this->db->delete($this->tn);
    }
    
    public function getWeatherData($userId , $locationId=null, $expirationDate=null, $data_type=null){
        $this->clearExpiredData($userId);
        $whereArray = array('user_id' => $userId);
        if(null != $locationId){
            $whereArray["location_id"] = $locationId;
        }
        if(null != $expirationDate){
            $whereArray["expiration_date >="] =  $expirationDate;
        }
        if(null != $data_type){
            $whereArray["data_type"] =  $data_type;
        }
        $query = $this->db->get_where($this->tn, $whereArray);
        return $query->result();
    }
    
    public function save($userId , $locationId, $data, $data_type){
        $data = array(
            'user_id' => $userId,
            'location_id' => $locationId,
            'data' => $data,
            'data_type' => $data_type,
            'create_date' => date('Y/m/d H:i'),
            'expiration_date' => date('Y/m/d H:i', mktime(date("H") + $this->hoursToExpiration,date("i"),0 , date("m"),date("d"), date("Y")))
        );
        return $this->db->insert($this->tn, $data);
    }
    
    public function update($id, $userId , $locationId, $data){
        $data = array(
            'user_id' => $userId,
            'location_id' => $locationId,
            'data' => $data,
            'create_date' => date('Y/m/d H:i'),
            'expiration_date' => date('Y/m/d H:i', mktime(0,0,date("H") + $this->hoursToExpiration, date("m"),date("d", date("Y"))))
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tn, $data);
    }
    
}

