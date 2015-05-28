<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class News extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('news_model');
    }
    
    public function index()
    {
        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'New archive';
        
        $this->load->view('header' , $data);
        $this->load->view('news/index',$data);
        $this->load->view('footer');
    }
    
    public function view($slug)
    {
        $data['news'] = $this->news_model->get_news($slug);
        if(empty($data['news']))
        {
            show_404();
        }
        
        $data['title'] = $data['news']['title'];
        $this->load->view('header',$data);
        $this->load->view('news/view', $data);
        $this->load->view('footer');
    }
    
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Create a news item';
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text','text', 'required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->load->view('header' , $data);
            $this->load->view('news/create');
            $this->load->view('footer');
        }
        else
        {
            $this->news_model->set_news();
            $this->load->view('news/success');
        }
    }
    
    public function delete($id)
    {
        echo $this->news_model->delete_news($id);
        $this->load->view('news/success');
    }
}