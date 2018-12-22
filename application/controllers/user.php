<?php
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper("form");
        $this->load->library("form_validation");
        $this->load->helper('auth_helper');
    }

    public function register() {
        $this->load->helper('email');
        $data['title'] = 'Register';

        $this->form_validation->set_rules('email', 'email', 'required|is_unique[solgen_user.email]');
        $this->form_validation->set_message('is_unique', 'You have already registered an account with that Email address.</br>' .
                ' To retrieve rest your password please click on the "Forgotten Password" link,<br/' .
                '> on the top right corner of this page.');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('user/register');
            $this->load->view('footer');
        } else {
            $res = $this->user_model->set_user();
            if ($res == 1) {
                $this->setDefaultUserConfigs();
                $message = $this->load->view('user/registered_confirmation_email_form.php', $data, TRUE);
                $this->load->library('email');
                $this->email->from('system@solgen.co.za', 'System');
                $this->email->to($this->input->post('email'));
                $this->email->subject('Solgen: Account Registered');
                $this->email->message($message);
                $this->email->send();
                $data["status"] = "Success";
                $data["action_classes"] = "success";
                $data["message_classes"] = "success";
                $data["message"] = "Your account has been registered, please login in to continue.";
                // Create user default configs
                // 
            }
            $this->load->view('header', $data);
            $this->load->view('user/registered', $data);
            $this->load->view('footer');
        }
    }
    public function setDefaultUserConfigs(){
        $this->load->model('user_configs_model');
        $config["tool_id"] = 5;
        $config["key"] = "auto_save_note";
        $config["val"] = 1;
        $this->user_configs_model->capture_user_config($config);
        $config["tool_id"] = 5;
        $config["key"] = "auto_save_note_interval";
        $config["val"] = 5;
        $this->user_configs_model->capture_user_config($config);
    }
    
    public function login() {
        if ($this->input->post('email') != "" && $this->input->post('password') != "") {
            $user = $this->user_model->login($this->input->post('email'), $this->input->post('password'));
            // if remember me checkbox is checked, create table entry and cookie
            if (!empty($user)) {
//                $this->rememberMe($user);
                $this->user_model->updateLastLogin($user->id);
                unset($user->password);
                $this->session->set_userdata("loggedIn", TRUE);
                $this->session->set_userdata("isAdmin", ($user->user_type == "admin") ? TRUE : FALSE);
                $this->session->set_userdata("user", $user);
                if (!empty($this->session->userdata["targetUrl"])){
                    $targetUrl = $this->session->userdata["targetUrl"];
                    $this->session->unset_userdata("targetUrl");
                    redirect($targetUrl, 'refresh');
                }else{
                    redirect('/home/dashboard', 'refresh');
                }
            } else {
                $this->session->set_userdata("loggedIn", FALSE);
                $data["error_message"] = "Invlid login details provided.";
                $this->load->helper('email');
                $this->load->library('form_validation');
                $this->load->view('header', $data);
                $this->load->view('home/home');
                $this->load->view('footer');
            }
        } else {
            $this->session->set_userdata("loggedIn", FALSE);
            redirect('/');
        }
    }
    
    public function login_post() {
        $contentType = "application/json";
//        $email = $this->input->post('email');
//        $password = $this->input->post('password');
        $email = 'francois@opencollab.co.za';
        $password = 'Openpleas3';
        $invalidLogin = ['invalid' => $email];
        if(!$email || !$password) {
            //$this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
            $data = json_encode("NOT FOUND");
            $this->output->set_content_type($contentType)->set_output($data);
            return $this->output->get_output();
        }
        $user = $this->user_model->login($email, $password);
        if($user) {
            $id = $user->id;
            $token['id'] = $id;
            $token['email'] = $email;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5;
            $output['id_token'] = JWT::encode($token, "my Secret key!");

            $data = json_encode($output);
            $this->output->set_content_type($contentType)->set_output($data);
            return $this->output->get_output();
        }
        else {
            $data = json_encode("Incorrect Details");
            $this->output->set_content_type($contentType)->set_output($data);
            return $this->output->get_output();
        }
    }
    

    public function logout() {
        $this->session->set_userdata("loggedIn", FALSE);
        $this->session->unset_userdata("isAdmin");
        $this->session->unset_userdata("user");
        redirect('/', 'refresh');
    }

    public function forgottenPassword() {
        $this->load->view("header");
        $this->load->view("user/forgottenPassword");
        $this->load->view("footer");
        //5 redirect to home page so they can log in.
    }

    public function sendResetEmail() {
        $this->load->model('user_reset_model');
        $data["status"] = "Unsuccessful";
        $data["action_classes"] = "failure";
        $data["action_description"] = "Reset Password";
        $data["message_classes"] = "failure";
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_message('email', '<span class="failure">Invalid Email Address</span>');
        if ($this->form_validation->run() == FALSE) {
            $this->forgottenPassword();
        } else {
            // Verify email address.
            $userId = $this->user_model->get_user_id_by_email($this->input->post("email"));
            if (null == $userId) {
                $data["message"] = "No matching user with that address.<br/>Please correct the email address or Register.";
            } else {
                // create temporary reset token , in the user_reset_model
                $resetArray = $this->user_reset_model->get_user_reset(null, $userId->id, null);
                if (empty($resetArray)) {
                    $data["token"] = sha1(microtime(true) . mt_rand(10000, 90000));
                    $data["user"] = 
                    $userReset = $this->user_reset_model->create($userId->id, $data["token"]);
                    $resetArray = $this->user_reset_model->get_user_reset($userReset, null, null);
                    $message = $this->load->view('user/reset_email_template', $data, TRUE);
                    $this->load->library('email');
                    $this->email->from('system@solgen.co.za', 'System');
                    $this->email->to($this->input->post('email'));
                    $this->email->subject('Solgen : Account Password Reset');
                    $this->email->message($message);
                    $this->email->send();
                    $data["status"] = "Success";
                    $data["action_classes"] = "success";
                    $data["message_classes"] = "success";
                    $data["message"] = "Please check your email and follow the instructions to reset your password.";
                } else {
                    $data["message"] = "You have already tried to reset your password, please check your email for the reset instructions.";
                }
            }
        }
        $this->load->view("header");
        $this->load->view("user/user_status", $data);
        $this->load->view("user/forgottenPassword");
        $this->load->view("footer");
    }

    private function rememberMe($user){
//        $this->load->helper('cookie');
//        if($this->input->post("rememberMe")){
//            // load user_remember_me_model
//            $this->load->model("user_remember_me_model");
//            // insert record
//            $rememberMeId = $this->user_remember_me_model->create($user);
//            // get record
//            $rememberMe = $this->user_remember_me_model->getRememberMe($rememberMeId);
//            // create cookie
//            $this->input->set_cookie("tools.remember", $rememberMe->hash, 3600 );
//        }
    }
    
    public function resetPassword($token = null) {
        $this->load->model('user_reset_model');
        $resetArray = $this->user_reset_model->get_user_reset(null, null, $token);
        if (!empty($resetArray)) {
            $data["token"] = $token;
            $data["userReset"] = $resetArray;
            $this->load->view('header');
            $this->load->view('user/password-reset-form', $data);
            $this->load->view('footer');
        } else {
            $data["status"] = "Invalid Token";
            $data["action_classes"] = "failure";
            $data["action_description"] = "Reset Password";
            $data["message_classes"] = "failure";
            $data["message"] = "Invalid token, the token has expired. <br/>Please try again.";
            $this->load->view("header");
            $this->load->view("user/user_status", $data);
            $this->load->view("user/forgottenPassword");
            $this->load->view("footer");
        }
    }

    public function resetUserPassword() {
        $this->load->model('user_reset_model');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password1]');
        $this->form_validation->set_rules('password1', 'Password Confirmation', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->resetPassword($this->input->post("token"));
        } else {
            $resetArray = $this->user_reset_model->get_user_reset(null, null, $this->input->post("token"));
            if (!empty($resetArray)) {
                $status = $this->user_model->update_password($resetArray[0]["user_id"], $this->input->post("password"));
                $this->user_reset_model->was_reset($resetArray[0]["id"], $status);
                $data["status"] = "Password Reset";
                $data["action_classes"] = "success";
                $data["action_description"] = "Reset Password";
                $data["message_classes"] = "success";
                $data["message"] = "Your password has been reset!<br/>You can now log in.";

                $this->load->view('header');
                $this->load->view("user/user_status", $data);
                $this->load->view('home/home');
                $this->load->view('footer');
            }
        }
    }

    function settings() {
        $this->load->helper('auth_helper');
        can_access(TRUE, $this->session);
        $data["user"] = $this->session->userdata("user");
        $this->load->view('header');
        $this->load->view('user/settings', $data);
        $this->load->view('footer');
    }

    public function delete() {
        $this->load->model('expense_type_model');
        $this->load->model('payment_method_model');
        $this->load->model('expense_model');
        $this->load->model('user_reset_model');
        $userId = $this->session->userdata("user")->id;
        //delete all data
        //TODO: figure out how to best do this! some sort of daemon, or just kick off another process.
        //      I do not want the user controller to be to tightly bound.
        //destroy custom expense types 
        $this->expense_type_model->deleteUserData($userId);
        //destroy custom payment methods
        $this->payment_method_model->deleteUserData($userId);
        //destroy expenses
        $this->expense_model->deleteUserData($userId);
        //destroy user-reset requests
        $this->user_reset_model->deleteUserData($userId);
        //destory user
        $this->user_model->delete($userId);
        $this->session->set_userdata("loggedIn", FALSE);
        $this->session->unset_userdata("isAdmin");
        $this->session->unset_userdata("user");
        $this->session->sess_destroy();
        $data["status"] = "User Account Deleted";
        $data["action_classes"] = "success";
        $data["action_description"] = "Delete Account";
        $data["message_classes"] = "success";
        $data["message"] = "Your account and associated data has been deleted successfully.<br/>We are sorry to see you go, but wish you the best.<br/>";
        echo $this->load->view('user/user_status', $data, TRUE);
    }

    public function unsubscribeEmail() {
        $this->load->library("session");
        $user = $this->user_model->get_user($this->input->post("user_id"));
        $user->subscribed = ($this->input->post("subscribed") == "true") ? 1 : 0;
        $subscribeMessage = ($this->input->post("subscribed") == "true") ? "Subscribed" : "Un-subscribed";
        if ($this->session->userdata("user")->user_type == "admin" || $this->input->post("user_id") == $this->session->userdata("user")->id) {
            //unsubscribe
            if ($this->user_model->update($user)) {
                echo $subscribeMessage;
                if ($this->input->post("user_id") == $this->session->userdata("user")->id) {
                    unset($user->password);
                    $this->session->set_userdata("user", $user);
                }
            } else {
                echo "Not updated";
            }
        } else {
            //strongly worded warning to stop shananigans
            $data["action_description"] = "Unsubscribe Email Address";
            $data["status"] = "Unable to unsubscribe email address";
            $data["action_classes"] = "failure";
            $data["message_classes"] = "failure";
            $data["message"] = "You do not have sufficient privileges to Un-subscribe this email address: " . $user->email . ".";
            echo $this->load->view('general/action_status', $data, TRUE);
        }
    }

    public function unsubscribeEmailWithEmail($email) {
        $this->load->view("header");
        $this->load->view("unsubscribe");
        $this->load->view("footer");
    }

}
