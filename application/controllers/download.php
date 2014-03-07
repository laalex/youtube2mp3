<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class download extends CI_Controller{

	public function __construct(){
		parent::__construct();
		//Check if user is logged in
		if(!$this->ion_auth->logged_in()):
			//The user is logged in -> Redirect to the application
			redirect(base_url().'login');
		endif;
		//Include the header file
		$this->load->model('application_model');
	}

	public function index(){
		redirect(base_url());
	}

	/* Function downloader */
	public function hash(){
		/* Get the hash */
		$hash = $this->uri->segment(3);
		//Get the user ID
		//$uid = $this->session->userdata('user_id');
		//Get the database entry
		$data = $this->db->where('download_url',$hash)->get('songs')->result();
			if(!empty($data)):
				if($data[0]->user_id==$uid):
					//Serve the MP3 file for download
					$file = 'downloads/'.$uid.'/'.$data[0]->song_name;
					header ("Content-type: octet/stream");
					header ("Content-disposition: attachment; filename=".$file);
					header("Content-Length: ".filesize($file));
					readfile($file);
					exit;
				else:
					exit('No music for you. This is not yours.');
				endif;
			else:
				exit('No music for you. Sorry, but you are not allowed to download this song.');
			endif;
	}

}