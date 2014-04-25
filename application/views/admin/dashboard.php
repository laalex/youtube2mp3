<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main_dashboard">
	<div class="alert alert-info" id="watchdog" style="display:none"></div>

	<h1>Dashboard</h1>
	<hr />

	<div class="row">
		<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Accounts information</h3>
			</div>
			<div class="panel-body">
				There are currently <b><?php print $accounts; ?></b> created accounts.
			</div>
		</div>
		</div>

		<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Songs information</h3>
			</div>
			<div class="panel-body">
				<label class="label label-info">Songs downloaded: <?php print $songs['count']; ?></label>
				<label class="label label-warning">Songs active: <?php print $songs['active']; ?></label>
			</div>
		</div>
		</div>

		<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Playlits information</h3>
			</div>
			<div class="panel-body">
				There are currently <b><?php print $playlists; ?></b> created playlists.
			</div>
		</div>
		</div>

		<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Space usage</h3>
			</div>
			<div class="panel-body">
				There are currently <b><?php print $space_used; ?></b> MB used by 'downloads' folder.
			</div>
		</div>
		</div>

	</div>
	<div class="clearfix"></div>
	<hr />
	<br />
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Feedback count</h3>
		</div>
		<div class="panel-body">
			Feedback received number: <h1><?php print $feedback; ?></h1>
		</div>
	</div>
</div>