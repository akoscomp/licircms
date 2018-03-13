<?php
    // admin - index.php
    include('functions.php');
    include('header.php');
?>

<script src="../js/jquery.tabletojson.min.js"></script>
<script>

function compListJson()
{
 var table = $('#rooms').tableToJSON();
 alert(JSON.stringify(table));  
}

</script>

<div class="container">
	<div class="jumbotron">
		<h2>Admin page</h2>
	</div>
</div>

<?php
$configUrl = "../data/config.json";
$jsonConfig = file_get_contents($configUrl);
$config = json_decode($jsonConfig, TRUE);

//print_r($config['rooms']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo('aaa');
    if ( (isset($_POST["row"]))) {
        print_r($_POST["row"]);
        echo('bbb');
        /*
        foreach ($_POST["row"] as $comp) {
            if ($computers[substr($comp,0,17)]['room'] != substr($comp,17)) {
                if (!((substr($comp,17) == 'none') && ($computers[substr($comp,0,17)]['room'] == ''))) {
                    $computers[substr($comp,0,17)]['room'] = substr($comp,17);
                }
            }
        }
        $out = json_encode($computers, JSON_PRETTY_PRINT);
        file_put_contents($url, $out);
         * 
         */
    }
}  

?>

<div class="container col-md-8">
<div class="highlight">
<pre>
<h5><small>ROOMS</small></h5>
<table id="rooms" class="tableRooms table table-striped">
    <thead>
    <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Guest Access</td>
    </tr>
    </thead>
    <tbody>
        <?php
        foreach ($config['rooms'] as $room => $members) {
            echo '<tr>';
            //echo '<td name="row[id][]">'.$members['id'].'</td>';
            echo '<td><input name="row[id][]" class="roomText" type="text" value="'.$members['id'].'" disabled></td>';
            echo '<td><input name="row[name][]" class="roomText" type="text" value="'.$members['name'].'"></td>';
            echo '<td>'.($members['guestaccess'] ? '<input name="row[guest][]" type="checkbox" checked>' : '<input type="checkbox">' );
            //echo '<td>'.$members['guestaccess'].'</td>';
            echo '</tr>';
        }
        ?>
    <tr>
        <td><input name="row[id][]" type="text" class="form-control" id="roomId" placeholder="Room id"></input></td>
        <td><input name="row[name][]" type="text" class="form-control" id="roomName" placeholder="Room name"></input></td>
        <td><input name="row[guest][]" type="checkbox" id="guestAccess"></input></td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"><button id="submit-rooms" class="btn btn-primary btn-success" value="Add/Modify" onclick="compListJson()">Add/Modify</button></td>
    </tr>
    </tfoot>
</table>
</pre>
</div>
</div>


<?php
    include('footer.php');
?>
