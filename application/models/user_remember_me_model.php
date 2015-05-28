<?php

class User_remember_me_model extends CI_Model {

    var $tn = "user_remember_me";
    
    
    //create
    public function create($user){
        $this->load->helper('date');
        //get where user_id = $user->id;
        $remMRow = $this->getUserSeries($user->id);
        if(null == $remMRow){
            $id = 1;
        }else{
            $id = $remMRow->series_id++;
        }
        $expirationDate = date('Y/m/d H:i:s',mktime(0,0,0,date("m"), date("d")+7,date("Y")));
        $data = array(
            'user_id' => $user->id,
            'series_id' => $id,
            'expiration_date' => $expirationDate,
            'active' => 1,
            'create_date' => date('Y/m/d H:i:s'),
            'hash' => hash("sha256", $user->email."|".$expirationDate)
        );
        $this->db->insert($this->tn, $data);
        return $this->db->insert_id();
    }
    
    public function getRememberMe($id){
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }
    
    private function getUserSeries($userId){
        $this->db->order_by("series_id", "desc"); 
        $this->db->limit(1);
        $query = $this->db->get_where($this->tn, array('user_id' => $userId));
        return $query->row();
    }
    
    //update
    
    //read
    
    //delete
    
    
}
