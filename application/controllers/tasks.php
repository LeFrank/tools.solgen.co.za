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

    var $importanceLevels = array(
        0 => array("name" => "Unspecified", "id" => 0, "order" => 0, "default" => true ),
        1 => array("name" => "Very Low", "id" => 1, "order" => 1, "default" => false ),
        2 => array("name" => "Low", "id" => 2, "order" => 2, "default" => false ),
        3 => array("name" => "Moderate", "id" => 3, "order" => 3, "default" => false ),
        4 => array("name" => "High", "id" => 4, "order" => 4, "default" => false ),
        5 => array("name" => "Very High", "id" => 5, "order" => 5, "default" => false )
    );

    var $urgencyLevels = array(
        0 => array("name" => "Unspecified", "id" => 0, "order" => 0, "default" => true ),
        1 => array("name" => "Very Low", "id" => 1, "order" => 1, "default" => false ),
        2 => array("name" => "Low", "id" => 2, "order" => 2, "default" => false ),
        3 => array("name" => "Moderate", "id" => 3, "order" => 3, "default" => false ),
        4 => array("name" => "High", "id" => 4, "order" => 4, "default" => false ),
        5 => array("name" => "Very High", "id" => 5, "order" => 5, "default" => false )
    );

    var $riskLevels = array(
        0 => array(
            "name" => "Unspecified", 
            "id" => 0, "order" => 0, 
            "default" => true, 
            "description" => "" ),
        1 => array("name" => "Minimal", "id" => 1, "order" => 1, "default" => false, 
            "description" => "Minimal or temporary disruption; easily resolved with no lasting effect." ),
        2 => array("name" => "Minor Inconvenience", "id" => 2, "order" => 2, "default" => false, 
            "description" => "Minimal or temporary disruption; easily resolved with no lasting effect." ),
        3 => array("name" => "Noticable Inconvenience", "id" => 3, "order" => 3, "default" => false, 
            "description" => "Noticeable inconvenience requiring modest time/money to fix; no long-term harm." ),
        4 => array("name" => "Moderate Disruption", "id" => 4, "order" => 4, "default" => false, 
            "description" => "Noticeable inconvenience requiring modest time/money to fix; no long-term harm." ),
        5 => array("name" => "Setback", "id" => 5, "order" => 5, "default" => false, 
            "description" => "Requires significant time, money, or effort to recover; may result in short-term functional impairment or financial strain." ),
        6 => array("name" => "Significant Setback", "id" => 6, "order" => 6, "default" => false, 
            "description" => "Requires significant time, money, or effort to recover; may result in short-term functional impairment or financial strain." ),
        7 => array("name" => "Harmful", "id" => 7, "order" => 7, "default" => false, 
            "description" => "Results in long-term functional impairment, deep financial trouble, or severe psychological distress; hospitalization required." ),
        8 => array("name" => "Life Altering", "id" => 8, "order" => 8, "default" => false, 
            "description" => "Results in long-term functional impairment, deep financial trouble, or severe psychological distress; hospitalization required." ),            
        9 => array("name" => "Permanent Catastrophe", "id" => 9, "order" => 9, "default" => false,    
            "description" => "Results in a non-recoverable loss that profoundly and permanently changes the individual's life or the lives of those closest to them." ),
        10 => array("name" => "Death / Fatality", "id" => 10, "order" => 10, "default" => false, 
            "description" => "Complete and terminal loss of life." )
    );

    var $gainLevels = array(
        0 => array( 
            "name" => "Unspecified", 
            "id" => 0, "order" => 0, 
            "default" => true, 
            "description" => "" ),
        1 => array(
            "name" => "Basic improvement", 
            "id" => 1, "order" => 1, 
            "default" => false, 
            "description" => "Basic survival needs. Improving basic survival needs." ),
        2 => array(
            "name" => "Dependency reduction", 
            "id" => 2, "order" =>2, 
            "default" => false, 
            "description" => "Reduces dependency and improves self-sufficiency." ),
        3 => array(
            "name" => "Self-Sufficiency Progress", 
            "id" => 3, "order" =>3, 
            "default" => false, 
            "description" => "Progress in foundational skills and basic financial stability " ),
        4 => array(
            "name" => "Comfort and stadbility", 
            "id" => 4, "order" =>4, 
            "default" => false, 
            "description" => "Noticeable inconvenience requiring modest time/money to fix; no long-term harm." ),
        5 => array(
            "name" => "Independence / Proficiency", 
            "id" => 5, "order" =>5, 
            "default" => false, 
            "description" => "Time management; early Financial Capital growth. Owning a first home; achieving a stable, reliable income; establishing a core social network." ),
        6 => array(
            "name" => "Abundance / Influence",
            "id" => 6, "order" =>6, 
            "default" => false, 
            "description" => "Significant Financial Capital; high Social Network leverage."),
        7 => array(
            "name" => "Wealth / Power",
            "id" => 7, "order" =>7, 
            "default" => false, 
            "description" => "High Financial Capital; strong Social Network; significant Influence; robust Personal "),
        8 => array(
            "name" => "Legacy / Significance",
            "id" => 8, "order" =>8, 
            "default" => false, 
            "description" => "Generational Financial Capital; enduring Social Network; lasting Influence; profound Personal Impact." ),
        9 => array(
            "name" => "Self-Mastery / Regional Impact",
            "id" => 9, "order" =>9, 
            "default" => false, 
            "description" => "Command over Time (time-rich); deep Intellectual Capital. Being a recognized regional expert;  achieving early financial freedom (retirement is a choice); actively shaping local policy or culture." ),
        10 => array(
            "name" => "National Renown / Legacy",
            "id" => 10, "order" =>10, 
            "default" => false, 
            "description" => "Exceptional Reputation/Renown; creation of passive, compounding Wealth. Being a nationally recognized figure (e.g., successful entrepreneur, noted scientist); creating a significant body of work; having a large philanthropic impact." ),
        11 => array(
            "name" => "Global Impact / Immortality",
            "id" => 11, "order" =>11, 
            "default" => false, 
            "description" => "Global Influence/Impact; enduring Legacy."),
        12 => array(
            "name" => "Maximum Self-Determination (The Everything)",
            "id" => 12, "order" =>12, 
            "default" => false, 
            "description" => "Absolute command of all resources (Health, Wealth, Time, Influence, Choice). Total mastery over one's life choices; having the means to overcome almost any personal challenge (health, financial, social); creating a lasting, globally recognized legacy that sustains beyond one's life." )
    );

    var $rewardsCategory = array(
        0 => array("name" => "No Reward", "id" => 0, "order" => 0, "default" => true, "type" => "none", "description" => "No reward specified."),
        1 => array("name" => "Financial Reward", "id" => 1, "order" => 1, "default" => false , "type" => "Tangible", "description" => "Bonuses, gift cards, or pay raises."),
        2 => array("name" => "Material Goods", "id" => 2, "order" => 2, "default" => false , "type" => "Tangible", "description" => "Merchandise, electronics, or other physical products."),
        3 => array("name" => "Experiences", "id" => 3, "order" => 3, "default" => false, "type" => "Tangible", "description" => "Tickets to an event or a paid trip."),
        4 => array("name" => "Privileges", "id" => 4, "order" => 4, "default" => false , "type" => "Tangible", "description" => "Extra time off or a better parking spot."),
        5 => array("name" => "Recognition and Appreciation", "id" => 5, "order" => 5, "default" => false, "type" => "Intangible", "description" => " Public praise, thank you notes, or acknowledgment in company communications."),
        6 => array("name" => "Career Development", "id" => 6, "order" => 6, "default" => false , "type" => "Intangible", "description" => "Opportunities for training, mentorship, or working on challenging projects."),
        7 => array("name" => "Work-Life Balance", "id" => 7, "order" => 7, "default" => false , "type" => "Intangible", "description" => "Flexible hours or extra time off."),
        8 => array("name" => "Positive Work Environment", "id" => 8, "order" => 8, "default" => false , "type" => "Intangible", "description" => "A supportive culture, good relationships with colleagues, and meaningful work."),
        9 => array("name" => "Autonomy and Trust", "id" => 9, "order" => 9, "default" => false , "type" => "Intangible", "description" => "Being included in decision-making or given freedom in how work is done."),
        10 => array("name" => "Confidence Boost", "id" => 10, "order" => 10, "default" => false , "type" => "Intangible", "description" => ""),
        11 => array("name" => "Mental Clarity", "id" => 11, "order" => 11, "default" => false , "type" => "Intangible", "description" => "")
    );

    var $cycles = array(
        1 => array("name" => "Once Off", "id" => 1, "order" => 1, "default" => true),
        2 => array("name" => "Daily", "id" => 2, "order" => 2, "default" => false),
        3 => array("name" => "Weekly", "id" => 3, "order" => 3, "default" => false),
        4 => array("name" => "Monthly", "id" => 4, "order" => 4, "default" => false),
        5 => array("name" => "Quarterly", "id" => 5, "order" => 5, "default" => false),
        6 => array("name" => "Bi-Annually", "id" => 6, "order" => 6, "default" => false),
        7 => array("name" => "Annually", "id" => 7, "order" => 7, "default" => false)
    );

    var $scales = array(
        1 => array("name" => "Microtask", "id" => 1, "order" => 1, "default" => true),
        2 => array("name" => "Task", "id" => 2, "order" => 2, "default" => false),
        3 => array("name" => "Activity", "id" => 3, "order" => 3, "default" => false),
        4 => array("name" => "Ritual / Ceremony / Habit  / Protocol / Routine", "id" => 4, "order" => 4, "default" => false),
        5 => array("name" => "Project", "id" => 5, "order" => 5, "default" => false),
        6 => array("name" => "Program", "id" => 6, "order" => 6, "default" => false),
        7 => array("name" => "Megaproject", "id" => 7, "order" => 7, "default" => false),
    );

    var $scopes = array(
        1 => array("name" => "Personal & Private", "id" => 1, "order" => 1, "default" => true),
        2 => array("name" => "Personal & Public", "id" => 2, "order" => 2, "default" => false),
        3 => array("name" => "Group & Private", "id" => 3, "order" => 3, "default" => false),
        4 => array("name" => "Group & Public", "id" => 4, "order" => 4, "default" => false),
        5 => array("name" => "Organisational & Private", "id" => 5, "order" => 5, "default" => false),
        6 => array("name" => "Organisational & Public", "id" => 6, "order" => 6, "default" => false),
        7 => array("name" => "Regional / Natoional", "id" => 7, "order" => 7, "default" => false),
        8 => array("name" => "Global / Planetary", "id" => 8, "order" => 8, "default" => false) 
    );

    var $difficultyLevels = array(
        0 => array("name" => "Unspecified", "id" => 0, "order" => 0, "default" => true ),
        1 => array("name" => "Easy", "id" => 1, "order" => 1, "default" => false ),
        2 => array("name" => "Moderate", "id" => 2, "order" => 2, "default" => false ),
        3 => array("name" => "Intermediate", "id" => 3, "order" => 3, "default" => false ),
        4 => array("name" => "Advanced", "id" => 4, "order" => 4, "default" => false ),
        5 => array("name" => "Expert", "id" => 5, "order" => 5, "default" => false ),
        6 => array("name" => "Organizational", "id" => 6, "order" => 6, "default" => false),
        7=> array("name" => "Industrial", "id" => 7, "order" => 7, "default" => false),
        8 => array("name" => "National", "id" => 8, "order" => 8, "default" => false ),
        9 => array("name" => "Global", "id" => 9, "order" => 9, "default" => false )
    );

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
        $data["importanceLevels"] = $this->importanceLevels;
        $data["urgencyLevels"] = $this->urgencyLevels;
        $data["riskLevels"] = $this->riskLevels;
        $data["gainLevels"] = $this->gainLevels;
        $data["rewardsCategory"] = $this->rewardsCategory;
        $data["cycles"] = $this->cycles;
        $data["scales"] = $this->scales;
        $data["scopes"] = $this->scopes;
        $data["difficultyLevels"] = $this->difficultyLevels;
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
        $data["importanceLevels"] = $this->importanceLevels;
        $data["urgencyLevels"] = $this->urgencyLevels;
        $data["riskLevels"] = $this->riskLevels;
        $data["gainLevels"] = $this->gainLevels;
        $data["rewardsCategory"] = $this->rewardsCategory;
        $data["cycles"] = $this->cycles;
        $data["scales"] = $this->scales;
        $data["scopes"] = $this->scopes;
        $data["difficultyLevels"] = $this->difficultyLevels;
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

    public function history(){
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper("date_helper");
        $this->load->helper("expense_statistics_helper");
        $this->load->library('form_validation');
        $userId = $this->session->userdata("user")->id;
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        $data["importanceLevels"] = $this->importanceLevels;
        $data["urgencyLevels"] = $this->urgencyLevels;
        $data["riskLevels"] = $this->riskLevels;
        $data["gainLevels"] = $this->gainLevels;
        $data["rewardsCategory"] = $this->rewardsCategory;
        $data["cycles"] = $this->cycles;
        $data["scales"] = $this->scales;
        $data["scopes"] = $this->scopes;
        $data["difficultyLevels"] = $this->difficultyLevels;
        $data["startAndEndDateforMonth"] = getStartAndEndDateforYear( date('Y'));
        // print_r($data["startAndEndDateforMonth"]);
        $this->load->helper("tasks_helper");
        $tasks = $this->tasks_model->getTasksByDateRange($data["startAndEndDateforMonth"][0], $data["startAndEndDateforMonth"][1], $userId);
        foreach($tasks as $task){
            $age = getTaskAgeByCreateDate($task);
            $task["age"] = $age;
            $data["tasks"][] = $task;
        }
        // print_r($data["tasks"]);
        $data["history_table"] = $this->load->view('tasks/history_table', $data, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "History", ""));
        $this->load->view('tasks/tasks_nav');
        $this->load->view('tasks/history', $data);
        $this->load->view('footer');            
    }

    public function dashboard(){
        $this->load->helper("date_helper");
        $this->load->helper("tasks_helper");
        $userId = $this->session->userdata("user")->id;
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        $data["importanceLevels"] = $this->importanceLevels;
        $data["urgencyLevels"] = $this->urgencyLevels;
        $data["riskLevels"] = $this->riskLevels;
        $data["gainLevels"] = $this->gainLevels;
        $data["rewardsCategory"] = $this->rewardsCategory;
        $data["cycles"] = $this->cycles;
        $data["scales"] = $this->scales;
        $data["scopes"] = $this->scopes;
        $data["difficultyLevels"] = $this->difficultyLevels;        
        $data["startAndEndDateforMonth"] = getStartAndEndDateforYear( date('Y'));
        $data["tasks"] = $this->tasks_model->getTasks(  $this->session->userdata("user")->id);
        $incompleteTasksAges = 0;
        $statusesOfIncompleteTasks = array(1,3,4,5,6,7,8);
        $completeTasks = array(2);
        $completedTasksAges = array();
        $data["tasksPastStartDate"] = $this->tasks_model->getTasksPastStartDate($userId, date('Y-m-d'), $statusesOfIncompleteTasks);
        // print_r($data["tasksPastStartDate"]);
        $data["tasksPastStartDateAged"] = array();
        foreach($data["tasksPastStartDate"] as $task){
            $age = getTaskAgeByCreateDate($task);
            $task["age"] = $age;
            $task["targetted_age"] = getTaskTargettedAgeByStartDate($task);
            $data["tasksPastStartDateAged"][] = $task;
        }
        foreach($data["tasks"] as $task){
            if($task["status_id"] == 2){
                // print_r($task);
                $age = getTaskAgeByStartDateAndEndDate($task);
                $task["targetted_age"] = getTaskTargettedAgeByStartDate($task);
                $task["age"] = $age;
                $completedTasksAges[] = $task;
            }
        }
        $data["completedTasksAgesArr"] = $completedTasksAges;
        $data["incompleteAverageAge"] = 0;
        $incomepleteAverageAgeRange = 0;
        $data["dashboard_content"] = $this->load->view('tasks/dashboard_content', $data, true);
        // $data["dashboard_overview"] = $this->load->view('tasks/dashboard_overview', $data, true);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Dashboard", ""));
        $this->load->view('tasks/tasks_nav');
        $this->load->view('tasks/dashboard_overview', $data);
        $this->load->view('footer');            
    }

    public function dashboardFilteredSearch() {
        $this->load->helper("date_helper");
        $this->load->helper("tasks_helper");
        $userId = $this->session->userdata("user")->id;
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        $data["importanceLevels"] = $this->importanceLevels;
        $data["urgencyLevels"] = $this->urgencyLevels;
        $data["riskLevels"] = $this->riskLevels;
        $data["gainLevels"] = $this->gainLevels;
        $data["rewardsCategory"] = $this->rewardsCategory;
        $data["cycles"] = $this->cycles;
        $data["scales"] = $this->scales;
        $data["scopes"] = $this->scopes;
        $data["difficultyLevels"] = $this->difficultyLevels;
        $data["startAndEndDateforMonth"] = array($this->input->post("fromDate"), $this->input->post("toDate"));
        $data["tasks"] = $this->tasks_model->getTasksByCriteria( $userId );
        $incompleteTasksAges = 0;
        $statusesOfIncompleteTasks = array(1,3,4,5,6,7,8);
        $completeTasks = array(2);
        $completedTasksAges = array();
        $data["tasksPastStartDate"] = $this->tasks_model->getTasksPastStartDate($userId, date('Y-m-d'), $statusesOfIncompleteTasks);
        // print_r($data["tasksPastStartDate"]);
        $data["tasksPastStartDateAged"] = array();
        foreach($data["tasksPastStartDate"] as $task){
            $age = getTaskAgeByCreateDate($task);
            $task["age"] = $age;
            $task["targetted_age"] = getTaskTargettedAgeByStartDate($task);
            $data["tasksPastStartDateAged"][] = $task;
        }
        foreach($data["tasks"] as $task){
            if($task["status_id"] == 2){
                // print_r($task);
                $age = getTaskAgeByStartDateAndEndDate($task);
                $task["targetted_age"] = getTaskTargettedAgeByStartDate($task);
                $task["age"] = $age;
                $completedTasksAges[] = $task;
            }
        }
        $data["completedTasksAgesArr"] = $completedTasksAges;
        $data["incompleteAverageAge"] = 0;
        $incomepleteAverageAgeRange = 0;
        echo $this->load->view('tasks/dashboard_content', $data, true);
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
            $data["importanceLevels"] = $this->importanceLevels;
            $data["urgencyLevels"] = $this->urgencyLevels;
            $data["riskLevels"] = $this->riskLevels;
            $data["gainLevels"] = $this->gainLevels;
            $data["rewardsCategory"] = $this->rewardsCategory;
            $data["cycles"] = $this->cycles;
            $data["scales"] = $this->scales;
            $data["scopes"] = $this->scopes;
            $data["difficultyLevels"] = $this->difficultyLevels;
            $this->load->view('header', $data);
            $this->load->view('tasks/tasks_nav');
            $this->load->view('user/user_status', $data);
            $this->load->view('tasks/view', $data);
            $this->load->view('footer');
        }
    }

    public function updateShort() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $userId = $this->session->userdata("user")->id;
        $id = $this->input->post('id');
        $this->form_validation->set_rules('description', 'description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post("id"));
        }else{
            $this->tasks_model->update_short($this->input->post('id'));
            redirect("/tasks", "refresh");
        }
    }

    public function filteredSearch() {
        $userId = $this->session->userdata("user")->id;
        $data["tasksHistory"] = $this->tasks_model->getTasks($userId, 100);
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        $data["importanceLevels"] = $this->importanceLevels;
        $data["urgencyLevels"] = $this->urgencyLevels;
        $data["riskLevels"] = $this->riskLevels;
        $data["gainLevels"] = $this->gainLevels;
        $data["rewardsCategory"] = $this->rewardsCategory;
        $data["cycles"] = $this->cycles;
        $data["scales"] = $this->scales;
        $data["scopes"] = $this->scopes;
        $data["difficultyLevels"] = $this->difficultyLevels;        
        // $data["tasks"] = $this->tasks_model->getTasksByCriteria($userId);
        $this->load->helper("tasks_helper");
        $tasks = $this->tasks_model->getTasksByCriteria($userId);
        if ($tasks == null || count($tasks) == 0){
            $data["tasks"] = null;
        }
        foreach($tasks as $task){
            $age = getTaskAgeByCreateDate($task);
            $task["age"] = $age;
            $data["tasks"][] = $task;
        }
        // $this->load->view('tasks/history_table', $data);      
        
        $this->load->helper('url');
        $this->load->helper('form');
        $data["startAndEndDateforMonth"] = array($this->input->post("fromDate"), $this->input->post("toDate"));
        echo $this->load->view('tasks/history_table', $data, true);
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

    public function taskView($id){
        $userId = $this->session->userdata("user")->id;
        $data["tasksDomains"] = mapKeyToId($this->tasks_domains_model->get_user_tasks_domains($userId, 50));
        $data["tasksStatuses"] = mapKeyToId($this->tasks_status_model->get_user_tasks_statuses($userId), false);
        $data["importanceLevels"] = $this->importanceLevels;
        $data["urgencyLevels"] = $this->urgencyLevels;
        $data["riskLevels"] = $this->riskLevels;
        $data["gainLevels"] = $this->gainLevels;
        $data["rewardsCategory"] = $this->rewardsCategory;
        $data["cycles"] = $this->cycles;
        $data["scales"] = $this->scales;
        $data["scopes"] = $this->scopes;
        $data["difficultyLevels"] = $this->difficultyLevels;        
        if ($this->tasks_model->doesItBelongToMe($userId, $id)) {
            $data["task"] = $this->tasks_model->getTask($id);
            $this->load->view('header', getPageTitle($data, $this->toolName, "Task View", ""));
            $this->load->view('tasks/tasks_nav');
            $this->load->view('tasks/task_view', $data);
            $this->load->view('footer');
        } else {
            $data["tasks"] =$this->tasks_model->getTasks($this->session->userdata("user")->id, 50);
            $data["status"] = "View Task";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Unable to view the task";
            $data["message_classes"] = "failure";
            $data["message"] = "The task you are attempting to view does not exist or does not belong to you.";
            $data["reUrl"] = "/tasks";
            $this->session->set_flashdata("error", $this->load->view('general/action_status', $data, true));
            redirect("/tasks", "refresh");
        }
    }

}