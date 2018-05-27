<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of resource
 *
 * @author francois
 */
class resource extends CI_Controller {

    var $toolId = 9;
    var $toolName = "Resources";
    var $require_auth = TRUE;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('auth_helper');
        $this->load->helper("array_helper");
        $this->load->helper('usability_helper');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->helper('tool_info_helper');
        $this->load->library('form_validation');
        $this->load->model("user_content_model");
        can_access(
                $this->require_auth, $this->session);
        $this->load->library('pagination');
    }

    public function index($page = null) {
        if ($page == null) {
            $config['base_url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/resources/page/1';
            $config['per_page'] = 10;
            $config['total_rows'] = 10;
            $this->pagination->initialize($config);
        } else {
            $this->pagination->uri_segment = 3;
        }
        $this->pagination->base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/resources/page/';
        $this->pagination->per_page = 10;
        $this->pagination->use_page_numbers = TRUE;
        $this->pagination->cur_page = $page;
        $user = $this->session->userdata("user");
        $data["resources"] = $this->user_content_model->getUserContentItems(
                $user->id, $this->pagination->per_page, (($page != null) ? ($page - 1) * $this->pagination->per_page : null));
        $data["totalResources"] = $this->pagination->total_rows = $this->user_content_model->getUserContentItems($user->id, null, null, true);

        $data["error"] = '';
        $this->load->model("user_content_model");
        $data["statusArr"] = $this->session->flashdata('status');

//        $userId = $this->session->userdata("user")->id;
//        $data["resources"] = $this->user_content_model->getUserContentItems($userId);
        $data["tools"] = getAllToolsInfo();
        $this->load->view('header', getPageTitle($data, $this->toolName, "List", ""));
        $this->load->view('resources/resources_nav');
        if (!empty($data["statusArr"])) {
            $data["status"] = $data["statusArr"]["status"];
            $data["action_classes"] = strtolower($data["statusArr"]["status"]);
            $data["action_description"] = $data["statusArr"]["message"];
            $data["message_classes"] = strtolower($data["statusArr"]["status"]);
            $data["message"] = $data["statusArr"]["description"];
            $this->load->view('user/user_status', $data);
        }
        $this->load->view('resources/view', $data);
        $this->load->view('footer');
    }

    public function do_upload() {
        $userId = $this->session->userdata("user")->id;
        $data["user_content"] = $this->user_content_model->uploadContent(
                $userId, 'gif|jpeg|png|txt|pdf|doc|docx|xls|xlsx|json', $this->toolId, 100000000, $private = 0, $passwordProtect = 0, $this->input->post("description"));
//        print_r($data["user_content"]);
        if (key_exists("error", $data["user_content"])) {
//            $this->load->view('resources/view', $data["user_content"]["error"]);
            $data["statusArr"]["status"] = "Failure";
            $data["statusArr"]["message"] = "Unable to upload the resource.";
            $data["statusArr"]["description"] = $data["user_content"]["error"];
        } else {
            $data["statusArr"]["status"] = "Success";
            $data["statusArr"]["message"] = $data["user_content"]["filename"] . " has been added.";
            $data["statusArr"]["description"] = "You have successfully uploaded file: " . $data["user_content"]["filename"];
        }

        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("/resources", "refresh");
    }

    public function delete($id = null) {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');

        $userId = $this->session->userdata("user")->id;
        if ($id != null) {
            $item = $this->user_content_model->getUserContentitem($userId, $id);
            if (file_exists($item->full_path)) {
                if (unlink($item->full_path)) {
                    $data["statusArr"] = $this->user_content_model->deleteItem($userId, $id);
                } else {
                    $data["statusArr"]["status"] = "Failure";
                    $data["statusArr"]["message"] = "Unable to delete the resource: error when trying to delete the file.";
                    $data["statusArr"]["description"] = $item->original_name . " has not been deleted.";
                    $data["statusArr"]["affectedRows"] = 0;
                }
            } else {
                $data["statusArr"] = $this->user_content_model->deleteItem($userId, $id);
            }
        }
        $data["resources"] = $this->user_content_model->getUserContentItems($userId);
        $data["tools"] = getAllToolsInfo();
        $this->session->set_flashdata('status', $data["statusArr"]);
        redirect("/resources", "refresh");
    }
    
    public function getStats() {
        $this->load->library('session');
        $this->load->helper('resource');

        $userId = $this->session->userdata("user")->id;
        $data["resourceStats"] = $this->user_content_model->getUserContentStats($userId);
        $data["resourceStats"]["total_filesizes"] = humanReadifyFilesize($data["resourceStats"]["total_filesizes"]);
        $data["tools"] = getAllToolsInfo();
        $data["resourceStats"]["total_for_user_per_tool"] = formatStatsperTool($data["resourceStats"]["total_for_user_per_tool"],$data["tools"] );
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        $this->load->view('header', getPageTitle($data, $this->toolName, "Statistics", ""));
        $this->load->view('resources/resources_nav');
        $this->load->view('resources/user_stats', $data);
        $this->load->view('footer');
    }

    public function view($id, $filename) {
        $userId = $this->session->userdata("user")->id;
        $item = $this->user_content_model->getUserContentitem($userId, $id);
//        print_r($item);
//        exit;
//        echo $item->full_path;
//        exit;

        if (file_exists($item->full_path)) {
            $fp = fopen($item->full_path, 'rb');
//            header('Content-Description: File Transfer');
//            header('Content-Type: application/octet-stream');
//            header('Content-Disposition: attachment; filename="' . $item->filename . '"');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header('Content-Length: ' . $item->filezise);
//            readfile($item->full_path);
            header('Content-Type: ' . $item->file_type);
            header('Content-Length: ' . filesize($item->full_path));
            header("Cache-Control: public");
            header("Content-Transfer-Encoding: binary\n");
//            header("Content-Disposition: attachment; file=\"".$item->filename."\"");
//            readfile($item->full_path);
//            exit;   
            fpassthru($fp);
            exit;
        }
    }

    public function download($id, $filename) {
        $userId = $this->session->userdata("user")->id;
        $item = $this->user_content_model->getUserContentitem($userId, $id);

        if (file_exists($item->full_path)) {
            $fp = fopen($item->full_path, 'r');
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $item->filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header('Content-Length: ' . $item->filezise);
            //header('Content-Type: '.$item->file_type);
            header('Content-Length: ' . filesize($item->full_path));
//            header("Cache-Control: public");
            header("Content-Transfer-Encoding: binary\n");
            readfile($item->full_path);
//            readfile($item->full_path);
//            exit;   
//            fpassthru($fp);
            exit;
        }
    }

}
