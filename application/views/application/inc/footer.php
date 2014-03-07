	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Confirm action</h4>
	      </div>
	      <div class="modal-body">Are you sure you want to take this action?</div>
	      <div class="modal-footer">
	        <a type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</a>
	        <a type="button" class="btn btn-primary btn-sm" id="confirm_url">Yes</a>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- SCRIPTS -->
	<script type="text/javascript">
		var baseurl = "<?php print base_url(); ?>";
		var assets_img = "<?php print assets_img(); ?>";
	</script>
	<script type="text/javascript" src="<?php assets_js();?>bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php assets_js();?>application.js"></script>
</body>
</html>