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
    
     public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->helper("date_helper");
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->helper('usability_helper');
        $this->load->model("health_metric_model");
     }
    //put your code here
    
    public function index(){
        $data = array();
        $data["startAndEndDate"] = getPastSevenDays();
        $this->load->view('header', getPageTitle($data, $this->toolName, "Health"));
        $this->load->view('health/health_nav');
//        $this->load->view('expenses/history', $data);
        $this->load->view('footer');
    }
    
    public function metricsView(){
        $data["startAndEndDate"] = getPastSevenDays();
        $data["healthMetrics"] = $this->health_metric_model->getHealthMetricByDateRange($data["startAndEndDate"][0], $data["startAndEndDate"][1], $this->session->userdata("user")->id);
        $data["statusArr"] = $this->session->flashdata('status');
        $this->load->view('header', getPageTitle($data, $this->toolName, "Health"));
        if (!empty($data["statusArr"])) {
            $data["status"] = $data["statusArr"]["status"];
            $data["action_classes"] = strtolower($data["statusArr"]["status"]);
            $data["action_description"] = $data["statusArr"]["message"];
            $data["message_classes"] = strtolower($data["statusArr"]["status"]);
            $data["message"] = $data["statusArr"]["description"];
            $this->load->view('user/user_status', $data);
        }
        $this->load->view('health/health_nav');
        $this->load->view('health/metrics/index', $data);
        $this->load->view('footer');
    }
    
    public function metricsCapture(){
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
    
    public function exerciseTrackerView(){
        echo __CLASS__ . " >> ". __FUNCTION__ . " >> " . __LINE__;
    }

    public function dietView(){
        echo __CLASS__ . " >> ". __FUNCTION__ . " >> " . __LINE__;
    }
    
    public function emotionTracker(){
        echo __CLASS__ . " >> ". __FUNCTION__ . " >> " . __LINE__;
    }
    
    public function medicalhistory(){
        echo __CLASS__ . " >> ". __FUNCTION__ . " >> " . __LINE__;
    }
    
    public function options(){
        echo __CLASS__ . " >> ". __FUNCTION__ . " >> " . __LINE__;
    }
}
