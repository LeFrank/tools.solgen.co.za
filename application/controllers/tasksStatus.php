<?php

class tasksStatus extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Task Status";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');
        $this->load->helper("usability_helper");
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('tasks_status_model');
    }

    public function manage() {
        $this->load->helper("array_helper");
        $data["tasksStatus"] = mapKeyToId($this->tasks_status_model->get_only_user_tasks_statuses($this->session->userdata("user")->id), false);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $this->load->view('header', getPageTitle($data, $this->toolName, "Manage Tasks Status"));
        $this->load->view('tasks/tasks_nav');
        $this->load->view("tasks_status/manage", $data);
        $this->load->view("footer");
    }

    public function create() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view("header");
            $this->load->view("tasks_status/manage");
            $this->load->view("footer");
        } else {
            if (!$this->tasks_status_model->doesItExist($this->session->userdata("user")->id, $this->input->post('name'))) {
                $this->tasks_status_model->create_tasks_status();
            }
            $data["status"] = "Created Tasks Status";
            $data["action_classes"] = "success";
            $data["action_description"] = "Create personalized tasks status";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully created your own tasks Status";
            $data["tasksStatus"] = mapKeyToId($this->tasks_status_model->get_only_user_tasks_statuses($this->session->userdata("user")->id), false);
            unset($_POST);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav", $data);
            $this->load->view("user/user_status", $data);
            $this->load->view('tasks/tasks_nav');
            $this->load->view("tasks_status/manage", $data);
            $this->load->view("footer");
        }
    }

    public function delete($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Delete Task Status";
        //check if this expense type belongs to you?
        if ($this->tasks_status_model->doesItBelongToMe($mySession, $id)) {
            $data["action_classes"] = "success";
            $data["action_description"] = "Delete Task Status";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully deleted the tasks Status";
            $this->tasks_status_model->delete($id);
            $data["tasksStatus"] = mapKeyToId($this->tasks_status_model->get_only_user_tasks_statuses($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_status/manage", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete Task Status";
            $data["message_classes"] = "failure";
            $data["message"] = "The task Status does not exist or it does not belong to you.";

            $data["tasksStatus"] = mapKeyToId($this->tasks_status_model->get_only_user_tasks_statuses($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav", $data);
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_status/manage", $data);
            $this->load->view("footer");
        }
    }

    public function edit($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Edit Tasks Status";
        //check if this expense type belongs to you?
        if ($this->tasks_status_model->doesItBelongToMe($mySession, $id) || $this->tasks_status_model->isItGlobal($mySession, $id)) {
            $data['tasksStatus'] = $this->tasks_status_model->get_tasks_status($id);
            //show new page
            $this->load->view("header");
            $this->load->view("tasks_status/edit", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit Task Status";
            $data["message_classes"] = "failure";
            $data["message"] = "The task Status does not exist or it does not belong to you.";

            $data["tasksStatus"] = mapKeyToId($this->tasks_status_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav", $data);
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_status/manage", $data);
            $this->load->view("footer");
        }
    }

    public function getTaskstatusById($id=null){
        if(null == $id){
            echo json_encode(array("error" => "invalid ID" ));
        }
        $mySession = $this->session->userdata("user")->id;
//        $this->expense_type_model->doesItBelongToMe($mySession, $id);
        $data['taskStatus'] = $this->tasks_status_model->get_tasks_status($id);
        echo json_encode($data['expenseType']);
    }
    
    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["status"] = "Update Tasks Status";
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id'));
        } else {
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Tasks Status";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the tasks Status";
            $this->tasks_status_model->update($this->input->post('id'));
            $data["tasksStatus"] = mapKeyToId($this->tasks_status_model->get_only_user_tasks_statuses($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav", $data);
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_status/manage", $data);
            $this->load->view("footer");
        }
    }

}
