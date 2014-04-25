<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class admin_model extends CI_Model{

       /**
        * Retrieve accounts data
        */
       public function acc_count(){
             return $this->db->count_all('users');
       }

       /**
        * Retrieve song data
        */
       public function song_data(){
              $return['count'] = $this->db->count_all('songs');
              $return['active'] = $this->db->where('is_downloaded',1)->count_all('songs');
              return $return;
       }

       /**
        * Retrieve playlists data
        */
       public function pls_count(){
              return $this->db->count_all('playlists');
       }

       /**
        * Return downloads folder space used
        */
       public function download_space_used(){
              return $this->dirsize('downloads');
       }

       /**
        * Return feedback data
        *
        */
       public function get_feedback(){
              $feedback = $this->db->get('feedback')->result();
              foreach ($feedback as $f) {
                     $f->feedback_data = unserialize(base64_decode($f->feedback_data));
                     unset($f->feedback_data['html']);
              }
              return $feedback;
       }




       private function dirsize($dir)
           {
             @$dh = opendir($dir);
             $size = 0;
             while ($file = @readdir($dh))
             {
               if ($file != "." and $file != "..")
               {
                 $path = $dir."/".$file;
                 if (is_dir($path))
                 {
                   $size += dirsize($path); // recursive in sub-folders
                 }
                 elseif (is_file($path))
                 {
                   $size += filesize($path); // add file
                 }
               }
             }
             @closedir($dh);
             return $size/1024;
           }

}