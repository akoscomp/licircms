<!DOCTYPE html>
<?php
// admin - header.php

include_once("../functions.php");
include_once("functions.php");
require_once('authenticate.php');

$configUrl = "../data/config.json";
$jsonConfig = file_get_contents($configUrl);
$config = json_decode($jsonConfig, TRUE);

if(!inGroup('admin')):
    header('Location: ../index.php');
endif;
?>

<html>
    <head>
        <title>rcms2</title>
            <meta http-equiv="content-type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href = "../css/bootstrap.css" rel = "stylesheet">
            <link href = "../css/tablesorter.css" rel = "stylesheet">
            <link href = "../css/style.css" rel = "stylesheet">

    </head>
    <body>

    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/functions.js"></script>

        <div class="navbar navbar-inverse navbar-static-top">
            <div class="container">

                <a href="../index.php" class="navbar-brand">rcms2 Admin - <?=$_SESSION['username']?></a>

                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div class="collapse navbar-collapse navHeaderCollapse">
                    <ul class = "nav navbar-nav navbar-right">
                        <li class="active"><a href="index.php">Config</a></li>
                        <li><a href="users.php">Users</a></li>
                        <li><a href="compRoom.php">Computers</a></li>
                        <li><a href="join.php">Add users</a></li>
                        <li><a href="cron.php">Cron</a></li>
                    </ul>
                </div>
            </div>
        </div>
    