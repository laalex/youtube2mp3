<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class application_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	/* Return current logged in playlists */
	public function get_my_playlists(){
		//Get the user ID
		$uid = $this->session->userdata('user_id');
		$lists = $this->db->from('playlists')->where('user_id',$uid)->get()->result();
		foreach($lists as $pl):
			$count = $this->db->where('list_id',$pl->list_id)->count_all_results('songs');
			$pl->song_count = $count;
		endforeach;
		return $lists;
	}

	/* Return requested playlist */
	public function get_playlist(){
		//Get the user ID
		$id = $this->uri->segment(3);
		$uid = $this->session->userdata('user_id');
		$return['playlist_data'] = $this->db->from('playlists')->where(array('user_id'=>$uid,'list_id'=>$id))->get()->first_row();
		/* Get all songs in the current list */
		$return['playlist_songs'] = $this->db->from('songs')->where(array('user_id'=>$uid,'list_id'=>$id))->get()->result();
		foreach($return['playlist_songs'] as &$s):
			$s->direct_url = base_url().'downloads/'.$s->user_id.'/'.$s->song_name;
			$s->nice_name = str_replace('_',' ',$s->song_name);
			$s->nice_name = str_replace('.mp3','',$s->nice_name);
		endforeach;
		return $return;
	}

	/* Set default playlist for current user */
	public function set_default_playlist(){
		$set = $this->uri->segment(3);
		$uid = $this->session->userdata('user_id');
		$this->db->where('user_id',$uid)->update('playlists',array('default'=>0));
		$this->db->where(array('user_id'=>$uid,'list_id'=>$set))->update('playlists',array('default'=>1));
		print true;
	}

	/* Remove playlist */
	public function remove_playlist(){
		$id = $this->uri->segment(3);
		$uid = $this->session->userdata('user_id');
		//Check if this is a default playlist
		$list = $this->db->where(array('user_id'=>$uid,'list_id'=>$id))->get('playlists')->first_row();
		if($list->default == 1){
			//This is a default playlist. Remove it, and make another playlist default
			$this->db->delete('playlists',array('list_id'=>$id));
			//Get the first playlist in the users library
			$ran_playlist = $this->db->where('user_id',$uid)->get('playlists')->first_row();
			//Make it default
			$this->db->where(array('user_id'=>$uid,'list_id'=>$ran_playlist->list_id))->update('playlists',array('default'=>1));
		} else {
			//This is not a default playlist -> Delete it
			$this->db->delete('playlists',array('list_id'=>$id));
		}
		print 'success';
	}

}