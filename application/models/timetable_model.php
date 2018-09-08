<?php

class timetable_model extends CI_Model {

    var $tn = "timetable";

    public function __construct() {
        $this->load->database();
        $this->load->library("session");
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function create_timetable() {
        $startdate = ($this->input->post('startDate') != "") ? $this->input->post('startDate'): date('Y/m/d H:i');
        $enddate = ($this->input->post('endDate') != "") ? $this->input->post('endDate'): date('Y/m/d H:i');
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'description' => $this->input->post('description'),
            'name' => $this->input->post('name'),
            'tt_category_id' => $this->input->post('timetableCategory'),
            'create_date' => date('Y/m/d H:i:s'),
            'all_day_event' => ($this->input->post("allDayEvent") == "1") ? 1 : 0,
            'duration' => 0,
            'start_date' => $startdate,
            'end_date' => $enddate,
            'repition_id' => $this->input->post('timetableRepetition'),
            'expense_type_id' => $this->input->post('timetableExpenseType'),
            'location_id' => $this->input->post('locationId'),
            'location_text' => $this->input->post('location')
        );
        if ($this->input->post('allDayEvent')) {
            $data["start_date"] = date('Y/m/d', strtotime($this->input->post('startDate')));
            $data["end_date"] = date('Y/m/d H:i:s', mktime(23, 59, 0, date('m', strtotime($this->input->post('endDate'))), date('d', strtotime($this->input->post('endDate'))), date('Y', strtotime($this->input->post('endDate')))));
        }
        if ($this->input->post("numberOfRepeats") > 0) {


            $this->repeatData($this->input->post("numberOfRepeats"), $this->input->post('timetableRepetition'), $data);

            return 1;
        } else {
            if ($this->input->post('id') != "") {
                $data["update_date"] = date('Y/m/d H:i:s');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update($this->tn, $data);
                return $this->input->post('id');
            } else {
                $this->db->insert($this->tn, $data);
                return $this->db->insert_id();
            }
        }
    }

    public function delete($eventId) {
        $this->db->where("id", $eventId);
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

    public function get_user_timetable_events($userId, $startDate=null, $endDate=null) {
        $this->db->order_by("start_date", "asc");
        
//        if ($startDate != null && $startDate != "" && $endDate != null && $endDate != "") {
//            $this->db->where("start_date >=", date('Y/m/d', strtotime($startDate)));
//            $this->db->where("end_date <=", date('Y/m/d H:i:s', mktime(23, 59, 0, date('m', strtotime($endDate)), date('d', strtotime($endDate)), date('Y', strtotime($endDate)))));
//        }
        if ($startDate != null && $startDate != "" && $endDate != null && $endDate != "") {
            $this->db->where("( start_date between '" .$startDate . "' and '" . $endDate ."' or end_date between '" .$startDate . "' and '" . $endDate ."' )" );
//            $this->db->where(array("end_date >" => $startDate , 'end_date <=' => $endDate));
//            $this->db->or_where(array("start_date >=" => $startDate , 'start_date <=' => $endDate, "end_date >" => $startDate , 'end_date <=' => $endDate));
        }else{
            
        }
        $this->db->where("user_id =", $userId);
        $query = $this->db->get_where($this->tn);
//        echo $this->db->last_query();
        return $query->result();
    }

    public function get_user_timetable_event($userId, $id) {
        $this->db->or_where("user_id =", $userId);
        $query = $this->db->get_where($this->tn, array("id" => $id));
        return $query->row();
    }

    public function getFilteredTimetableEvents($userId, $search) {
        $this->db->order_by("start_date", "asc");
        $this->db->where("user_id =", $userId);
        if (isset($search["name"]) && $search["name"] != null) {
            $this->db->like("name", $search["name"]);
        }
        if (isset($search["description"]) && $search["description"] != null && $search["description"] != "") {
            $this->db->like("description", $search["description"]);
        }
        if (isset($search["tt_category_id"]) && $search["timetableCategory"] != null && $search["timetableCategory"] != "") {
            $this->db->where("tt_category_id", $search["timetableCategory"]);
        }
        if(isset($search["timetableCategory"]) && $search["timetableCategory"] != null && $search["timetableCategory"] != "") {
            $this->db->where("tt_category_id", $search["timetableCategory"]);
        }
        if (isset($search["allDayEvent"]) && $search["allDayEvent"] != null && $search["allDayEvent"] != "") {
            if ($search["startDate"] != null && $search["startDate"] != "" &&
                    $search["endDate"] != null && $search["endDate"] != "") {
                $this->db->where("start_date >=", date('Y/m/d', strtotime($search["startDate"])));
                $this->db->where("end_date <=", date('Y/m/d H:i:s', mktime(23, 59, 0, date('m', strtotime($search["endDate"])), date('d', strtotime($search["endDate"])), date('Y', strtotime($search["endDate"])))));
            }
        }
        if ($search["startDate"] != null && $search["startDate"] != "" && $search["endDate"] != null && $search["endDate"] != "") {
            $this->db->where(array("start_date >=" => $search["startDate"] , 'start_date <=' => $search["endDate"]));
            $this->db->where(array("end_date >" => $search["startDate"] , 'end_date <=' => $search["endDate"]));
        }
//        if ($search["endDate"] != null && $search["endDate"] != "") {
//            $this->db->where("end_date <=", date('Y/m/d', strtotime($search["endDate"])));
//        }
        if (isset($search["locationId"]) && $search["locationId"] != null && $search["locationId"] != "") {
            $this->db->where("location_id", $search["locationId"]);
        }else if (isset($search["location"]) && $search["location"] != null && $search["location"] != "") {
            $this->db->or_like("location_text", $search["location"]);
        }
        
        //$this->db->or_where("location_id", $search["location"]);
        if (isset($search["timetableExpenseType"]) && $search["timetableExpenseType"] != null && $search["timetableExpenseType"] != "" && $search["timetableExpenseType"] != 0 ) {
            $this->db->where("expense_type_id", $search["timetableExpenseType"]);
        }
        
        if(isset($search["dashboardCategories"]) && sizeof($search["dashboardCategories"]) > 0){
            $this->db->where_in("tt_category_id" ,$this->array_column_old( $search["dashboardCategories"], "id"));
        }
        
        $query = $this->db->get_where($this->tn);
//        echo $this->db->last_query();
        return $query->result();
    }

    private function repeatData($numberOfRepeats, $timetableRepetition, $data) {
        $this->load->model("timetable_repetition_model");
        $repData = $this->timetable_repetition_model->get_timetable_repitition($timetableRepetition);
        $offset = 0;
        $dayRangeArr = explode(",", $repData[0]->val);
        $startTime = strtotime($data["start_date"]);
        $endTime = strtotime($data["end_date"]);
        for ($i = 0; $i < $numberOfRepeats; $i++) {
            $startDate = $this->input->post('startDate');
            $endDate = $this->input->post('endDate');
            switch ($repData[0]->id) {
                case "10":
                    $data["start_date"] = date('Y/m/d H:i:s', mktime(date('H', $startTime), date('i', $startTime), date('s', $startTime), date('m', $startTime), date('d', $startTime) + $i, date('Y', $startTime)));
                    $data["end_date"] = date('Y/m/d H:i:s', mktime(date('H', $endTime), date('i', $endTime), date('s', $endTime), date('m', $endTime), date('d', $endTime) + $i, date('Y', $endTime)));
                    $this->repeatInsert($data);
                    break;
                case "2" :
                    $data["start_date"] = date('Y/m/d H:i:s', mktime(date('H', $startTime), date('i', $startTime), date('s', $startTime), date('m', $startTime), date('d', $startTime) + ($i * 7 ), date('Y', $startTime)));

                    $data["end_date"] = date('Y/m/d H:i:s', mktime(date('H', $endTime), date('i', $endTime), date('s', $endTime), date('m', $endTime), date('d', $endTime) + ($i * 7 ), date('Y', $endTime)));
                    $this->repeatInsert($data);
                    break;
                case "3" :
                    $data["start_date"] = date('Y/m/d H:i:s', mktime(date('H', $startTime), date('i', $startTime), date('s', $startTime), date('m', $startTime), date('d', $startTime) + ($i * 14 ), date('Y', $startTime)));

                    $data["end_date"] = date('Y/m/d H:i:s', mktime(date('H', $endTime), date('i', $endTime), date('s', $endTime), date('m', $endTime), date('d', $endTime) + ($i * 14 ), date('Y', $endTime)));
                    $this->repeatInsert($data);
                    break;
                case "4" :
                    $data["start_date"] = date('Y/m/d H:i:s', mktime(date('H', $startTime), date('i', $startTime), date('s', $startTime), date('m', $startTime), date('d', $startTime), date('Y', $startTime) + $i));

                    $data["end_date"] = date('Y/m/d H:i:s', mktime(date('H', $endTime), date('i', $endTime), date('s', $endTime), date('m', $endTime), date('d', $endTime), date('Y', $endTime) + $i));
                    $this->repeatInsert($data);
                    break;
                case "5" :
                    $data["start_date"] = date('Y/m/d H:i:s', mktime(date('H', $startTime), date('i', $startTime), date('s', $startTime), date('m', $startTime) + $i, date('d', $startTime), date('Y', $startTime)));

                    $data["end_date"] = date('Y/m/d H:i:s', mktime(date('H', $endTime), date('i', $endTime), date('s', $endTime), date('m', $endTime) + $i, date('d', $endTime), date('Y', $endTime)));
                    $this->repeatInsert($data);
                    break;
                case "6" :
                case "7" :
                case "8" :
                case "9" :
                    $startDate = date('Y/m/d H:i:s', mktime(date('H', $startTime), date('i', $startTime), date('s', $startTime), date('m', $startTime), date('d', $startTime) + $i + $offset, date('Y', $startTime)));
                    // get all weekdays
                    $dayOfWeek = date("N", $startTime);
                    if (in_array($dayOfWeek, $dayRangeArr)) {
                        
                    } else {
                        $offset = $offset + 1;
                        $i = $i - 1;
                        continue;
                    }
                    $startDate = $this->input->post('startDate');
                    $data["start_date"] = date('Y/m/d H:i:s', mktime(date('H', $startTime), date('i', $startTime), date('s', $startTime), date('m', $startTime), date('d', $startTime) + $i + $offset, date('Y', $startTime)));

                    $data["end_date"] = date('Y/m/d H:i:s', mktime(date('H', $endTime), date('i', $endTime), date('s', $endTime), date('m', $endTime), date('d', $endTime) + $i + $offset, date('Y', $endTime)));
                    $this->repeatInsert($data);
                    break;
            }
        }
    }

    private function repeatInsert($data) {
        $this->db->insert($this->tn, $data);
    }

    function array_column_old(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( ! isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( ! isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}
