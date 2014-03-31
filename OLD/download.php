<?php
$file = 'downloads/'.base64_decode($_GET['file']);
header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=".$file);
header("Content-Length: ".filesize($file));
readfile($file);
exit;
?>