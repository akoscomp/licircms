<?php
include_once("config.php");
header('Location: index.php');

if(!loggedIn()):
header('Location: index.php');
endif;

print("Welcome to the members page <b>".$_SESSION["login"]."</b><br>\n");
print("Your password is: <b>".$_SESSION["password"]."</b><br>\n");
print("<a href=\"index.php"."\">index</a>");

print("<a href=\"logout.php"."\">Logout</a>");
?>
