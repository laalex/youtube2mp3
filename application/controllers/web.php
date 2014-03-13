<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class web extends CI_Controller{

	/* Constructor */
	public function __construct(){
		parent::__construct();
		$this->load->model('website_model');
		$this->load->helper('form');
		//Check if user is logged in
		if($this->ion_auth->logged_in()):
			//The user is logged in -> Redirect to the application
			redirect(base_url().'dashboard/');
		endif;
	}

	/* Homepage */
	public function index(){
		$data['title'] = $this->website_model->get_page_title();
		$this->website_model->_render('website/homepage');
	}

}