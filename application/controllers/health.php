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
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->helper('usability_helper');
     }
    //put your code here
    
    public function index(){
        $data = array();
        $this->load->view('header', getPageTitle($data, $this->toolName, "Health"));
        $this->load->view('health/health_nav');
//        $this->load->view('expenses/history', $data);
        $this->load->view('footer');
    }
    
    public function metricsView(){
        echo __CLASS__ . " >> ". __FUNCTION__ . " >> " . __LINE__;
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
