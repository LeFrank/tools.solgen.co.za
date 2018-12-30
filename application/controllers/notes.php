<?php

class Notes extends CI_Controller {

    var $toolId = 5;
    var $toolName = "Notes";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->helper('auth_helper');
        $this->load->helper("date_helper");
        $this->load->helper("notes_stats_helper");
        $this->load->helper('usability_helper');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        can_access(
                $this->require_auth, $this->session);
        $this->load->model('notes_model');
        $this->load->model('notes_template_model');
        $this->load->model('notes_search_model');
        $this->load->model('user_configs_model');
        $this->load->library('pagination');
        $data["globalTitle"] = $this->toolName;
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
        $user = $this->session->userdata("user");
        $data['title'] = 'Delete a note';
        $data["action_description"] = "Delete a note";
        if ($this->notes_model->doesItBelongToMe($user->id, $id)) {
            $this->notes_model->delete($id);
            $data["status"] = "Deleted Note";
            $data["action_classes"] = "success";
            $data["message_classes"] = "success";
            $data["message"] = "The note was deleted";
        } else {
            $data["status"] = "Note does not belong to you.";
            $data["action_classes"] = "faliure";
            $data["message_classes"] = "failure";
            $data["message"] = "The note was not deleted";
        }
        redirect("/notes", "refresh");
    }

    public function edit($id = null) {
        $this->load->helper('user_config_helper');
        $user = $this->session->userdata("user");
        $data["note"] = $this->notes_model->getNote($user->id, $id);
        $data["exitCheck"] = true;
        $data["userNotesConfigs"] = mapKeyToValue($this->user_configs_model->getUserConfigsByToolId($user->id , $this->toolId));
//        echo "<pre>";
//        print_r($data["userNotesConfigs"]);
//        echo "</pre>";
        $data["notes_templates"] = $this->notes_template_model->getNotesTemplates($user->id);
        $this->load->view('header', getPageTitle($data, $this->toolName, "Edit", $data["note"]->heading));
        $this->load->view('notes/notes_nav', $data);
        $this->load->view("notes/capture_form", $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }

    public function history($page = null) {
        if ($page == null) {
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/notes/history/page/1';
            $config['per_page'] = 10;
            $config['total_rows'] = 10;
            $this->pagination->initialize($config);
        } else {
            $this->pagination->uri_segment = 4;
        }
        $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/notes/history/page/';
        $this->pagination->per_page = 10;
        $this->pagination->use_page_numbers = TRUE;
        $this->pagination->cur_page = $page;
        $user = $this->session->userdata("user");
        $data["notes"] = $this->notes_model->getNotes(
                $user->id, $this->pagination->per_page, (($page != null) ? ($page-1) * $this->pagination->per_page : null));
        $data["totalNotes"] = $this->pagination->total_rows = $this->notes_model->getNotes($user->id, null, null, true);
        $data["searches"] = $this->notes_search_model->getSearches($user->id, 10, null, false);
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('notes/notes_nav', $data);
        $data["notes_templates"] = $this->notes_template_model->getNotesTemplates($user->id);
        $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
        $this->load->view('notes/history', $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }

    /**
     * 	Display and capture a note
     */
//    public function index() {
//        $this->load->library('session');
//        $user = $this->session->userdata("user");
//        $data["notes"] = $this->notes_model->getNotes($user->id, 5);
//        $this->load->view('header');
//        $this->load->view('notes/notes_nav', $data);
//        $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
//        $this->load->view('notes/index', $data);
//        $this->load->view('notes/notes_includes', $data);
//        $this->load->view('footer');
//    }

    public function searchHistory($searchId = null, $page = null) {
        $this->load->model('notes_search_model');
        if ($page == null) {
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/notes/history/search/' . $searchId . '/page/';
            $config['per_page'] = $config['total_rows'] = 10;
            $this->pagination->initialize($config);
            $this->notes_search_model->updateReSearchCount($searchId);
            $page = 1;
        } else {
            $this->pagination->uri_segment = 6;
        }
        $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/notes/history/search/' . $searchId . '/page/';
        $this->pagination->per_page = 10;
        $this->pagination->use_page_numbers = TRUE;
        $this->pagination->cur_page = $page;
        $user = $this->session->userdata("user");
        $data["search"] = $this->notes_search_model->getSearchById($user->id, $searchId);
        $data["searches"] = $this->notes_search_model->getSearches($user->id, 10, null, false);
//        echo (($page != null) ? ( $page - 1 ) * $this->pagination->per_page : $this->pagination->per_page);
        $data["notes"] = $this->notes_model->searchNotesCriteria($user->id, (($page != null) ? ( $page - 1 ) * $this->pagination->per_page : $this->pagination->per_page), (($page != null) ? ( $page - 1 ) * $this->pagination->per_page : null), false, $data["search"][0]["text"], $data["search"][0]["start_date"], $data["search"][0]["end_date"]);
        $data["totalNotes"] = $this->pagination->total_rows = $data["total_returned"] = $this->notes_model->searchNotesCriteria($user->id, null, null, true, $data["search"][0]["text"], $data["search"][0]["start_date"], $data["search"][0]["end_date"]);
        $data["notes_templates"] = $this->notes_template_model->getNotesTemplates($user->id);

        $this->load->view('header', getPageTitle($data, $this->toolName, "Search", $data["search"][0]["text"] . " (". $data["total_returned"] .")"));
        $this->load->view('notes/notes_nav', $data);
        $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
        $this->load->view('notes/history', $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }

    public function searchHistorySave() {
        $this->load->model('notes_search_model');
        $searchId = $this->notes_search_model->capture_note_search();
        redirect("/notes/history/search/" . $searchId);
    }

    public function tags($page = null) {
        $this->load->helper('note_helper');
        $user = $this->session->userdata("user");
        $data["notes"] = $this->notes_model->getTags($user->id);
        $data["tags"] = getUniqueTagItems($data["notes"]);
        $this->load->view('header');
        $this->load->view('notes/notes_nav', $data);
        $data["capture_form"] = "";
        $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
        $this->load->view('notes/tags', $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }

    /**
     * Post
     */
    public function getTagContentByString() {
        $user = $this->session->userdata("user");
        $data["notes"] = $this->notes_model->getNotesByTag($user->id, $this->input->post("tagVal"));
        $this->load->view("notes/tag_notes", $data);
    }

    public function options(){
        $data["options"] = "";
//        $data["templates"] = array(
//            array("id"=>0, "name"=>"Income", "description"=>"Every month or so I capture a standard formatted note of my salary information for that month. Would be handy to have a template to speed up the process.", 
//                "titleTemplate" => "Income for ", 
//                "contentTemplate" => "<p>Nett salary: R 0.00</p>
//<p>Left over from MONTH: R 0.00</p>
//<p>Available for XXXXX Period: R 0.</p>
//<p>Other incomes:<ul><li>Income From: MONTH, Amount: XXXXX</li></ul></p>" ),
//            array("id" =>1, 
//                "name"=>"Dossier", 
//                "description"=> "When meeting someone for the first time and taking a keen interest in them, I like to remember important information about them. I call this a docier.", 
//                "titleTemplate" => "",
//                "contentTemplate" => "
//<h3>Physical Attributes</h3>
//<p>Age: XXXX</p>
//<p>Sex: Male/Female</p>
//<p>Race: Asian/ Black/ Coloured/ White </p>
//<p>Marital Status: Single/ Divorced/ Widowed/ Married/ Other</p>
//<p>Height: XXX cm tall</p>
//<p>Weight: XXX KG</p>
//<p>Hair colour: Black / Blonde/ Brown/ Red/ Other</p>
//<p>Skin Colour: Asian/ Black/ Coloured/ White</p>
//<p>Eye Colour: Black/ Blue/ Brown/ Green/ Grey/ Other </p>
//<p>Health: Poor/ OK/ Good</p>
//
//<h3>Strengths:</h3>
//<ul>
//    <li></li>
//</ul>
//<h3>Weaknesses:</h3>
//<ul>
//    <li></li>
//</ul>
//"
//                )
//        );
        $this->load->helper('user_config_helper');
        $user = $this->session->userdata("user");
        $data["userNotesConfigs"] = mapKeyToValue($this->user_configs_model->getUserConfigsByToolId($user->id , $this->toolId));
//        echo "<pre>";
//        print_r($data["userNotesConfigs"]);
//        echo "</pre>";
        $data["notes_templates"] = $this->notes_template_model->getNotesTemplates($user->id);
        $data["determinator"]["lb"] = "Less required is better.";
        $data["determinator"]["mb"] = "More required is better.";
        $data["rankingMeasurements"] = array(
            array("id"=>0, "name"=>"Money", "description"=>"The monetary cost to aquire/ accomplish/ abandone goal. Less is better.", "positiveDeterminatior" => "lb"),
            array("id" =>1, "name"=>"Time", "description"=> "Time required to complete the task or goal. Less is Better", "positiveDeterminatior"=> "lb"),
            array("id" =>2, "name"=>"Assistance", "description"=> "Will the assistance of others be required and what scale.", "positiveDeterminatior"=> "lb"),
            array("id" =>3, "name"=>"Mental Processing", "description"=> "Time required to complete the task or goal.", "positiveDeterminatior" => "lb"),
            array("id" =>4, "name"=>"Courage", "description"=> "The courage to perform the action, task or goal is achieved until there is a threshold of believe. Where that threshold is, is influenced by how much or rather how little courage is required to take action.", "positiveDeterminatior" => "lb"),
            array("id" =>5, "name"=>"Persistence", "description"=> "The measure of much continuing in an opinion or course of action in spite of difficulty or opposition will require.", "positiveDeterminatior" => "lb")
        );
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('notes/notes_nav', $data);
        $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
        $this->load->view('notes/options', $data);
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
            redirect("/notes/view-note/" . $this->input->post('id'), "refresh");
        }
    }

    public function viewStats() {
        $user = $this->session->userdata("user");
        $data["startAndEndDateforMonth"] = getStartAndEndDateforMonth(date("m"), date('Y'));

        if ($this->input->post('fromDate') == null) {
            $data["totalNotes"] = $this->notes_model->getTotalNumberOfNotesForUser($user->id, date('Y/m/d H:i', strtotime($data["startAndEndDateforMonth"][0])), date('Y/m/d H:i', strtotime($data["startAndEndDateforMonth"][1])));
            $data["notes"] = $this->notes_model->getNotesForPeriod($user->id, date('Y/m/d H:i', strtotime($data["startAndEndDateforMonth"][0])), date('Y/m/d H:i', strtotime($data["startAndEndDateforMonth"][1])));
        } else {
            $data["startAndEndDateforMonth"][0] = date('Y/m/d H:i', strtotime($this->input->post('fromDate')));
            $data["startAndEndDateforMonth"][1] = date('Y/m/d H:i', strtotime($this->input->post('toDate')));
            $data["totalNotes"] = $this->notes_model->getTotalNumberOfNotesForUser($user->id, date('Y/m/d H:i', strtotime($this->input->post('fromDate'))), date('Y/m/d H:i', strtotime($this->input->post('toDate'))));
            $data["notes"] = $this->notes_model->getNotesForPeriod($user->id, date('Y/m/d H:i', strtotime($this->input->post('fromDate'))), date('Y/m/d H:i', strtotime($this->input->post('toDate'))));
        }
        $data["averageNotesPerPeriod"] = round($data["totalNotes"] / ( floor((strtotime($data["startAndEndDateforMonth"][1]) - strtotime($data["startAndEndDateforMonth"][0])) / (60 * 60 * 24)) + 1 ), 2);
        $data["hourOfDay"] = getNotesForHourOfDay($data["notes"]);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->load->view('header');
            $this->load->view('notes/notes_nav', $data);
            $this->load->view('notes/stats', $data);
            $this->load->view('notes/notes_includes', $data);
            $this->load->view('footer');
        } else {
            echo $this->load->view('notes/stats', $data, true);
        }
    }

    public function viewNote($id) {
        $this->load->library('session');
        $user = $this->session->userdata("user");
        if ($this->notes_model->doesItBelongToMe($this->session->userdata("user")->id, $id)) {
            $data["note"] = $this->notes_model->getNote($user->id,$id);
            $data["searches"] = $this->notes_search_model->getSearches($user->id, 10, null, false);
            $this->load->view('header', getPageTitle($data, $this->toolName, "View", $data["note"]->heading));
            $this->load->view('notes/notes_nav', $data);
            $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
            $this->load->view("notes/view_note", $data);
            $this->load->view('notes/notes_includes', $data);
            $this->load->view('footer');
        }
//        $data["note"] = $this->notes_model->getNote($id);
//        $this->load->view('header');
//        $this->load->view('notes/notes_nav', $data);
//        $this->load->view("notes/capture_form", $data);
//        $this->load->view('notes/notes_includes', $data);
//        $this->load->view('footer');
    }
    
    public function templateIndex() {
        $user = $this->session->userdata("user");
        $data[] = array();
        // Get and list templates
        $data["notes_templates"] = $this->notes_template_model->getNotesTemplates($user->id);
        //CRUD templates
        
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('notes/notes_nav', $data);
        $data["capture_form"] = $this->load->view("notes/templates/template_capture_form", $data, TRUE);
        $this->load->view('notes/templates/index', $data);
        $this->load->view('notes/templates/template_includes', $data);
        $this->load->view('footer');
    }
    
    public function templateCreate(){
        $user = $this->session->userdata("user");
//        print_r($this->input->post());
        $this->load->helper('user_config_helper');
        $data["userNotesConfigs"] = mapKeyToValue($this->user_configs_model->getUserConfigsByToolId($user->id , $this->toolId));
        $this->notes_template_model->capture_note_template();
        $data["notes_templates"] = $this->notes_template_model->getNotesTemplates($user->id);
        $data["determinator"]["lb"] = "Less required is better.";
        $data["determinator"]["mb"] = "More required is better.";
        $data["rankingMeasurements"] = array(
            array("id"=>0, "name"=>"Money", "description"=>"The monetary cost to aquire/ accomplish/ abandone goal. Less is better.", "positiveDeterminatior" => "lb"),
            array("id" =>1, "name"=>"Time", "description"=> "Time required to complete the task or goal. Less is Better", "positiveDeterminatior"=> "lb"),
            array("id" =>2, "name"=>"Assistance", "description"=> "Will the assistance of others be required and what scale.", "positiveDeterminatior"=> "lb"),
            array("id" =>3, "name"=>"Mental Processing", "description"=> "Time required to complete the task or goal.", "positiveDeterminatior" => "lb"),
            array("id" =>4, "name"=>"Courage", "description"=> "The courage to perform the action, task or goal is achieved until there is a threshold of believe. Where that threshold is, is influenced by how much or rather how little courage is required to take action.", "positiveDeterminatior" => "lb"),
            array("id" =>5, "name"=>"Persistence", "description"=> "The measure of much continuing in an opinion or course of action in spite of difficulty or opposition will require.", "positiveDeterminatior" => "lb")
        );
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('notes/notes_nav', $data);
        $data["capture_form"] = $this->load->view("notes/capture_form", $data, TRUE);
        $this->load->view('notes/options', $data);
        $this->load->view('notes/notes_includes', $data);
        $this->load->view('footer');
    }
    
    public function templateEdit($templateId){
        $user = $this->session->userdata("user");
//        print_r($this->input->post());
        $this->load->helper('user_config_helper');
        $data["userNotesConfigs"] = mapKeyToValue($this->user_configs_model->getUserConfigsByToolId($user->id , $this->toolId));
        $data["note_template"] = $this->notes_template_model->getNotesTemplate($user->id, $templateId);
        $this->load->view('header', getPageTitle($data, $this->toolName, "History"));
        $this->load->view('notes/notes_nav', $data);
        $this->load->view("notes/templates/template_capture_form", $data);
        $this->load->view('notes/templates/template_includes', $data);
        $this->load->view('footer');
    }
    
    public function templateDelete($templateId){
        $user = $this->session->userdata("user");
        $data['title'] = 'Delete a note template';
        $data["action_description"] = "Deleting a note template";
        if ($this->notes_template_model->doesItBelongToMe($user->id, $templateId)) {
            $this->notes_template_model->delete($templateId);
            $data["status"] = "Deleted Note Template";
            $data["action_classes"] = "success";
            $data["message_classes"] = "success";
            $data["message"] = "The note template was deleted";
        } else {
            $data["status"] = "Note template does not belong to you.";
            $data["action_classes"] = "faliure";
            $data["message_classes"] = "failure";
            $data["message"] = "The note template was not deleted";
        }
        redirect("/notes/templates", "refresh");
    }
    
    public function templateUpdate(){
        $user = $this->session->userdata("user");
        $data['title'] = 'Update a note template';
        $this->form_validation->set_rules('template_content', 'template_content', 'required');
        $data["status"] = "Update Note Template";
        $data["action_description"] = "Update a note template";
        if ($this->form_validation->run() == FALSE) {
            $data["action_classes"] = "faliure";
            $data["message_classes"] = "failure";
            $data["message"] = "The note template was not updated";
            // Get and list templates
            $data["notes_templates"] = $this->notes_template_model->getNotesTemplates($user->id);
            $this->load->view('header');
            $this->load->view('notes/notes_nav', $data);
            $data["capture_form"] = $this->load->view("notes/templates/template_capture_form", $data, TRUE);
            $this->load->view('general/action_status', $data);
            $this->load->view('notes/templates/index', $data);
            $this->load->view('notes/templates/template_includes', $data);
            $this->load->view('footer');
        } else {
            $data["note_template"] = $this->notes_template_model->update();
            redirect("/notes/templates/", "refresh");
        }
    }
    
    public function getTemplate($templateId){
        $user = $this->session->userdata("user");
//        print_r($this->input->post());
        echo json_encode($this->notes_template_model->getNotesTemplate($user->id, $templateId));
    }

    public function optionsUpdate($optionId){
        $userId = $this->session->userdata("user")->id;
        $data = array();
        $config = $this->user_configs_model->getUserConfig($userId, $optionId);
        $config->val = $this->input->post("value");
        $this->user_configs_model->update($config);
        echo $this->user_configs_model->getUserConfig($userId, $optionId)->val;
    }
}
