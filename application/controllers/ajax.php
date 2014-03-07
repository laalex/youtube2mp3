<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ajax extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('ajax_model');
	}

	public function index(){
		print json_encode(array('error'=>1,'description'=>'This method is not available.'));
		exit();
	}

	/* Playlists requests */
	public function playlists(){
		$this->ajax_model->process_playlists_requests();
	}

	/* Song requests */
	public function songs(){
		$this->ajax_model->process_songs_requests();
	}

	/* Downloader requests */
	public function downloader(){
		$this->ajax_model->process_download_requests();
	}

	/* Create pack to download playlist */
	public function pack_download(){
		$this->ajax_model->pack_download();
	}
}