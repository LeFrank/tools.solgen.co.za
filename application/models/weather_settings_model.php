<?php
/**
 * Description of weather_setting_model
 */
class weather_settings_model extends CI_Model{
    var $tn                 = "weather_settings";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    public function getSetting($userId){
        $query = $this->db->get_where($this->tn, array("user_id" =>$userId));
        return $query->row();
    } 
    
    public function setMeasurement($userId , $measurement){
        $this->load->helper('date');
        $weatherSetting = $this->getSetting($userId);
        if(null == $weatherSetting){
            $data = array(
                "user_id" => $userId,
                "measurement" => $measurement,
                "create_date" => date('Y/m/d H:i:s')
            );
            return $this->db->insert($this->tn, $data);
        }else{
            $data["measurement"] = $measurement;
            $data["update_date"] = date('Y/m/d H:i:s');
            $this->db->where('id', $weatherSetting[0]->id);
            return $this->db->update($this->tn, $data);
        }

    }
}
