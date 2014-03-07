<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h2> <span class="oleo">Playlist: <?php print $playlist['playlist_data']->name;?></span></h2>
	<hr />
	<?php if(!empty($playlist['playlist_songs'])): ?>
	<a href="#" class="btn btn-default" id="create-pack-download" data-playlist="<?php print $playlist['playlist_data']->list_id;?>">Download all</a>
	<br /><br />
	<div class="alert alert-warning" id="watchdog" style="display:none">
		<span class="glyphicon glyphicon-time"></span>&nbsp;Please wait while we are creating your download pack..
	</div>
	<h3 class="oleo">Playlist tracks</h3>

		<?php foreach($playlist['playlist_songs'] as $song): ?>

		<div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<span style="font-size:12px;"><?php print str_replace('.mp3','',str_replace('_',' ',$song->song_name));?></span>
			  </div>
			  <div class="panel-body">
			  
			   <audio controls style="width:100%">
					<source src="<?php print base_url();?>downloads/2/<?php print $song->song_name;?>" type="audio/mpeg">
					Your browser does not support HTML default MP3 player. Sorry for that. Please go ahead and download each song or the entire playlist.
				</audio>
			    <hr />
			   	<a style="width:100%" href="<?php print base_url();?>download/hash/<?php print $song->download_url;?>" class="btn btn-primary btn-sm">Download</a>
			  </div>
			</div>
		</div>
		<?php endforeach; ?>

		<br />
	<?php else: ?>
		<div class="alert alert-warning" id="view-playlist-watchdog">
			<span class="glyphicon glyphicon-fire"></span>&nbsp;Oohh.. It burns to see there are no songs out here. Go to your dashboard and download a song tagged in this playlist! As soon as you'll have one, it will be available to download here and on your mobile phone!
		</div>
		<a href="<?php print base_url();?>" class="btn btn-success">Click to download a song&nbsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
	<?php endif; ?>
</div>