<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main_dashboard">
	<div class="alert alert-info" id="watchdog" style="display:none"></div>

	<h1>Feedback from users</h1>
	<hr />
	<?php if(!empty($feedback)) foreach($feedback as $f): ?>
	<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Feedback submited at: <b><?php print $f->date_submited; ?></b></h3>
			</div>
			<div class="panel-body">
				<h4>Browser data</h4>
				<table class="table table-condensed">
					<thead>
					<?php foreach($f->feedback_data['browser'] as $k=>$v): ?>
						<th><?php print $k; ?></th>
					<?php endforeach;?>
					</thead>
					<tr>
					<?php foreach($f->feedback_data['browser'] as $k=>$v): ?>
						<td>
							<?php if(is_array($v)):
								foreach($v as $nv): print '<label class="label label-info">'.$nv.'</label><br />'; endforeach;
							      else:
							      	print $v;
							      endif;
							?>
						</td>
					<?php endforeach;?>
					</tr>
				</table>
				<hr />
				<h4>URL:</h4>
				<label class="label label-default"><?php print $f->feedback_data['url']; ?></label>
				<hr />
				<h4>Screen capture for the feedback:</h4>
				<img src="<?php print $f->feedback_data['img']; ?>" style="width:100%;height:100%;">
				<hr />
				<h4>Feedback Comments</h4>
				<p><?php print $f->feedback_data['note']; ?></p>

			</div>
		</div>

	<?php endforeach; ?>
</div>