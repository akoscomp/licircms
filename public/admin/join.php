<?php
include('header.php');

$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!($_POST["password"] == $_POST["password2"])):
		echo "<p>Your passwords did not match</p>";
		exit;
	endif;

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $users = null;
        
        $usersUrl = "../data/users.json";
        $jsonUsers = file_get_contents($usersUrl);
        $users = json_decode($jsonUsers, TRUE);
	if (!isset($users[$username])) {
                $users[$username]['enable'] = 1;
                $users[$username]['password'] = hash('sha256', $_POST["password"]);
                $users[$username]['fullname'] = $_POST["fullname"];
                $users[$username]['email'] = $_POST["email"];
		//rcmslog("New user: ".$_POST["username"]);
                file_put_contents($usersUrl, json_encode($users, JSON_PRETTY_PRINT));
//		header("Location: join.php");
        }
	else {
	  echo '<p>Username already exists, please choose another username.</p>';
        }
    }
}
?>

<html>
<head>
        <title>rcms join</title>
        <link href = "../css/bootstrap.min.css" rel = "stylesheet">
        <link href = "../css/style.css" rel = "stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
   <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST" role="form" class="form-style">
      <h2 class="text-center">Sing Up</h2>
      <div class="form-group">
        <label for="inputUsername">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>">
      </div>
      <div class="form-group">
        <label for="inputFullname">Fullname</label>
        <input type="text" class="form-control" name="fullname" placeholder="Fullname">
      </div>
      <div class="form-group">
        <label for="inputEmail">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="E-mail" size=30>
      </div>
      <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password" size=30>
      </div>
      <div class="form-group">
        <label for="inputPassword">Repeat Password</label>
        <input type="password" class="form-control" name="password2" placeholder="Password (repeat)" size=30>
      </div>
      <button class="btn btn-large btn-primary" type="submit" name="submit" value="Submit">Sign Up</button>
   </form>
</body>
</html>
