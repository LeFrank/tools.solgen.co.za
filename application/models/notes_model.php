<?php

class Notes_model extends CI_Model
{
    
    var $tn = "notes";
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
}