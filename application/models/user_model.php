<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_model extends CI_Model {

    var $tn = "solgen_user";

    public function __construct() {
        $this->load->database();
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function get_admin_data(){
        $data["user_count"] = $this->db->count_all($this->tn);
        $limit=1;
        $offset=0;
//        $this->db->order_by("create_date", "desc");
        $query = $this->db->query("SELECT firstname, create_date FROM ".$this->tn." order by create_date desc limit 1");
        $data["last_created_user"] = $query->row();
        return $data;
    }
    
    public function get_user($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get($this->tn);
            return $query->result_array();
        }
        $query = $this->db->get_where($this->tn, array('id' => $id));
        return $query->row();
    }

    public function get_user_id_by_email($email) {
        $query = $this->db->get_where($this->tn, array('email' => $email));
        return $query->row();
    }

    public function login($email, $password) {

        $query = $this->db->get_where($this->tn, array('email' => $email, 'password' => hash("sha256", trim($password))));
        return $query->row();
    }

    public function set_user() {
        $this->load->helper('date');

        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'password' => hash("sha256", trim($this->input->post('password'))),
            'user_type' => 'user',
            'create_date' => date('Y/m/d H:i:s'),
            'active' => TRUE
        );
        return $this->db->insert($this->tn, $data);
        // return $this->db->insert_id();
    }

    public function updateLastLogin($id) {
        $this->load->helper('date');
        $user = $this->get_user($id);
        $user->last_login = date('Y/m/d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->tn, $user);
    }

    public function update_password($id, $password) {
        $data = array(
            "password" => hash("sha256", trim($password))
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tn, $data);
    }

    public function disable_user($id) {
        $this->db->where('id', $id);
        $this->db->update($this->tn, array('active' => FALSE));
        return true;
    }

    public function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tn);
    }

    public function update($user){
        $this->db->where('id', $user->id);
        return $this->db->update($this->tn, $user);
    }
}
