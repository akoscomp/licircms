<!DOCTYPE html>
<?php
require_once('authenticate.php');
include_once('config.php');
if(isset($_GET['room'])) {
        $roomId=$_GET['room']; }
    else {
        $roomId="all";
}
?>

<html>
    <head>
        <title>rcms2</title>
            <meta http-equiv="content-type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
            <link rel = "stylesheet" href = "css/tablesorter.css" >
            <link href = "css/style.css" rel = "stylesheet">
    </head>
    <body>

    <script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>

        <div class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                
                <a href="index.php" class="navbar-brand">rcms2 - <?=$roomId?> - <?=$_SESSION['username']?></a>
                
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <div class="collapse navbar-collapse navHeaderCollapse">
                    
                    <ul class = "nav navbar-nav navbar-right">
                        
                        <li class="active"><a href="index.php">Home</a></li>
                        
                        <li class = "dropdown">
                            <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">Computers <b class = "caret"></b></a>
                            <ul class = "dropdown-menu">
                                <?php
                                foreach ($config['rooms'] as $line => $room) {
                                    if(inGroup('admin') || inGroup($room['id']) || ((!$config['autentication']) && inGroup($room['id'], 'guest'))) {
                                    echo '<li><a href="compRoom.php?room='.$room["id"].'" id="'.$room["id"].'">'.$room["name"].'</a></li>';
                                }}
                                ?>
                            </ul>
                        </li>
                        <?php
                        if(inGroup('bell')) echo '<li><a href="ring.php">Bell</a></li>';
                        if($config['contactform']) echo '<li><a href="#contact" data-toggle="modal">Contact Me</a></li>';
                        if(inGroup('admin')) echo '<li><a href="admin/">Admin</a></li>';
                                if(!loggedIn() || (isset($_SESSION["username"]) && ($_SESSION["username"] == 'guest'))) {
                                    echo '<li><a href="login.php">Login</a></li>';
                                }
                                else
                                {
                                    echo '<li><a href="logout.php">Logout</a></li>';
                                }
                            ?>
                    </ul>
                
                </div>
            </div>
        </div>

        <div class="modal fade" id="contact" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Contact Tech Site</h4>
                    </div>
                    <div class="modal-body">
                        <p><?=$users[$_SESSION["username"]]["fullname"]?> - <?=$users[$_SESSION["username"]]["email"]?></p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">Send</a>
                        <a class="btn btn-primary" data-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>
