<?php
include_once("config.php");
session_start();

$username = null;
$password = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if(isset($users[$username]) && (hash('sha256', $password)==$users[$username]['password']) && ($users[$username]['enable'])) {
            $_SESSION["authenticated"] = 'true';
            $_SESSION["username"] = $username;
            header('Location: index.php');
        }
        else {
            if ($config['ldapauth']){
                echo "ldap";
                $adServer = $config['ldapServer'];
                $ldap = ldap_connect($adServer);
                $ldaprdn = $config['ldapDn'] . "\\" . $username;
                ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
                $bind = @ldap_bind($ldap, $ldaprdn, $password);

                if ($bind){
                    //establish your session and redirect
                    session_start();
                    $_SESSION["authenticated"] = 'true';
                    //$_SESSION["username"] = 'guest';
                    $_SESSION["username"] = $username;
                    $_SESSION["ldapusername"] = $username;
                    header('Location: index.php');
                    exit;
                }
                else {
                    sleep(3);
                    header('Location: login.php');
                }
            }
            else {
                sleep(3);
                header('Location: login.php');
            }
        }
    } else {
        header('Location: login.php');
    }
} else {
    
    if (!$config['autentication'] && !$_SESSION["authenticated"]){
    $_SESSION["authenticated"] = 'true';
    $_SESSION["username"] = 'guest';
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>rcms login</title>
	<link href = "css/bootstrap.min.css" rel = "stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="navbar navbar-inverse navbar-static-top">
	<div class="container">
		<div class="navbar-brand">rcms</div>
	</div>
</div>

<div class="container">
	<form class="form-horizontal" role="form" name="form1" method="post" action="<?=$_SERVER["PHP_SELF"];?>" autocomplete="off">
	  <div class="form-group">
		<label for="username" class="col-sm-2 control-label">Username</label>
		<div class="col-sm-4">
		  <input type="text" name="username" value="<?= isset($_POST["login"]) ? $_POST["login"] : "" ; ?>" id="username" placeholder="username" pattern="[a-zA-Z0-9.]{4,}" title="Minmimum 4 letters or numbers required." class="form-control">
		</div>
	  </div>
	  <div class="form-group">
		<label for="password" class="col-sm-2 control-label">Password</label>
		<div class="col-sm-4">
		  <input type="password" name="password" id="password" placeholder="Password" pattern=".{4,}" title="Minmimum 4 letters or numbers required." class="form-control">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		  <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
		</div>
	  </div>
	</form>
</div>

</body>
</html>
<?php } ?>