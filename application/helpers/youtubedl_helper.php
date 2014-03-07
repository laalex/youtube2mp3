<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*========================================================================
  = YoutubeDL library helper
  = Library URL: https://github.com/rg3/youtube-dl
  = Helper written by Alexandru Lamba
  ========================================================================
  = This helper provides some functions used to get different video 
  = information and/or perform different tasks with the youtube-dl
  = extension on Windows based servers
  ========================================================================
  = Basic prefix for all functions ydl_
  = Uses the config file ydl_config.php
  = $CI =& get_instance(); -> New instance of CI object
  ======================================================================*/


  /*
  * Return video details as JSON without 
  * @param (string) $url - YouTube video URL/Video URL
  * @return (json) - Returns JSON data for the video file
  */
  if(!function_exists('ydl_videodata')):
  	function ydl_videodata($url){
  		//Load CI Instance and load the config file
  		$_this =& get_instance();
  		$_this->config->load('ydl_config');
  		//Append the path to the exe file and add a space
  		$cmd = $_this->config->item('exepath')." ";
  		//Simulate the command and don't download the video data
  		$cmd .="--simulate ";
  		//Return the result as JSON
  		$cmd .="--dump-json ";
  		//Append the  video URL to the cmd
  		$cmd .= '"'.escapeshellarg($url).'"';
  		//Escape the CMD
  		$cmd = escapeshellcmd($cmd);
  		//Execute the command and return the response
  		$execute = exec($cmd);
  		//Return the JSON content of the URL
  		print $execute;
  	}
  endif;


  /*
  * Return video details as JSON without 
  * @param (string) $url - YouTube video URL/Video URL
  * @return (json) - Returns JSON data for the video file
  */
  if(!function_exists('ydl_download')):
  	function ydl_download($url,$uid){
  		//Load CI Instance and load the config file
  		$_this =& get_instance();
  		$_this->config->load('ydl_config');
  		//Append the path to the exe file and add a space
  		$cmd = $_this->config->item('exepath')." ";
  		//Append the progress return
  		$cmd .="--newline ";
  		//Append the  video URL to the cmd
  		$cmd .= '-o "downloads/'.$uid.'/%(title)s.%(ext)s" "'.escapeshellarg($url).'" ';
  		//Escape the CMD
  		$cmd = escapeshellcmd($cmd);
  		header("Content-type: text/json");
  		disable_ob();
  		//Execute the command and return the response
  		system($cmd);
  	}
  endif;

  /*
  * Convert MP4 file to MP3 file
  */
  if(!function_exists('ydl_convert')):
    function ydl_convert($file,$id){
      //Create file name
      $fpath = 'downloads/'.$id.'/'.$file.'.mp4';
      $_this =& get_instance();
      $_this->config->load('ydl_config');
      //Append path of exe file
      $cmd = $_this->config->item('ffmpegpath')." ";
      //Append conversion filters
      $file = str_replace(' ', '_', $file);
      $mfile = 'downloads/'.$id.'/'.$file;
      $cmd .= '-i '.escapeshellarg($fpath).' -b:a 192K -vn '.escapeshellarg($mfile).'.mp3';
      $cmd = escapeshellcmd($cmd);
      system($cmd);
      //File converted. Remove the mp4 file
      unlink($fpath);
      //Return the file name
      print json_encode(array('file_name'=>$file.'.mp3'));
    }
  endif;



/* ========================================================================
*  functions used by the helper
 ========================================================================*/
function disable_ob() {
	// Turn off output buffering
	ini_set('output_buffering', 'off');
	// Turn off PHP output compression
	ini_set('zlib.output_compression', false);
	// Implicitly flush the buffer(s)
	ini_set('implicit_flush', true);
	ob_implicit_flush(true);
	// Clear, and turn off output buffering
	while (ob_get_level() > 0) {
	    // Get the curent level
	    $level = ob_get_level();
	    // End the buffering
	    ob_end_clean();
	    // If the current level has not changed, abort
	    if (ob_get_level() == $level) break;
	}
	// Disable apache output buffering/compression
	if (function_exists('apache_setenv')) {
	    apache_setenv('no-gzip', '1');
	    apache_setenv('dont-vary', '1');
	}
}