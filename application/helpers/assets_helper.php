<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/* Assets helper 
	* This helper is ussed to send the full URLs for
	* different assets from the folder
	*/

	/* print images url*/
	function assets_img(){
		$url = base_url().'assets/img/';
		print $url;
	}

	/* print css url*/
	function assets_css(){
		$url = base_url().'assets/css/';
		print $url;
	}

	/* print javascript url*/
	function assets_js(){
		$url = base_url().'assets/js/';
		print $url;
	}