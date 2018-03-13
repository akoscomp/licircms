        <div class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <p class="navbar-text pull-left">rcms footer</p>
                <?php
                    if(isset($_SESSION["username"]) && ($_SESSION["username"] != 'guest')) {
                        echo '<a href="logout.php" class="navbar-btn btn-danger btn pull-right">Logout</a>';
                    }
                    if ($_SERVER['PHP_SELF'] == '/compRoom.php') {
                        //echo '<button id="refresh" class="navbar-btn btn-info btn pull-right has-spinner" onclick="refresh()">Refresh <img id="refreshSpin" style="display:none;" src="css/spin.gif"></button>';
                        echo '<button id="refresh" class="navbar-btn btn-info btn pull-right has-spinner" onclick="refresh()"><span class="spinner"><i class="fa fa-refresh fa-spin"></i></span>Refresh</button>';
                        //echo '<button id="refresh" class="navbar-btn btn-info btn pull-right" onclick="refresh()">Refresh</button>';
                } ?>
            </div>
        </div>
    </body>
</html>
