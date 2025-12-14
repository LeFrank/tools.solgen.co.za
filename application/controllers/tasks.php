<?php  

/*$route['tasks'] = 'tasks/index';
$route['tasks/create'] = 'tasks/create';
$route['tasks/edit/(:num)'] = 'tasks/edit/$1';
$route['tasks/update/(:num)'] = 'tasks/updtate/$1';
$route['tasks/delete/(:num)'] = 'tasks/delete/$1';
$route['tasks/view/(:num)'] = 'tasks/view/$1';
$route['tasks/options'] = 'tasks/options';
$route['tasks/stats'] = 'tasks/stats';
*/

class Tasks extends CI_Controller {

    var $toolId = 11;
    var $toolName = "Tasks";
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
        $this->load->helper('tool_info_helper');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('tasks_model');
        $this->load->model('tasks_domains_model');
        $this->load->model('tasks_status_model');
        $this->load->model("user_content_model");
    }   

    public function index() {
        $userId = $this->session->userdata("user")->id;
        $this->load->library('session');
        $data["tasks"] = $this->tasks_model->getTasks($userId, 50);
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50), true);
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit;
        $data["css"] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';
        $data["js"] = '';
        $this->load->view('header', getPageTitle($data, $this->toolName, "Overview", ""));
        $this->load->view('tasks/tasks_nav');
        $this->load->view('tasks/view', $data);
        $this->load->view('footer');
    }

    public function delete($id) {
        $userId = $this->session->userdata("user")->id;
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        if ($this->tasks_model->doesItBelongToMe($userId, $id)) {
            $data["task"] = $this->tasks_model->delete($id);
            $data["status"] = "Deleted Task";
            $data["action_classes"] = "success";
            $data["action_description"] = "Deleted a task";
            $data["message_classes"] = "success";
            $data["message"] = "The task was successfully deleted";
            $data["reUrl"] = "/tasks";
            $data["tasks"] = $this->tasks_model->getTasks($userId, 50);
            $this->load->view('header', $data);
            $this->load->view('tasks/tasks_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('tasks/view', $data);
            $this->load->view('footer');
        } else {
            $data["tasks"] =$this->tasks_model->getTasks($this->session->userdata("user")->id, 50);
            $data["status"] = "Delete Task";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Unable to delete the task";
            $data["message_classes"] = "failure";
            $data["message"] = "The task you are attempting to delete does not exist or does not belong to you.";
            $data["reUrl"] = "/tasks";
            $data["tasks"] =$this->tasks_model->getTasks($this->session->userdata("user")->id, 50);
            $this->load->view('header', $data);
            $this->load->view('tasks/tasks_nav');
            $this->load->view('general/action_status', $data);
            $this->load->view('tasks/view', $data);
            $this->load->view('footer');
        }
    }

    public function capture() {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $userId = $this->session->userdata("user")->id;
        $data['title'] = 'Create a Task';

        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->view();
        } else {
            // print_r($this->input->post());
            $data["task"] = $this->tasks_model->capture_task();
            // print_r($data["user_content"]);
            $data["status"] = "Task Created";
            $data["action_classes"] = "success";
            $data["message_classes"] = "success";
            $data["action_description"] = "Created a task";
            $data["message"] = "The task was created. ";
            $this->session->set_flashdata("success", $this->load->view('general/action_status', $data, true));
            redirect("/tasks", "refresh");
        }
    }

    public function edit($id) {
        $this->load->library('session');
        $data["tools"] = getAllToolsInfo();
        $userId = $this->session->userdata("user")->id;
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        if ($this->tasks_model->doesItBelongToMe($userId, $id)) {
            $data["task"] = $this->tasks_model->getTask($id);
            $this->load->view('header', $data);
            $this->load->view('tasks/tasks_nav');
            $this->load->view('tasks/edit', $data);
            $this->load->view('footer');
        } else {
            $data["tasks"] =$this->tasks_model->getTasks($this->session->userdata("user")->id, 50);
            $data["status"] = "Edit Task";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Unable to edit the task";
            $data["message_classes"] = "failure";
            $data["message"] = "The task you are attempting to edit does not exist or does not belong to you.";
            $data["reUrl"] = "/tasks";
            $this->session->set_flashdata("error", $this->load->view('general/action_status', $data, true));
            redirect("/tasks", "refresh");
        }
    }

    public function update() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $userId = $this->session->userdata("user")->id;
        $id = $this->input->post('id');
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post("id"));
        } else {
            $data["status"] = "Edit Task";
            $data["action_classes"] = "success";
            $data["action_description"] = "Updated the Task";
            $data["message_classes"] = "success";
            $data["message"] = "You have successfully updated the task";
            $this->tasks_model->update($this->input->post('id'));
            $data["tasks"] = $this->tasks_model->getTasks($this->session->userdata("user")->id, 50);
            $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
            $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
            $this->load->view('header', $data);
            $this->load->view('tasks/tasks_nav');
            $this->load->view('user/user_status', $data);
            $this->load->view('tasks/view', $data);
            $this->load->view('footer');
        }
    }

    public function MarkAsDone($id){
        $userId = $this->session->userdata("user")->id;
        if ($this->tasks_model->doesItBelongToMe($userId, $id)) {
            $this->tasks_model->markAsDone($id);
            $this->session->set_flashdata("success", "The task was marked as done.");
            echo json_encode(array("status" => "success", "message"=>"The task was marked as done."));
            // echo "yes";
        } else {
            $this->session->set_flashdata("error", "The task you are attempting to mark as done does not exist or does not belong to you.");
            echo json_encode(array("status" => "error", "message"=>"The completion of the task failed."));
        }
    }   

    public function MarkAsUnDone($id){
        $userId = $this->session->userdata("user")->id;
        if ($this->tasks_model->doesItBelongToMe($userId, $id)) {
            $this->tasks_model->markAsUnDone($id);
            $this->session->set_flashdata("success", "The task status was reset.");
            echo json_encode(array("status" => "success", "message"=>"The task was marked as undone."));
        } else {
            $this->session->set_flashdata("error", "The task you are attempting to mark as done does not exist or does not belong to you.");
            echo json_encode(array("status" => "error", "message"=>"The task undoing of the task failed."));
        }
    }   

}