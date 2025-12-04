<?php

class TasksDomains extends CI_Controller {

    var $require_auth = true;
    var $toolName = "Task Domains";

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->library('form_validation');
        $this->load->helper("usability_helper");
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('tasks_domains_model');
    }

    public function manage() {
        $this->load->helper("array_helper");
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_only_user_tasks_domains($this->session->userdata("user")->id), false);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Manage Tasks Domains"));
        $this->load->view('tasks/tasks_nav');
        $this->load->view("tasks_domains/manage", $data);
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
            $this->load->view("tasks_domains/manage");
            $this->load->view("footer");
        } else {
            if (!$this->tasks_domains_model->doesItExist($this->session->userdata("user")->id, $this->input->post('name'))) {
                $this->tasks_domains_model->create_tasks_domain();
            }
            $data["status"] = "Created Tasks Domain";
            $data["action_classes"] = "success";
            $data["action_description"] = "Create personalized tasks domain";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully created your own tasks domain";
            $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_only_user_tasks_domains($this->session->userdata("user")->id), false);
            unset($_POST);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav", $data);
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_domains/manage", $data);
            $this->load->view("footer");
        }
    }

    public function delete($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Delete Task Domains";
        //check if this expense type belongs to you?
        if ($this->tasks_domains_model->doesItBelongToMe($mySession, $id)) {
            $data["action_classes"] = "success";
            $data["action_description"] = "Delete Task Domain";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully deleted the tasks domain";
            $this->tasks_domains_model->delete($id);
            $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_only_user_tasks_domains($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav", $data);
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_domains/manage", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Delete ETask Domain";
            $data["message_classes"] = "failure";
            $data["message"] = "The task domain does not exist or it does not belong to you.";

            $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_only_user_tasks_domains($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav");
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_domains/manage", $data);
            $this->load->view("footer");
        }
    }

    public function edit($id) {
        $mySession = $this->session->userdata("user")->id;
        $data["status"] = "Edit Tasks Domain";
        //check if this expense type belongs to you?
        if ($this->tasks_domains_model->doesItBelongToMe($mySession, $id) || $this->tasks_domains_model->isItGlobal($mySession, $id)) {
            $data['taskDomain'] = $this->tasks_domains_model->get_tasks_domain($id);
            //show new page
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav", $data);
            $this->load->view("tasks_domains/edit", $data);
            $this->load->view("footer");
        } else {
            $data["action_classes"] = "failure";
            $data["action_description"] = "Edit Task Domain";
            $data["message_classes"] = "failure";
            $data["message"] = "The task domain does not exist or it does not belong to you.";

            $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_only_user_expense_types($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav");
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_domains/manage", $data);
            $this->load->view("footer");
        }
    }

    public function getTaskDomainById($id=null){
        if(null == $id){
            echo json_encode(array("error" => "invalid ID" ));
        }
        $mySession = $this->session->userdata("user")->id;
//        $this->expense_type_model->doesItBelongToMe($mySession, $id);
        $data['taskDomain'] = $this->tasks_domains_model->get_tasks_domain($id);
        echo json_encode($data['expenseType']);
    }
    
    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data["status"] = "Update Tasks Domain";
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id'));
        } else {
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Tasks Domain";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the tasks domain";
            $this->tasks_domains_model->update($this->input->post('id'));
            $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_only_user_tasks_domains($this->session->userdata("user")->id), false);
            $this->load->view("header");
            $this->load->view("tasks/tasks_nav");            
            $this->load->view("user/user_status", $data);
            $this->load->view("tasks_domains/manage", $data);
            $this->load->view("footer");
        }
    }

}
