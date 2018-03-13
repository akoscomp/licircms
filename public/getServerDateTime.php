<?php
include_once("config.php");
if(!loggedIn()):
	header('Location: login.php');
endif;

$header = "Content-Type: application/json";
header($header);

$date = date("Y-m-d H:i:s");
$data = array("ServerDateTime" => $date);
print json_encode($data);
?>
