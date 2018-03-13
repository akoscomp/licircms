<?php
ob_start();
date_default_timezone_set('Europe/Bucharest');

$usersUrl = "data/users.json";
$jsonUsers = file_get_contents($usersUrl);
$users = json_decode($jsonUsers, TRUE);

$configUrl = "data/config.json";
$jsonConfig = file_get_contents($configUrl);
$config = json_decode($jsonConfig, TRUE);

include("functions.php");

if ($config['debug']) error_reporting(E_ALL);

?>
