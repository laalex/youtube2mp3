<?php
	
	class test extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->helper('youtubedl');
		}


		public function index(){
			ydl_download('http://www.youtube.com/watch?v=dUOxeSlTx9M');
		}

		public function debug(){
			$this->load->view('debug/ajax_debug');
		}


	}

?>