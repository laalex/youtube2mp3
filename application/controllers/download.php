<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class download extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if(!$this->uri->segment(5)=="MOBILE_ALLOWED_FROM"):
			//Check if user is logged in
			if(!$this->ion_auth->logged_in()):
				//The user is logged in -> Redirect to the application
				redirect(base_url().'login');
			endif;
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
		$file_request = $this->uri->segment(4,false);
		//Get the user ID
		$uid = $this->session->userdata('user_id');
		if($uid == null || empty($uid)){
			$uid = $this->uri->segment(4);
		}
		//Get the database entry
		$data = $this->db->where('download_url',$hash)->get('songs')->first_row();
			if(!empty($data)):
				if($data->user_id==$uid):
					//Serve the MP3 file for download
					/** Check if the file is downloaded or not */
					if($data->is_downloaded == 0):
						$this->load->helper('youtubedl');
						ydl_silent_download('https://www.youtube.com/watch?v='.$data->video_id,$uid);
						//Update the song into the database as downloaded
						$this->db->where('song_id',$data->song_id)->update('songs',array('is_downloaded'=>1));
					endif;
					$file = 'downloads/'.$uid.'/'.$data->song_name;
					//If the file is requested, then go to the file directly
					header("Content-Type: " . mime_content_type($file));
					header("Content-Length: " . filesize($file));
					$file_name = pathinfo($file);
					header("Content-Disposition: attachment; filename=\"" . $file_name['basename'] . "\"");
					header("Content-Type: application/octet-stream");
					header("Content-Transfer-Encoding: binary");

					if ($fp=fopen($file, "r")){
					    fpassthru($fp);
					}
					exit;
				else:
					exit('No music for you. This is not yours.');
				endif;
			else:
				exit('No music for you. Sorry, but you are not allowed to download this song.');
			endif;
	}

	public function reload_song(){
		$this->load->helper('youtubedl');
		$uid = $this->session->userdata('user_id');
		$sid = $this->input->post('song_id');
		$vid = $this->input->post('video_id');
		ydl_silent_download('https://www.youtube.com/watch?v='.$vid,$uid,true);
		//Update the song into the database as downloaded
		$this->db->where('song_id',$sid)->update('songs',array('is_downloaded'=>1));
	}

}