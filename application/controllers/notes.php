<?php

class Notes extends CI_Controller {

    var $require_auth = true;

    public function __construct() {
        parent::__construct();
        $this->load->helper('auth_helper');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('notes_model');
    }

    public function capture() {
        $data['title'] = 'Create a note';
        $this->form_validation->set_rules('body', 'body', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data["notes"] = "";
            $this->load->view('header');
            $this->load->view('notes/notes_nav', $data);
            $this->load->view('notes/index', $data);
            $this->load->view('footer');
        } else {
            $data["note"] = $this->notes_model->capture_note();
            redirect("/notes", "refresh");
        }
    }

    public function delete($id = null) {
        echo __CLASS__ . " >> " . __FUNCTION__ . " >> " . $id;
        exit;
    }

    public function edit($id = null) {
        $this->load->library('session');
        $user = $this->session->userdata("user");
        $data["note"] = $this->notes_model->getNote($id);
        $this->load->view('header');
        $this->load->view('notes/notes_nav', $data);
        $this->load->view("notes/capture_form", $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }

    public function history(){
        $this->load->library('session');
        $user = $this->session->userdata("user");
        $data["notes"] = $this->notes_model->getNotes($user->id);
        $this->load->view('header');
        $this->load->view('notes/notes_nav', $data);
        $data["capture_form"] = "";
        $this->load->view('notes/history', $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }
    
    /**
     * 	Display and capture a note
     */
    public function index() {
        $this->load->library('session');
        $user = $this->session->userdata("user");
        $data["notes"] = $this->notes_model->getNotes($user->id, 5);
        $this->load->view('header');
        $this->load->view('notes/notes_nav', $data);
        $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
        $this->load->view('notes/index', $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }

    public function update() {
        $data['title'] = 'Update a note';
        $this->form_validation->set_rules('body', 'body', 'required');
        $data["status"] = "Update Note";
        $data["action_description"] = "Update a note";
        if ($this->form_validation->run() == FALSE) {
            $data["action_classes"] = "faliure";
            $data["message_classes"] = "failure";
            $data["message"] = "The note was not updated";
            $data["notes"] = "";
            $this->load->view('header');
            $this->load->view('notes/notes_nav', $data);
            $this->load->view('general/action_status', $data);
            $this->load->view('notes/index', $data);
            $this->load->view('footer');
        } else {
            $data["note"] = $this->notes_model->update();
            redirect("/notes", "refresh");
        }
    }

}
