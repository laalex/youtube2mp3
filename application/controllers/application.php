<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class application extends CI_Controller{

	public function __construct(){
		parent::__construct();
		//Check if user is logged in
		if(!$this->ion_auth->logged_in()):
			//The user is logged in -> Redirect to the application
			redirect(base_url().'login');
		endif;
		$this->load->model('application_model');
	}

	//Default website
	public function index(){
		//Include the header file
		$data['playlists'] = $this->application_model->get_my_playlists();
		$this->load->view('application/inc/header');
		$this->load->view('application/inc/sidebar-menu',$data);
		$this->load->view('application/dashboard');
		$this->load->view('application/inc/footer');
	}

	//Playlits
	public function playlists(){
		$playlists = $this->application_model->get_my_playlists();
		print json_encode($playlists);
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
		$data = $this->application_model->get_playlist();
		print json_encode($data);
	}

	//Get invitations
	public function get_invitations(){
		$data = $this->application_model->get_invitations();
		print json_encode($data);
	}
	//Put invitation
	public function put_invitation(){
		$this->application_model->put_invitation();
	}

	/** Invitation accept */
	public function accept_invite($id){
		$this->application_model->accept_invitation($id);
	}

}