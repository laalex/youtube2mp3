	<!-- MP3  player -->
	<div id="mp3player">
		<div id="song_name">
			<span class="label" id="mp3_songname">-ZongPlayer-</span>
		</div>
		<br />
		<div id="player_controls">
			<!--<span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;-->
			<span title="Play/Pause" class="ttp glyphicon glyphicon-play" id="play_button"></span>&nbsp;&nbsp;
			<span title="Toggle song repeat" class="ttp glyphicon glyphicon-repeat" id="repeat_button"></span>&nbsp;&nbsp;
			<span class="label label-success" id="song_time">
				<span class="label label-danger" id="song_time_elapsed"></span>
			</span>&nbsp;&nbsp;
			<span title="Show current playlist" class="ttp glyphicon glyphicon-align-justify" id="show_playlist"></span>
			<!--<span class="glyphicon glyphicon-forward"></span>&nbsp;&nbsp;-->
			<div id="rplayer_playlist"></div>
		</div>
		<div id="elapsed_time">
			<div id="mp_elapsed">0:00</div>
			<div id="mp_total">/ 0:00</div>
		</div>
		<div id="volume_control">
			<span class="glyphicon glyphicon-volume-down pull-left" style="display:block;">&nbsp;</span>
			<span class="glyphicon glyphicon-volume-down pull-right" style="display:block;">&nbsp;</span>
			<br />
			<span class="label label-success" id="volume_cursor">
				<span class="label label-danger" id="volume_selected"></span>
			</span>
		</div>
	</div>

	<ol id="tutorial_id" style="display:none;">
	  <li data-id="video-url-input">
	  	Write here your <b>song name</b> or paste in your <b>YouTube URL</b> for the song you want to download.
	  	<br />
	  	After that, hit ENTER or click <b>Download vdeo</b> to start
	  	<br /><br />
	  </li>

	  <li data-id="toggle_mp3">
	  	<b>Toggle Player</b> is going to hide/show the MP3 player.<br />
	  	<b>Hide Downloads</b> is going to show/hide download boxes when you are downloading content.<br />
	  	<b>Dashboard</b> will get you back here :-)
	  	<br /><br />
	  </li>

	  <li data-id="playlist_tut" data-options="tipLocation:right">
	  	Use <b>Playlists</b> to create containers for your songs and categorize them.
	  	<br /><br />
	  </li>

	  <li data-id="invite_tut" data-options="tipLocation:right">
	  	<b>Invite a friend</b> to join <b>ZongList</b> network. Write in his email address so he can get an account ;)
	  	<br /><br />
	  </li>

	  <li data-id="mp3_songname" data-options="tipLocation:top" data-button="I got it!">
	  	<b>ZongPlayer</b> allows you to listen your songs right here after you download them.
	  	<br /><br />
	  </li>
	</ol>

	<!-- SCRIPTS -->
	<script type="text/javascript">
		var baseurl = "<?php print base_url(); ?>index.php/";
		var assets_img = "<?php print assets_img(); ?>";
		var first_visit = "<?php print $this->session->userdata('first_visit');  ?>";
		YT_LOADED_SUCCESSFULLY = false;
	</script>
	<!-- Angualr controllers -->
	<script type="text/javascript" src="<?php assets_js();?>tipsy.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>mousewheel.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>customscrollbar.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>feedback.min.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>jquery.joyride-2.1.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>jSnippets.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>mp3player.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>application.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/dashboard.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/playlists.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/view_playlist.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/invite.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/settings.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>storage.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>youtube_api.js"></script>
	<script src="https://apis.google.com/js/client.js?onload=loadYTApi"></script>
	<iframe id="download_frame" style="display:none;width:1px;height:1px;"></iframe>
</body>
</html>