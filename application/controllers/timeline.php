<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of timeline
 *
 * @author francois
 */
class timeline extends CI_Controller {
    // Get all the things
    // normalize it for display
    // Create a standard object
    var $toolId = 6;
    var $toolName = "Timeline";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->helper('timeline_helper');
        $this->load->library("input");
        $this->load->library('form_validation');
        can_access($this->require_auth, $this->session);
        $this->load->model('notes_model');
        $this->load->model('expense_model');
        $this->load->model("expense_type_model");
        $this->load->model("timetable_model");
        $this->load->model("timetable_category_model");
        $this->load->helper('tool_info_helper');
        $this->load->model("user_content_model");
        $this->load->model("health_metric_model");
        $this->load->model("health_exercise_tracker_model");
        $this->load->model("exercise_type_model");
        
    }
    
    public function index($startDate = null, $endDate = null){
        $data["css"] = "<link href='/css/third_party/codyhouse/vertical-timeline/style.css' rel='stylesheet' />";
        $user = $this->session->userdata("user");
        //default date period. One month ago
        if(null != $this->input->post("fromDate")){
            $startDate = $this->input->post("fromDate");
        }
        if(null != $this->input->post("toDate")){
            $endDate = $this->input->post("toDate");
        }
        if($startDate == null){
            $startDate = date('Y/m/d H:i', strtotime('-1 month'));
        }else{
            $startDate = date('Y/m/d H:i', strtotime($startDate));
        }
//        echo $startDate;
        if($endDate== null ){
            $endDate = date('Y/m/d H:i', strtotime("now"));
        }else{
            $endDate = date('Y/m/d H:i', strtotime($endDate));
        }
//        echo "<br/>".$endDate;
        $search["startDate"] = $startDate;
        $search["endDate"] = $endDate;
        $data["startDate"] = $startDate;
        $data["endDate"] = $endDate;
        $data["tools"] = getAllToolsInfo();
        $data["events"] = timelineNoteFormat($this->notes_model->getNotesForPeriod($user->id, $startDate, $endDate), null);
        $data["expenseTypes"] = mapKeyToId($this->expense_type_model->get_expense_types());
        $data["events"] = timelineExpenseFormat($this->expense_model->getExpensesbyDateRange( $startDate, $endDate, $user->id), $data["events"], $data["expenseTypes"]);
        $data["timetableCategories"] = mapKeyToId($this->timetable_category_model->get_user_timetable_category($user->id), false);
        $search["allDayEvent"] = 1;
        $data["events"] = timelineTimetableFormat($this->timetable_model->getFilteredTimetableEvents($user->id, $search), $data["events"], $data["timetableCategories"] );
        // Resources
//        $data["tools"] = getAllToolsInfo();
        $data["resources"] = $this->user_content_model->getUserContentDateRange($startDate, $endDate, $user->id);
        $data["events"] = timelineResourceFormat($data["resources"], $data["events"], $data["tools"]);
        // Health
        //  -   Metrics
        $data["healthMetrics"] = $this->health_metric_model->getHealthMetricByDateRange($startDate, $endDate, $user->id);
        $data["events"] = timelineHealthMetricsFormat($data["healthMetrics"], $data["events"], $data["tools"]);
        //  -   Exercises
        $data["exerciseTypes"] = mapKeyToId($this->exercise_type_model->get_user_exercise_types($user->id));
        $data["healthExercises"] = $this->health_exercise_tracker_model->getuserExercisesByDateRange($startDate, $endDate, $user->id);
        $data["events"] = timelineHealthExercisesFormat($data["healthExercises"], $data["events"], $data["tools"], $data["exerciseTypes"]);
        $data["events"] = orderTimeline($data["events"]);
        
//        echo "<br/>".count($data["events"]) . "<pre>";
//        print_r($data["events"]);
//        echo "</pre>";
        $this->load->view('header', getPageTitle($data, $this->toolName, "TimeLine"));
        $this->load->view("timeline/view", $data);
        $this->load->view("footer");
    }
}
