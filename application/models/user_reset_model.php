<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_reset_model extends CI_Model {

    var $tn = "user_reset";

    public function __construct() {
        $this->load->database();
        date_default_timezone_set('Africa/Johannesburg');
    }

    // create a reset token
    public function create($userId, $token) {
        $data = array(
            'user_id' => $userId,
            'token' => $token,
            'creation_date' => date('Y/m/d H:i', mktime()),
            'expiration_date' => mktime(0, 0, 0, date("m"), date("d") + 2, date("Y")),
            'was_reset' => FALSE
        );
        $this->db->insert($this->tn, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    // get reset token
    /**
     * 
     * @param type $id
     * @param type $userId
     * @param type $token
     * @return type
     */
    public function get_user_reset($id = null, $userId = null, $token = null) {
        if (null != $id) {
            $this->db->where('id', $id);
        }
        if (null != $userId) {
            $this->db->where('user_id', $userId);
        }
        if (null != $token) {
            $this->db->where('token', $token);
        }
        if (null != $id || null != $userId || null != $token) {
            $query = $this->db->get_where($this->tn, array('was_reset' => FALSE));
//            print "SQL Query: " . $this->db->last_query();
            return $query->result_array();
        }
    }

    // delete reset token
    // update reset token
    public function was_reset($id, $wasResetStatus) {
        $data = array(
            "was_reset" => $wasResetStatus
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tn, $data);
    }

    public function deleteUserData($userId) {
        $this->db->where("user_id", $userId);
        $this->db->delete($this->tn);
    }

}
