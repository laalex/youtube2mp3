<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main_dashboard">
	<div class="alert alert-info" id="watchdog" style="display:none"></div>

	<div ng-view></div>
	<!-- WATCHDOG -->
	
	<br />
	<div id="current-vd-downloads-holder"></div>
	<div id="video-download-response" style="position:relative;display:none;">
		<div  class="close video-close" aria-hidden="true" style="right:10px;top:10px;cursor:pointer;z-index:9999;position:absolute">&times;</div>
		<!-- VIDEO ENTRY -->
		<div class="video-entry">

			<div class="video-thumbnail">
				<img src="" style="background:#bbb;">
			</div>

			<div class="video-details">

				<div class="video-title">
					<h4></h4>
				</div>

				<div class="video-data">
					<span class="download-tag label label-info"></span>
					<br /><br />
					<a href="#" target="_blank" class="btn btn-success btn-sm download-action" style="display:none">Download MP3</a>

					<!-- Single button -->
					<div class="btn-group playlist-selector" style="display:none">
					  <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
					    Add this song to a playlist &nbsp;<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu playlist-updater" role="playlist-updater"> 
					  	<?php foreach($playlists as $pl):
					  		if($pl->default == 1):
					  			?>
					  				<li><a href="#" class="set-song-playlist" data-id="<?php print $pl->list_id; ?>"><span class="glyphicon glyphicon-music"></span> <?php print $pl->name;?></a></li>
					    			<li class="divider"></li>
					  			<?php
					  		else:
					  			?>
					  				<li><a href="#" class="set-song-playlist" data-id="<?php print $pl->list_id; ?>"><span class="glyphicon glyphicon-th-list"></span> <?php print $pl->name;?></a></li>
					  			<?php
					  		endif;
						endforeach; ?>
					  </ul>
					</div>
				</div>

			</div>

			<div class="video-progressbar-holder">
				<div class="video-progressbar"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>