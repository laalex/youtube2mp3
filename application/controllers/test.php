<?php

	class test extends CI_Controller{

		public function __construct(){
			parent::__construct();
		}


		public function index(){
			$this->load->database();
                     var_dump($this->db->get('users')->result());
		}

	}

?>