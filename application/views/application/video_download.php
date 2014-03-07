<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>

	<div class="container">
		<br /><br />
		<h2>Copy and paste youtube link below</h2>
		<br />
		<form  id="convert_video" method="post">
			<input type="text" class="form-control" id="videourl" placeholder="Input your youtube video URL over here">
			<br />
			<input type="submit" class="btn btn-success" value="Load video">
		</form>
		<br />

		<div id="playlist"></div>

	</div>



</body>
</html>