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
              $return['active'] = $this->db->where('is_downloaded',1)->count_all_results('songs');
              return $return;
       }

       /**
        * Retrieve playlists data
        */
       public function pls_count(){
              return $this->db->count_all('playlists');
       }

       /**
        * Feedback Count
        */
       public function fbk_count(){
              return $this->db->count_all('feedback');
       }

       /**
        * Return downloads folder space used
        */
       public function download_space_used(){
              $path = "/var/www/zonglist/downloads";
              $io = popen('/usr/bin/du -ks '.$path, 'r');
              $output = fgets ( $io, 4096);
              $result = preg_split('/\s/', $output);
              $size = $result[0]*1024;
              pclose($io);
              return round($size/(1024*1024*1024),2)+0.01;//Return the number in mb + 10 more.
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

       function format_bytes($a_bytes) {
        if ($a_bytes > 1024) {
          return $a_bytes .' B';
        } elseif ($a_bytes > 1048576) {
          return round($a_bytes / 1024, 2) .' KB';
        } elseif ($a_bytes > 1073741824) {
          return round($a_bytes / 1048576, 2) . ' MB';
        } elseif ($a_bytes > 1099511627776) {
          return round($a_bytes / 1073741824, 2) . ' GB';
        } elseif ($a_bytes > 1125899906842624) {
          return round($a_bytes / 1099511627776, 2) .' TB';
        }
      }

}
