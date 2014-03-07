<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class application extends CI_Controller{

	public function __construct(){
		parent::__construct();
		//Check if user is logged in
		if(!$this->ion_auth->logged_in()):
			//The user is logged in -> Redirect to the application
			redirect(base_url().'login');
		endif;
		//Include the header file
		$this->load->model('application_model');
		$data['playlists'] = $this->application_model->get_my_playlists();
		$this->load->view('application/inc/header');
		$this->load->view('application/inc/sidebar-menu',$data);
	}

	//Default website
	public function index(){
		$this->load->view('application/dashboard');
		$this->load->view('application/inc/footer');
	}

	//Playlits
	public function playlists(){
		$data['playlists'] = $this->application_model->get_my_playlists();
		$this->load->view('application/playlists',$data);
		$this->load->view('application/inc/footer');
	}

	//Set default playlist
	public function set_default(){
		$this->application_model->set_default_playlist();
	}

	//Remove playlist
	public function remove_playlist(){
		$this->application_model->remove_playlist();
	}

	//View playlist
	public function view_playlist(){
		$data['playlist'] = $this->application_model->get_playlist();
		$this->load->view('application/playlist',$data);
		$this->load->view('application/inc/footer');
	}

	//Settings
	public function settings(){
		$this->load->view('application/settings');
	}


}