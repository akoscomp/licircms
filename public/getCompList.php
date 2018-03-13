<?php
//Return computer list from database

include_once("config.php");
if(!loggedIn()):
        header('Location: login.php');
endif;

$header = "Content-Type: application/json";
header($header);
/*
$computers = new MongoCollection($db, 'computers');

$cursor = $computers->find();
$array = iterator_to_array($cursor, false);

echo json_encode($array);
*/
$file = "../server/computers.json";
echo file_get_contents($file);

?>
