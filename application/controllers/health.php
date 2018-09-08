<?php

/**
 * Description of health
 *
 * @author francois
 */
class health extends CI_Controller {

    var $toolId = 8;
    var $toolName = "Health";
    var $require_auth = TRUE;
    var $difficultyRating = array(
        1 => "1 - Easy, no sweat",
        2 => "2 - Easy with some variation in elevation",
        3 => "3 - Easy with technical sections",
        4 => "4 - Moderate, worked up a good sweat",
        5 => "5 - Moderate with variations in elevations",
        6 => "6 - Moderate with technical sections",
        7 => "7 - Hard, endurance required",
        8 => "8 - Hard, strength and stamina required",
        9 => "9 - Hard, intense training and specific preparation required",
        10 => "10 - Intense, pushed to beyond the limit"
    );

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->helper("date_helper");
        $this->load->helper("user_config");
        $this->load->helper("health_emotion_helper");
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->library("input");
        can_access(
                $this->require_auth, $this->session);
        $this->load->helper('health_statistics_helper');
        $this->load->model("health_metric_model");
        $this->load->model("exercise_type_model");
        $this->load->model("health_exercise_tracker_model");
        $this->load->model("health_emotion_record_model");
        $this->load->model("health_diet_model");
        $this->load->model("user_configs_model");
    }

    public function index() {
        $data = array();

        $startDate = $endDate = null;
        if (null != $this->input->post("fromDate")) {
            $startDate = $this->input->post("fromDate");
        }
        if (null != $this->input->post("toDate")) {
            $endDate = $this->input->post("toDate");
        }
        if ($startDate == null) {
            $startDate = date('Y/m/d H:i', strtotime('-1 month'));
        } else {
            $startDate = date('Y/m/d H:i', strtotime($startDate));
        }
        if ($endDate == null) {
            $endDate = date('Y/m/d H:i', strtotime("now"));
        } else {
            $endDate = date('Y/m/d H:i', strtotime($endDate));
        }
        $search["startDate"] = $startDate;
        $search["endDate"] = $endDate;
        $data["startDate"] = $startDate;
        $data["endDate"] = $endDate;
        $userId = $this->session->userdata("user")->id;
        $data["userHealthConfigs"] = mapKeyToValue($this->user_configs_model->getUserConfigsByToolId($userId, $this->toolId));
        $data["difficultyRating"] = $this->difficultyRating;
        $data["healthMetrics"] = $this->health_metric_model->getHealthMetricByDateRange($data["startDate"], $data["endDate"], $userId);
        $data["healthMetricsStats"] = $this->health_metric_model->getOverallUserStatsByDateRange($data["startDate"], $data["endDate"], $userId);
        $data["waist"] = json_encode(getWaistOverDateRangeJson($data["healthMetrics"]));
        $data["weight"] = json_encode(getWeightOverDateRangeJson($data["healthMetrics"]));
        $data["sleep"] = json_encode(getSleepOverDateRangeJson($data["healthMetrics"]));
        $data["sleepTarget"] = json_encode(getSleepTargetOverDateRangeJson($data["healthMetrics"], $data["userHealthConfigs"]["target_sleep"]));
        $data["waistTarget"] = json_encode(getWaistTargetOverDateRangeJson($data["healthMetrics"], $data["userHealthConfigs"]["target_waist"]));
        $data["weightTarget"] = json_encode(getWeightTargetOverDateRangeJson($data["healthMetrics"], $data["userHealthConfigs"]["target_weight"]));
        $data["exercises"] = $this->health_exercise_tracker_model->getuserExercisesByDateRange($data["startDate"], $data["endDate"], $this->session->userdata("user")->id);
        $data["exerciseStats"] = $this->health_exercise_tracker_model->getOverallUserStatsByDateRange($data["startDate"], $data["endDate"], $userId);
        $data["exerciseByExcerciseTypeStats"] = $this->health_exercise_tracker_model->getOverallUserStatsForExceriseTypesByDateRange($data["startDate"], $data["endDate"], $userId);
        $data["exerciseTypes"] = mapKeyToId($this->exercise_type_model->get_user_exercise_types($userId));
        $data["exerciseGraphMetrics"] = getExerciseGraphDataPerType($data["exerciseTypes"], $data["exercises"]);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Health"));
        $this->load->view('health/health_nav');
        $this->load->view('health/overview');
        $this->load->view('footer');
    }

    public function metricsView() {
        $startDate = $endDate = null;
        if (null != $this->input->post("fromDate")) {
            $startDate = $this->input->post("fromDate");
        }
        if (null != $this->input->post("toDate")) {
            $endDate = $this->input->post("toDate");
        }
        if ($startDate == null) {
            $startDate = date('Y/m/d H:i', strtotime('-1 month'));
        } else {
            $startDate = date('Y/m/d H:i', strtotime($startDate));
        }
        if ($endDate == null) {
            $endDate = date('Y/m/d H:i', strtotime("now"));
        } else {
            $endDate = date('Y/m/d H:i', strtotime($endDate));
        }
        $search["startDate"] = $startDate;
        $search["endDate"] = $endDate;
        $data["startDate"] = $startDate;
        $data["endDate"] = $endDate;
        $data["healthMetrics"] = $this->health_metric_model->getHealthMetricByDateRange($data["startDate"], $data["endDate"], $this->session->userdata("user")->id);
        $data["statusArr"] = $this->session->flashdata('status');
        $this->load->view('header', getPageTitle($data, $this->toolName, "Health"));
        $this->load->view('health/health_nav');
        if (!empty($data["statusArr"])) {
            $data["status"] = $data["statusArr"]["status"];
            $data["action_classes"] = strtolower($data["statusArr"]["status"]);
            $data["action_description"] = $data["statusArr"]["message"];
            $data["message_classes"] = strtolower($data["statusArr"]["status"]);
            $data["message"] = $data["statusArr"]["description"];
            $this->load->view('user/user_status', $data);
        }
        $this->load->view('health/metrics/index', $data);
        $this->load->view('footer');
    }

    /**
     * Capture a physical metric
     * determine what the difference was since the last measurement was taken
     * Positive or negative change
     * Display alert if a negative pattern has been detected.
     * e.g. 
     *      X number of measurements in a row for weight gain has been detected
     *      X number of waist measurements in a row increase has been detected.
     *      X number of nights without meeting target sleep duration has been detected.
     */
    public function metricsCapture() {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_metric_model->capture_metric()) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Captured the metric has been added.";
            $data["statusArr"]["description"] = "You have successfully captured a metric. well done!!";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }

        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("/health/metrics", "refresh");
    }

    public function metricEdit($metricId) {
        $userId = $this->session->userdata("user")->id;
        //get exercise and supporting information
        $data["metric"] = $this->health_metric_model->getUserMetricById($userId, $metricId);
        //Display Metric
        $this->load->view('header', getPageTitle($data, $this->toolName, "Exercise Edit"));
        $this->load->view('health/health_nav');
        $this->load->view('health/metrics/edit', $data);
        $this->load->view('footer');
        //Done
    }

    public function metricDelete($metricId) {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_metric_model->delete_metric($userId, $metricId)) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Delete the metric.";
            $data["statusArr"]["description"] = "You have successfully deleted a metric.";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }

        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("/health/metrics", "refresh");
    }

    public function metricUpdate() {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_metric_model->update()) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Health Metrics have been updated.";
            $data["statusArr"]["description"] = "You have successfully updated the metric.";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }
        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("health/metrics", "refresh");
    }

    public function exerciseTrackerView() {
        $startDate = $endDate = null;
        if (null != $this->input->post("fromDate")) {
            $startDate = $this->input->post("fromDate");
        }
        if (null != $this->input->post("toDate")) {
            $endDate = $this->input->post("toDate");
        }
        if ($startDate == null) {
            $startDate = date('Y/m/d H:i', strtotime('-1 month'));
        } else {
            $startDate = date('Y/m/d H:i', strtotime($startDate));
        }
        if ($endDate == null) {
            $endDate = date('Y/m/d H:i', strtotime("now"));
        } else {
            $endDate = date('Y/m/d H:i', strtotime($endDate));
        }
        $search["startDate"] = $startDate;
        $search["endDate"] = $endDate;
        $data["startDate"] = $startDate;
        $data["endDate"] = $endDate;
        $userId = $this->session->userdata("user")->id;
        $data["exercises"] = $this->health_exercise_tracker_model->getuserExercisesByDateRange($data["startDate"], $data["endDate"], $this->session->userdata("user")->id);
        $data["exerciseTypes"] = mapKeyToId($this->exercise_type_model->get_user_exercise_types($userId));
        $data["statusArr"] = $this->session->flashdata('status');
        $this->load->view('header', getPageTitle($data, $this->toolName, "Health"));
        $this->load->view('health/health_nav');
        if (!empty($data["statusArr"])) {
            $data["status"] = $data["statusArr"]["status"];
            $data["action_classes"] = strtolower($data["statusArr"]["status"]);
            $data["action_description"] = $data["statusArr"]["message"];
            $data["message_classes"] = strtolower($data["statusArr"]["status"]);
            $data["message"] = $data["statusArr"]["description"];
            $this->load->view('user/user_status', $data);
        }
        $this->load->view('health/exercise/index', $data);
        $this->load->view('footer');
    }

    public function exerciseCapture() {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_exercise_tracker_model->capture_exercise()) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Exercise has been added.";
            $data["statusArr"]["description"] = "You have successfully captured the exercise. well done!!";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }

        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("health/exercise/tracker", "refresh");
    }

    public function exerciseEdit($exerciseId) {
        $userId = $this->session->userdata("user")->id;
        //get exercise and supporting information
        $data["exercise"] = $this->health_exercise_tracker_model->getUserExerciseById($userId, $exerciseId);
        $data["exerciseTypes"] = mapKeyToId($this->exercise_type_model->get_user_exercise_types($userId));
        //Display Exercise
        $this->load->view('header', getPageTitle($data, $this->toolName, "Exercise Edit"));
        $this->load->view('health/health_nav');
        $this->load->view('health/exercise/edit', $data);
        $this->load->view('footer');
    }

    public function exerciseDelete($exerciseId) {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_exercise_tracker_model->delete_exercise($userId, $exerciseId)) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Exercise has been added.";
            $data["statusArr"]["description"] = "You have successfully captured the exercise. well done!!";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }

        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("health/exercise/tracker", "refresh");
    }

    public function exerciseUpdate() {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_exercise_tracker_model->update()) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Exercise has been updated.";
            $data["statusArr"]["description"] = "You have successfully updated the exercise.";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }
        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("health/exercise/tracker", "refresh");
    }

    public function dietView() {
        $startDate = $endDate = null;
        if (null != $this->input->post("fromDate")) {
            $startDate = $this->input->post("fromDate");
        }
        if (null != $this->input->post("toDate")) {
            $endDate = $this->input->post("toDate");
        }
        if ($startDate == null) {
            $startDate = date('Y/m/d H:i', strtotime('-1 month'));
        } else {
            $startDate = date('Y/m/d H:i', strtotime($startDate));
        }
        if ($endDate == null) {
            $endDate = date('Y/m/d H:i', strtotime("now"));
        } else {
            $endDate = date('Y/m/d H:i', strtotime($endDate));
        }
        $search["startDate"] = $startDate;
        $search["endDate"] = $endDate;
        $data["startDate"] = $startDate;
        $data["endDate"] = $endDate;
        $userId = $this->session->userdata("user")->id;
        $data["statusArr"] = $this->session->flashdata('status');
        $data["items"] = $this->health_diet_model->getHealthDietItemsByDateRange($data["startDate"], $data["endDate"], $userId);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Health"));
        $this->load->view('health/health_nav');
        if (!empty($data["statusArr"])) {
            $data["status"] = $data["statusArr"]["status"];
            $data["action_classes"] = strtolower($data["statusArr"]["status"]);
            $data["action_description"] = $data["statusArr"]["message"];
            $data["message_classes"] = strtolower($data["statusArr"]["status"]);
            $data["message"] = $data["statusArr"]["description"];
            $this->load->view('user/user_status', $data);
        }
        $this->load->view('health/diet/index', $data);
        $this->load->view('footer');
    }

    public function dietCapture() {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_diet_model->capture_diet_item()) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Item has been added.";
            $data["statusArr"]["description"] = "You have successfully captured an item. well done!!";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }

        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("health/diet", "refresh");
    }

    public function dietEdit($dietItemId) {
        $userId = $this->session->userdata("user")->id;
        //get exercise and supporting information
        $data["exercise"] = $this->health_diet_model->getUserDietItemById($userId, $dietItemId);
        //Display Exercise
        $this->load->view('header', getPageTitle($data, $this->toolName, "Diet Edit"));
        $this->load->view('health/health_nav');
        $this->load->view('health/diet/edit', $data);
        $this->load->view('footer');
    }

    public function dietDelete($exerciseId) {
        $userId = $this->session->userdata("user")->id;
        if ($this->health_exercise_tracker_model->delete_exercise($userId, $exerciseId)) {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = "Exercise has been added.";
            $data["statusArr"]["description"] = "You have successfully captured the exercise. well done!!";
        } else {
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "OOooops something went wrong";
            $data["statusArr"]["description"] = "Please check that are fields are correctly completed and try again.";
        }

        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("health/exercise/tracker", "refresh");
    }

    public function emotionTracker() {
        $startDate = $endDate = null;
        if (null != $this->input->post("fromDate")) {
            $startDate = $this->input->post("fromDate");
        }
        if (null != $this->input->post("toDate")) {
            $endDate = $this->input->post("toDate");
        }
        if ($startDate == null) {
            $startDate = date('Y/m/d H:i', strtotime('-1 month'));
        } else {
            $startDate = date('Y/m/d H:i', strtotime($startDate));
        }
        if ($endDate == null) {
            $endDate = date('Y/m/d H:i', strtotime("now"));
        } else {
            $endDate = date('Y/m/d H:i', strtotime($endDate));
        }
        $search["startDate"] = $startDate;
        $search["endDate"] = $endDate;
        $data["startDate"] = $startDate;
        $data["endDate"] = $endDate;
        $data["emotionIcons"] = getEmotionIcons();
        $userId = $this->session->userdata("user")->id;
        $data["emotions"] = $this->health_emotion_record_model->getEmotionRecordsByDateRange($data["startDate"], $data["endDate"], $this->session->userdata("user")->id);
        $data["userHealthConfigs"] = mapKeyToValue($this->user_configs_model->getUserConfigsByToolId($userId, $this->toolId));
        $this->load->view('header', getPageTitle($data, $this->toolName, "Options"));
        $this->load->view('health/health_nav');
        $this->load->view('health/emotions/index', $data);
        $this->load->view('footer');
    }

    public function emotionCapture($emotionId) {
        $userId = $this->session->userdata("user")->id;
        $emotion["emotion_id"] = $emotionId;
        $emotion["created_date"] = date('Y/m/d H:i');
        ;
        $emotion["description"] = null;
        $emotion["user_id"] = $userId;
        $emotion["id"] = $this->health_emotion_record_model->capture_emotion($emotion);
    }

    public function emotionDescriptionCapture($id) {
        $userId = $this->session->userdata("user")->id;
        $emotion = $this->health_emotion_record_model->getEmotionRecordbyId($id, $userId);
        $emotion->description = $this->input->post("value");
        $this->health_emotion_record_model->update($emotion);
        echo $this->health_emotion_record_model->getEmotionRecordbyId($id, $userId)->description;
    }

    public function medicalhistory() {
        echo __CLASS__ . " >> " . __FUNCTION__ . " >> " . __LINE__;
    }

    public function options() {
        $userId = $this->session->userdata("user")->id;
        $data = array();
        $data["userHealthConfigs"] = mapKeyToValue($this->user_configs_model->getUserConfigsByToolId($userId, $this->toolId));
        $this->load->view('header', getPageTitle($data, $this->toolName, "Options"));
        $this->load->view('health/health_nav');
        $this->load->view('health/options', $data);
        $this->load->view('footer');
    }

    public function optionUpdate($optionId) {
        $userId = $this->session->userdata("user")->id;
        $data = array();
        $config = $this->user_configs_model->getUserConfig($userId, $optionId);
        $config->val = $this->input->post("value");
        $this->user_configs_model->update($config);
        echo $this->user_configs_model->getUserConfig($userId, $optionId)->val;
    }

}
