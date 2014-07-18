<?php

class timetable_model extends CI_Model {

    var $tn = "timetable";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function create_timetable() {
        print_r($this->input->post());
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'description' => $this->input->post('description'),
            'name' => $this->input->post('name'),
            'tt_category_id' => $this->input->post('timetableCategory'),
            'create_date' => date('Y/m/d H:i:s'),
            'all_day_event' => ($this->input->post("allDayEvent") == "1") ? 1 : 0,
            'duration' => date($this->input->post('endDate')) - date($this->input->post('startDate')),
            'start_date' => $this->input->post('startDate'),
            'end_date' => $this->input->post('endDate'),
            'repition_id' => 4,
            'expense_type_id' => $this->input->post('timetableExpenseType'),
            'location_id' => $this->input->post('timetableLocation'),
            'location_text'=> $this->input->post('locationText')
        );
        if($this->input->post('allDayEvent')){
            $data["start_date"] = date('Y/m/d', strtotime($this->input->post('startDate')));
            $data["end_date"] = date('Y/m/d H:i:s', 
                mktime(23, 59, 0, 
                    date('m', strtotime($this->input->post('endDate'))), 
                    date('d', strtotime($this->input->post('endDate'))), 
                    date('Y', strtotime($this->input->post('endDate')))));
        }
        if ($this->input->post('id') != "") {
            $data["update_date"] = date('Y/m/d H:i:s');
            $this->db->where('id', $this->input->post('id'));
            return $this->db->update($this->tn, $data);
        } else {
            return $this->db->insert($this->tn, $data);
        }
    }

    public function delete($locationId) {
        $this->db->where("id", $locationId);
        $this->db->delete($this->tn);
    }

    /**
     * 
     * @param type $userId
     * @param type $Id
     * @return type
     */
    public function doesItBelongToMe($userId, $id) {
        $query = $this->db->get_where($this->tn, array('user_id' => $userId, 'id' => $id));
        return $query->num_rows();
    }

    public function get_user_timetable_events($userId) {
        $this->db->order_by("start_date", "asc");
        $this->db->or_where("user_id =", $userId);
        $query = $this->db->get_where($this->tn);
        return $query->result();
    }

    public function get_user_timetable_event($userId, $id) {
        $this->db->or_where("user_id =", $userId);
        $query = $this->db->get_where($this->tn, array("id" => $id));
        return $query->result();
    }

}
