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
			$s->nice_name = str_replace('-'.$s->video_id,'',$s->song_name);
			$s->nice_name = str_replace('_',' ',$s->nice_name);
			$s->nice_name = str_replace('.mp3','',$s->nice_name);
		endforeach;
		return $return;
	}

	/* Return requested playlist to be shared */
	public function get_playlist_shared(){
		//Get the user ID
		$id = $this->uri->segment(3);
		$return['playlist_data'] = $this->db->from('playlists')->where(array('list_id'=>$id))->get()->first_row();
		/* Get all songs in the current list */
		$return['playlist_songs'] = $this->db->from('songs')->where(array('list_id'=>$id))->get()->result();
		foreach($return['playlist_songs'] as &$s):
			$s->direct_url = base_url().'downloads/'.$s->user_id.'/'.$s->song_name;
			$s->nice_name = str_replace('-'.$s->video_id,'',$s->song_name);
			$s->nice_name = str_replace('_',' ',$s->nice_name);
			$s->nice_name = str_replace('.mp3','',$s->nice_name);
		endforeach;
		return $return;
	}

	/**
	 * Get playlist songs by playlist id
	 */
	public function get_playlist_songs($id){
		$uid = $this->session->userdata('user_id');
		$return = $this->db->from('songs')->where(array('user_id'=>$uid,'list_id'=>$id))->get()->result();
		foreach($return as &$s):
			$s->direct_url = base_url().'downloads/'.$s->user_id.'/'.$s->song_name;
			$s->nice_name = str_replace('-'.$s->video_id,'',$s->song_name);
			$s->nice_name = str_replace('_',' ',$s->nice_name);
			$s->nice_name = str_replace('.mp3','',$s->nice_name);
			$s->full_name = $s->nice_name;
			//Length is maximum 50
			if(strlen($s->nice_name) > 50){
				$s->nice_name = substr($s->nice_name,0,50) . '...';
			}
		endforeach;
		return $return;
	}

	/**
	 * Get playlist songs by playlist id
	 */
	public function get_song($id){
		$uid = $this->session->userdata('user_id');
		$s = $this->db->from('songs')->where(array('user_id'=>$uid,'song_id'=>$id))->get()->first_row();
		$s->direct_url = base_url().'downloads/'.$s->user_id.'/'.$s->song_name;
		$s->nice_name = str_replace('-'.$s->video_id,'',$s->song_name);
		$s->nice_name = str_replace('_',' ',$s->nice_name);
		$s->nice_name = str_replace('.mp3','',$s->nice_name);
		$s->full_name = $s->nice_name;
		//Length is maximum 50
		if(strlen($s->nice_name) > 50){
			$s->nice_name = substr($s->nice_name,0,50) . '...';
		}
		return $s;
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

	/** Return current invitations */
	public function get_invitations(){
		$uid = $this->session->userdata('user_id');
		$invitations = $this->db->where('user_id',$uid)->get('invitations')->result();
		foreach($invitations as &$i):
			if($this->db->where('username',$i->email)->count_all_results('users'))
				$i->accepted = "Yes";
			else
				$i->accepted = "Not yet";
		endforeach;
		return $invitations;
	}
	/** Create new invitation */
	public function put_invitation(){
		$post=$this->input->post();
		if(!empty($post)):
			if($post['email'] == '') : print json_encode("The email is empty"); return; endif;
			if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)): print json_encode('The provided email is invalid!'); return; endif;
			$insert = array(
				'user_id'=>$this->session->userdata('user_id'),
				'email'=>$post['email'],
				'accepted'=>0
			);
			if($this->db->insert('invitations',$insert)){
				//Dispatch invitation email
				$insert_id = $this->db->insert_id();
				$this->dispatchInvitation($post['email'],$insert_id);
				print json_encode("Your invitation has been sent!");
			} else {
				print json_encode("Cannot send your invitation. Try again!");
			}
		else:
			print json_encode("Cannot send your invitation. Try again!");
		endif;
	}

	/** Dispatch invitation email */
	public function dispatchInvitation($mail,$inv_id){
		/** Get the email view and dispatch the invitation */
		$data['id'] = $inv_id;
		$view = $this->load->view('emails/invite',$data,true);

		$this->email->from('no-reply@zonglist.com', 'ZongList');
	       $this->email->to($mail);

	       $this->email->subject('ZongList.com Invitation');
	       $this->email->message($view);

	       $this->email->send();
	}

	/**
	 * Accept invitation method
	 * ------------------------
	 * This method accepts the invitation received by email
	 * and creates the user an account.
	 * If the account has been created then an email is dispatched to the user
	 * sending him the credentials of his account.
	 */
	public function accept_invitation($id){
		//Create account data
		$invite = $this->db->where('invite_id',$id)->get('invitations')->first_row();
		$email = $username = $invite->email;
		//Generate password:
		$password = $this->generateRandomString(8);
		/** Register user process */
		$additional_data = array(
				'first_name' => '',
				'last_name'  => '',
				'company'    => '',
				'phone'      => '',
			);
		if($user_id = $this->ion_auth->register($username, $password, $email, $additional_data = array()))
		{
			//check to see if we are creating the user
			if($user_id != false){
				//Create a default playlist for the user
				$this->load->database();
				$this->db->insert('playlists',array('name'=>'Default','user_id'=>$user_id,'default'=>1));
				//Create user directory
				mkdir('downloads/'.$user_id);
			}
			/** Dispatch email to the user with his credentials */
			$data['username'] = $email;
			$data['password'] = $password;
			$view = $this->load->view('emails/confirm_account',$data,true);
			$this->email->from('no-reply@zonglist.com', 'ZongList');
		       $this->email->to($email);

		       $this->email->subject('ZongList Account Information');
		       $this->email->message($view);

		       $this->email->send();
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("web/account_created", 'refresh');
		} else {
			$this->session->set_flashdata('message', "The account cannot be created!");
			redirect("auth/login", 'refresh');
		}
	}

	/** Change user password */
	public function change_password(){
		$post = $this->input->post();
		if(!empty($post)):
			$pwd = $post['password'];
			$old = $post['old_password'];
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));
			$change = $this->ion_auth->change_password($identity, $old, $pwd);

			if($change){
				print json_encode("Your password has changed!");
			} else {
				print json_encode("Failed to change your password! Try again!");
			}
		else:
			print json_encode("Your inserted password is empty!");
		endif;
	}


	private function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~-<>_+';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}


	public function set_first_visit(){
		$id = $this->session->userdata('user_id');
		$user = $this->db->where('id',$id)->get('users')->first_row();
		if($user->first_visit == 0){
			$this->db->where('id',$id)->update('users',array('first_visit'=>1));
			return 'true';
		} else {
			return 'false';
		}
		exit();
	}

	/**
	 * Update the playlist of a song
	 */
	public function change_song_playlist(){
		$post = $this->input->post();
		if(!empty($post)):
			//Update the list ID
			$this->db->where('song_id',$post['sid'])->update('songs',array('list_id'=>$post['plid']));
			print 'success';
		endif;
	}

	/**
	 * Remove song from playlist
	 */
	public function remove_song($id){
		//Get the song details from the database
		$uid = $this->session->userdata('user_id');
		$song = $this->db->where(array('user_id'=>$uid,'song_id'=>$id))->get('songs')->first_row();
		//Remove the song from the user folder
		@unlink('downloads/'.$uid.'/'.$song->song_name);
		//Remove the song from the database
		$this->db->where(array('user_id'=>$uid,'song_id'=>$id))->delete('songs');
		print 'success';
	}
}