<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class website_model extends CI_Model{

	/* Website model 
	* Handles website different data and interactions
	*/
	public function __construct(){
		$this->load->database();
	}

	/*
	* Get page meta
	* return meta tags, title, etc
	*/
	public function get_page_title(){
		$title = "MP3Droid";
		$uri = $this->uri->segment(1,false);
		if($uri !== false):
			$title .= ucfirst($uri);
		endif;
		return $title;
	}

	/*
	* Render a view with header and footer
	*/
	public function _render($view){
		if(empty($view)):
			show_404();
		else:
			$this->load->view('website/inc/header');
			$this->load->view($view);
			$this->load->view('website/inc/footer');
		endif;
	}

}