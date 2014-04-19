<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crons extends CI_Controller{

    public function __construct(){
        parent::__construct();
        //$this->load->model('application_model');
    }


    /** Default cron job task */
    public function index(){
        /** Get the songs that are active from the songs list */
        $select = "SELECT * FROM songs WHERE last_updated < NOW() - INTERVAL 1 DAY AND `is_downloaded`='1'";
        $songs = $this->db->query($select)->result();
        $ct = 0;
        /** Iterate trough each song and mark it not downloaded, and then remove the files */
        foreach($songs as $s):
            $ct++;
            @unlink('downloads/'.$s->user_id.'/'.$s->song_name);
            log_message('info','Song:'.$s->song_name.' has been removed ('.date('d-m-Y',time()));
            $this->db->where('song_id',$s->song_id)->update('songs',array('is_downloaded'=>0));
        endforeach;
        /** Dispatch cron job removed message */
        log_message('info','Cron job finished. Removed: '.$ct.' files');
        file_put_contents('.cronexec', 'created at:'.date('d-m-y h:m:s',time()).';',FILE_APPEND);
    }

}