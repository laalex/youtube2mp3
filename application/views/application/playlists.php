<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h3>Manage your playlists</h3>
	<hr />
	<?php if(!empty($playlists)): ?>
		<div class="alert alert-info closed" id="add-playlist-watchdog"></div>
		<a href="#add-playlist" id="add-new-playlist" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> &nbsp; Click here to create a playlist</a>
		<!-- Playlist modal -->
		<div class="closed" id="add-new-playlist-form">
		<br />
			<form id="new-playlist-form" method="post">
		      	<input type="text" name="name" placeholder="Playlist name" class="form-control">
		      	<br />
		      	<input type="submit" value="Create playlist" class="btn btn-success">
		    </form>
		</div>
		<hr />
		<table class="table">
			<thead>
				<th>Playlist name</th><th>Actions</th>
			</thead>
			<?php foreach ($playlists as $list): ?>
				<tr>
					<td style="width:80%">
						<span class="label label-default"><span class="glyphicon glyphicon-music"></span>&nbsp;<?php print $list->song_count; ?></span>
						<?php print $list->name;?>
						<?php if($list->default == 1): ?>&nbsp;<span class="label label-warning">Default playlist</span> <?php endif; ?>
					</td>
					<td>
						<a href="<?php base_url();?>playlists/<?php print $list->list_id;?>" class="btn btn-success btn-sm">View playlist</a>
						<a href="<?php base_url();?>playlists/remove/<?php print $list->list_id;?>" class="btn btn-warning btn-sm confirm">Remove</a>
						<a href="<?php base_url();?>playlists/set_default/<?php print $list->list_id;?>" class="btn btn-default btn-sm">Make default</a>
						<!--<a href="" class="btn btn-primary btn-sm">Edit</a>-->
					</td>
				</tr>
			<?php endforeach; ?>
		</table> 
	<?php else: ?>
		<div class="alert alert-warning" id="add-playlist-watchdog">
			You don't have any playlist added yet. Go ahead and add one <span class="glyphicon glyphicon-ok"></span>
		</div>
		<a href="#add-playlist" id="add-new-playlist" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> &nbsp; Click here to create a playlist</a>
		<!-- Playlist modal -->
		<div class="closed" id="add-new-playlist-form">
		<br />
			<form id="new-playlist-form" method="post">
		      	<input type="text" name="name" placeholder="Playlist name" class="form-control">
		      	<br />
		      	<input type="submit" value="Create playlist" class="btn btn-success">
		    </form>
		</div>
	<?php endif; ?>
</div>