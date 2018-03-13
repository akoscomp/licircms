<?php
require_once('authenticate.php');

unset($_SESSION["username"]);
unset($_SESSION["password"]);
unset($_SESSION["authenticated"]);

session_unset();
session_destroy();

header('Location: login.php');
?>
