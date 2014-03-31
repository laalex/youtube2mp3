
	<!-- SCRIPTS -->
	<script type="text/javascript">
		var baseurl = "<?php print base_url(); ?>";
		var assets_img = "<?php print assets_img(); ?>";
	</script>
	<!-- Angualr controllers -->
	<script type="text/javascript" src="<?php assets_js();?>application.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/dashboard.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/playlists.js"></script>
	<script type="text/javascript" src="<?php print base_url();?>ngapp/controllers/view_playlist.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>bootstrap.min.js"></script>
</body>
</html>