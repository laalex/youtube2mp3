	<!-- MP3  player -->
	<div id="mp3player">
		<div id="song_name">
			<span class="label" id="mp3_songname">-ZongPlayer-</span>
		</div>
		<br />
		<div id="player_controls">
			<!--<span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;-->
			<span title="Play/Pause" class="ttp glyphicon glyphicon-play" id="play_button"></span>&nbsp;&nbsp;
			<span title="Toggle playlist repeat" class="ttp glyphicon glyphicon-repeat" id="repeat_button"></span>&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="label label-success" id="song_time">
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
			<span class="glyphicon glyphicon-volume-off pull-left" id="rplayer-mute" style="display:block;">&nbsp;</span>
			<span class="glyphicon glyphicon-volume-up pull-right" id="rplayer-fullsound" style="display:block;">&nbsp;</span>
			<br />
			<span class="label label-success" id="volume_cursor"></span>
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

	<!-- MODAL -->
	<!-- SHARE PLAYLSIT MODAL -->
	<div class="modal fade" id="kbd-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">MP3 Player - Keyboad Shortcuts</h4>
	      </div>
	      <div class="modal-body">
	      		<code>SHIFT + "P"</code> - Toggle play/pause <br />
	      		<code>SHIFT + "-"</code> - Volume down <br />
	      		<code>SHIFT + "+"</code> - Volume up <br />
	      		<code>SHIFT + "R"</code> - Toggle repeat playlist, repeat one, repeat none<br />
	      		<code>SHIFT + "L"</code> - Loads a playlist if you are viewing one
	      		<hr />
	      		<i>Player controls are only tested on Chrome browser. They might not work on other browsers</i>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- SCRIPTS -->
	<script type="text/javascript">
		var baseurl = "<?php print base_url(); ?>index.php/";
		var assets_img = "<?php print assets_img(); ?>";
		var first_visit = "<?php print $this->session->userdata('first_visit');  ?>";
		YT_LOADED_SUCCESSFULLY = false;
	</script>
	<!-- Angualr controllers -->
	<script type="text/javascript" src="<?php assets_js();?>tipsy.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
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
	<!-- Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-48895589-1', 'zonglist.com');
	  ga('send', 'pageview');

	</script>
</body>
</html>