<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class api extends CI_Controller{

	/*
	* API ERROR CODES
	* =============================
	* -1 : Empty array/response from server
	*  0 : No error! Success code.
	*
	*/

	protected $_uid = null;


	/* API BOOTSTRAP */
	public function __construct(){
		parent::__construct();
		$_request = $this->input->server('REQUEST_METHOD');
		if($_request !== 'POST'):
			//http_response_code(403);
			exit('GET_NOT_ALLOWED');
		endif;
		$post = $this->input->post();
		if(empty($post)){
			$data = file_get_contents("php://input");
 			$post = json_decode($data,true);
		}
		if(empty($post['user']) || empty($post['pass'])):
			//http_response_code(403);
			print json_encode(array('logged_in'=>'false','error'=>'Missing credentials'));
			exit();
		endif;
		if(!$this->ion_auth->login($post['user'], $post['pass'])):
			//http_response_code(403);
			print json_encode(array('logged_in'=>'false','error'=>'Wrong credentials'));
			exit();
		endif;

		$this->_uid = $this->session->userdata('user_id');
	}

	public function index(){
		$post = $this->input->post();
		print json_encode(array('logged_in'=>'true','user'=>array('uid'=>$this->_uid,'username'=>$post['user'],'password'=>$post['pass'])));
	}




	/*
	* Returns user playlists as a json OBJECT
	* Error -1 -> Empty/No playlists
	*/
	public function get_playlists(){
		$playlists = $this->db->where('user_id',$this->_uid)->get('playlists')->result();
		if(!empty($playlists)):
			foreach($playlists as &$pl):
				$count = $this->db->query("SELECT COUNT(*) as count FROM songs WHERE list_id='".$pl->list_id."'")->first_row();
				$pl->count = $count->count;
			endforeach;
			$return = array('result'=>'success','error'=>0,'data'=>$playlists);
			print json_encode($return);
		else:
			$return = array('result'=>'fail','error'=>-1);//Empty string
			print json_encode($return);
		endif;
	}

	/*
	* Returns user playlist data
	* Error -1 -> Empty/No playlist
	*/
	public function get_playlist(){
		$id = $this->uri->segment(3);
		$playlist = $this->db->where(array('user_id'=>$this->_uid,'list_id'=>$id))->get('playlists')->first_row();
		if(!empty($playlist)):
			$return = array('result'=>'success','error'=>0,'data'=>$playlist);
			print json_encode($return);
		else:
			$return = array('result'=>'fail','error'=>-1);//Empty string
			print json_encode($return);
		endif;
	}

	/*
	* Returns all user songs
	* Error -1 -> Empty/No songs
	*/
	public function get_songs(){
		$songs = $this->db->where('user_id',$this->_uid)->get('songs')->result();
		if(!empty($songs)):
			$return = array('result'=>'success','error'=>0,'data'=>$songs);
			print json_encode($return);
		else:
			$return = array('result'=>'fail','error'=>-1);//Empty string
			print json_encode($return);
		endif;
	}

	/*
	* Returns all songs in a playlist
	* Error -1 -> Empty/No songs
	*/
	public function get_playlist_songs(){
		$plid = $this->uri->segment(3);
		$songs = $this->db->where(array('user_id'=>$this->_uid,'list_id'=>$plid))->get('songs')->result();
		if(!empty($songs)):
			$return = array('result'=>'success','error'=>0,'data'=>$songs);
			print json_encode($return);
		else:
			$return = array('result'=>'fail','error'=>-1);//Empty string
			print json_encode($return);
		endif;
	}

	/*
	* Returns song data
	* Error -1 -> Empty/No song
	*/
	public function get_song(){
		$id = $this->uri->segment(3);
		$song = $this->db->where(array('song_id'=>$id,'user_id'=>$this->_uid))->get('songs')->first_row();
		if(!empty($song)):
			//Get the playlist details for the song
			$playlist = $this->db->where(array('user_id'=>$this->_uid,'list_id'=>$song->list_id))->get('playlists')->first_row();
			$song->playlist_name = $playlist->name;
			$return = array('result'=>'success','error'=>0,'data'=>$song);
			print json_encode($return);
		else:
			$return = array('result'=>'fail','error'=>-1);//Empty string
			print json_encode($return);
		endif;
	}

}