<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ajax_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->helper('youtubedl');
		$this->load->database();
	}


	/* =================== PLAYLIST REQUESTS =====================
	==== USED TO PROCESS ALL THE REQUESTS RELATED TO PLAYLISTS ===
	=============================================================*/
	public function process_playlists_requests(){
		//Get the post request
		$post = $this->input->post();
		$uid = $this->session->userdata('user_id');
		if(empty($post)){
			$post = json_decode(file_get_contents('php://input'),true);
		}
		if(isset($post)):
			$request_type = $post['action'];
			/* Switch request type and return the propper response*/
			switch($request_type){
				/* Add playlist to the database for the given user */
				case 'add_playlist':
					$name = $post['playlist_name'];
					//Check to see if a playlist already exist with that name
					$ret = $this->db->from('playlists')->where(array('user_id'=>$uid,'name'=>$name))->count_all_results();
					if($ret == 0):
						//Insert the playlist into the database
						$this->db->insert('playlists',array('name'=>$name,'user_id'=>$uid));
						$insert_id = $this->db->insert_id();
						$playlist = $this->db->where('list_id',$insert_id)->get('playlists')->first_row();
						print json_encode(array('response'=>'success','message'=>'Your playlist <b>'.$name.'</b> has been created!','playlist'=>$playlist));
					else:
						print json_encode(array('response'=>'error','message'=>'You already have a playlist called <b>"'.$name.'"</b>. Please pick another name ;)'));
					endif;
				break;

				case 'put_song_in_playlist':
					$sid = $post['song_id'];
					$plid = $post['playlist'];
					$this->db->where(array('song_id'=>$sid,'user_id'=>$uid))->update('songs',array('list_id'=>$plid));
					print json_encode(array('response'=>'success','details'=>'Your song has been moved to the selected playlist!'));
				break;
				default:
					print json_encode(array('response'=>'error','details'=>'Request method is not known. Wooh. What were you trying to do?!'));
				break;
			}

		else:
			print json_encode(array('response'=>'error','details'=>'Access to method is not allowed'));
		endif;
	}

	/* =================== DOWNLOADER REQUESTS =====================
	==== USED TO PROCESS ALL THE REQUESTS RELATED TO DOWNLOADS   ===
	==============================================================*/
	public function process_download_requests(){
		$post = $this->input->post();
		$uid = $this->session->userdata('user_id');
		if(isset($post)):
			$request_type = $post['action'];
			//TEMPORARY
			switch($request_type){
				case 'download_video':
					$url = $post['url'];
					ydl_download($url,$uid);
				break;

				case 'convert_video':
					$file = $post['video_name'];
					ydl_convert($file,$uid);
				break;

				case 'video_information':
					$url = $post['url'];
					ydl_videodata($url);
				break;

				default:
					print json_encode(array('response'=>'error','details'=>'Request method is not known. Wooh. What were you trying to do?!'));
				break;

			}
		else:
			print json_encode(array('response'=>'error','details'=>'Nonthing to process. There is no post to this method'));
		endif;
	}


	public function process_songs_requests(){
		$post = $this->input->post();
		$uid = $this->session->userdata('user_id');
		if(isset($post)):
			$request_type = $post['action'];
			//TEMPORARY
			switch($request_type){
				case 'register_song':
					parse_str( parse_url( $post['videourl'], PHP_URL_QUERY ), $vls );
					$video_id = $vls['v'];
					$title = $post['song_title'];
					$hash = md5($title.$uid);
					//Get user default playlist
					$rez = $this->db->select('list_id')->where(array('user_id'=>$uid,'default'=>1))->get('playlists')->first_row();
					$insert = array(
						'user_id'=>$uid,
						'song_name'=>$title,
						'download_url'=>$hash,
						'list_id'=>$rez->list_id,
						'video_id'=>$video_id,
						'is_downloaded'=>1
					);
					$this->db->insert('songs',$insert);
					$insert_id = $this->db->insert_id();
					print json_encode(array('response'=>'success','details'=>'Your song has been added to your collection','download'=>base_url().'download/hash/'.$hash,'song_id'=>$insert_id));
				break;

				default:
					print json_encode(array('response'=>'error','details'=>'Request method is not known. Wooh. What were you trying to do?!'));
				break;

			}
		else:
			print json_encode(array('response'=>'error','details'=>'Nonthing to process. There is no post to this method'));
		endif;
	}


	public function pack_download(){
		$post = $this->input->post();
		$uid = $this->session->userdata('user_id');
		if(isset($post)):
			//Load the zip library
			$this->load->library('zip');
			$playlist = $post['playlist'];
			$time = time();
			$songs = $this->db->where('list_id',$playlist)->get('songs')->result();
			//Iterate trough the songs and put them all into an archive
			foreach($songs as $s):
				$this->zip->read_file('downloads/'.$uid.'/'.$s->song_name);
			endforeach;
			$this->zip->archive('downloads/'.$uid.'/playlist_'.$time.'.zip');
			print json_encode(array('response'=>'success','details'=>'Zip file created','zip'=>base_url().'downloads/'.$uid.'/playlist_'.$time.'.zip'));
		else:
			print json_encode(array('response'=>'error','details'=>'Nonthing to process. There is no post to this method'));
		endif;
	}

}