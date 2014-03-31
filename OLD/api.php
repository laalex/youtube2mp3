<?php
if(isset($_POST) && !empty($_POST['url'])):
	$url = $_POST['url'];
	parse_str( parse_url( $url, PHP_URL_QUERY ), $yt_vars );
	$filename = exec('youtube-dl.exe --get-filename '.$yt_vars['v']);
	print $filename;
endif;

if(isset($_POST) && !empty($_POST['download']) && !empty($_POST['name'])):
	$url = $_POST['download'];
	$nname = $_POST['name'];
	$name = str_replace(' ','_',$_POST['name']);
	$dl = exec('youtube-dl.exe --newline "'.$url.'" > logs/'.$name.'.txt');
	rename($nname, $name);
	print 'true';
endif;

if(isset($_POST) && !empty($_POST['poll']) && !empty($_POST['name'])):
	//Polling the debug file for progress
	$name = str_replace(' ','_',$_POST['name']);
	$line = read_last_line('logs/'.$name.'.txt');
	$explode = explode(' ',$line);
	if($explode[0]=='[download]'):
		//Get the percentage
		$exp = explode('%',$line);
		$exp = explode(' ',$exp[0]);
		$percentage = array_pop($exp);
		print $percentage;
	else:
		print 'false';
	endif;
endif;

if(isset($_POST) && !empty($_POST['convert'])):
	//File to be converted
	$file = $_POST['convert'];
	$name = str_replace(' ','_',$file);
	$ext = array_pop(explode('.',$file));
	$mp3_file = str_replace($ext,'mp3',$name);
	exec('ffmpeg.exe -i "'.$name.'" -b:a 192K -vn downloads/'.$mp3_file);
	unlink($name);
	print base64_encode($mp3_file);
endif;








//API FUNCTIONS
function read_last_line($filename){
	$line = '';

	$f = fopen($filename, 'r');
	$cursor = -1;

	fseek($f, $cursor, SEEK_END);
	$char = fgetc($f);

	/**
	 * Trim trailing newline chars of the file
	 */
	while ($char === "\n" || $char === "\r") {
	    fseek($f, $cursor--, SEEK_END);
	    $char = fgetc($f);
	}

	/**
	 * Read until the start of file or first newline char
	 */
	while ($char !== false && $char !== "\n" && $char !== "\r") {
	    /**
	     * Prepend the new char
	     */
	    $line = $char . $line;
	    fseek($f, $cursor--, SEEK_END);
	    $char = fgetc($f);
	}
	return $line;
}
?>