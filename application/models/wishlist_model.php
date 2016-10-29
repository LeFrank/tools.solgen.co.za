<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wishlist_item_model
 *
 * @author francois
 */
class wishlist_model extends CI_Model {

    var $tn = "wishlist";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }
    
    
    public function capture_item(){
        $this->load->helper('date');
        $this->load->library("session");
        $date = ($this->input->post('targetDate') != "") ? date('Y/m/d H:i', strtotime($this->input->post('targetDate'))): date('Y/m/d H:i');
        $data = array(
            'name' => $this->input->post('name'),
            'cost' => $this->input->post('cost'),
            'description' => $this->input->post('description'),
            'reason' => $this->input->post('reason'),
            'priority' => $this->input->post('priority'),
            'target_date' => $date,
            'user_id' => $this->session->userdata("user")->id,
            'creation_date' => date('Y/m/d H:i')
        );
        return $this->db->insert($this->tn, $data);
    }

}
