<?php

	class test extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->helper('youtubedl');
		}


		public function index(){
			$this->load->view('tests/youtube');
		}

	}

?>