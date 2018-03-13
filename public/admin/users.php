<?php
    include('functions.php');
    include('header.php');
?>
    <script>
        $('groupbtn1').click(function (){
            alert('valami');
        });
    </script>

<?php
$usersUrl = "../data/users.json";
$jsonUsers = file_get_contents($usersUrl);
$users = json_decode($jsonUsers, TRUE);

$configUrl = "../data/config.json";
$jsonConfig = file_get_contents($configUrl);
$config = json_decode($jsonConfig, TRUE);
?>


<table id="table-users" class="table table-bordered">
   <thead>
        <tr class="warning">
            <th>User</th>
            <th>Member in Groups</th>
            <th>Add in new group</th>
        </tr>
    </thead>
    <tbody>

	<?php
	    foreach ($users as $user => $doc) {
                if($user != 'admin'){
              print("<tr>");
	        print("<th>".$user."</th>");
		print("<th>");

                foreach ($config['groups'] as $group => $members){
                    if (userInGroup($user, $group)) {
                        print('<span class="label label-success">'.$group.' <button class="akos" data-acction="remove" data-group="'.$group.'" data-user="'.$user.'" data-dismiss="alert" aria-hidden="true" onclick="groupAddRemove(this)">&times;</button></span> ');
                    }
		}
		print("</th>");
		print("<th>");
		foreach ($config['groups'] as $group => $members){
                    if (!userInGroup($user, $group)) {
                        print('<span class="label label-success">'.$group.' <button class="akos" data-acction="add" data-group="'.$group.'" data-user="'.$user.'" data-dismiss="alert" aria-hidden="true" onclick="groupAddRemove(this)">&times;</button></span> ');
                    }
		}
		print("</th>");
	      print("</tr>");
                }
	    }
	?>
    </tbody>
</table>
<?php



?>

<?php
    include('footer.php');
?>
