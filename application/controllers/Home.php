<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
  public function __construct() {
	parent::__construct();
		
	$this->load->helper('url', 'form');
	$this->load->library('session');
    $this->load->database();
	$this->load->model('Home_model', 'home_model');
	$this->load->model('api/Events_model', 'events_model');
	$this->load->model('api/Announcements_model', 'announcements_model');
	$this->load->model('api/News_model', 'news_model');
  }

  public function index() {
	$this->data['events'] = $this->events_model->get_events();
	$this->data['announcements'] = $this->announcements_model->get_announcements();
	$this->data['news_and_articles'] = $this->news_model->get_news();
    $this->load->view('home_page', $this->data);
	}
}
