	<!-- MP3  player -->
	<div id="mp3player">
		<div id="song_name">
			<span class="label" id="mp3_songname">Smiley - Oficial imi merge bine</span>
		</div>
		<br />
		<div id="player_controls">
			<span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;
			<span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;
			<span class="label label-success" id="song_time">
				<span class="label label-danger" id="song_time_elapsed"></span>
			</span>&nbsp;&nbsp;
			<span class="glyphicon glyphicon-forward"></span>&nbsp;&nbsp;
		</div>
		<div id="elapsed_time">
			<div id="mp_elapsed">0:15</div>
			<div id="mp_total">/ 3:50</div>
		</div>
		<div id="volume_control">
			<span class="glyphicon glyphicon-volume-off" style="display:inline-block;">
			<span class="label label-success" id="volume_cursor">
				<span class="label label-danger" id="volume_selected"></span>
			</span>
			<span class="glyphicon glyphicon-volume-up">
		</div>
	</div>
	<!-- SCRIPTS -->
	<script type="text/javascript">
		var baseurl = "<?php print base_url(); ?>";
		var assets_img = "<?php print assets_img(); ?>";
	</script>
	<!-- Angualr controllers -->
	<script type="text/javascript" src="<?php assets_js();?>mp3player.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>application.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/dashboard.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/playlists.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/view_playlist.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>bootstrap.min.js"></script>
</body>
</html>