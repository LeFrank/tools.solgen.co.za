<?php
class Notes extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('notes_model');
    }
}