	<!-- SCRIPTS -->
	<script type="text/javascript">
		var baseurl = "<?php print base_url(); ?>index.php/";
		var assets_img = "<?php print assets_img(); ?>";
		var first_visit = "<?php print $this->session->userdata('first_visit');  ?>";
		YT_LOADED_SUCCESSFULLY = false;
	</script>
	<!-- Angualr controllers -->
	<script type="text/javascript" src="<?php assets_js();?>admin.js"></script>

</body>
</html>