<?php
//admin - compRoom

include('header.php');

$url = "../../server/computers.json";
$json = file_get_contents($url);
$computers = json_decode($json, TRUE);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //echo('aaa');
    if ( (isset($_POST["compList"]))) {
        foreach ($_POST["compList"] as $comp) {
            if ($computers[substr($comp,0,17)]['room'] != substr($comp,17)) {
                if (!((substr($comp,17) == 'none') && ($computers[substr($comp,0,17)]['room'] == ''))) {
                    $computers[substr($comp,0,17)]['room'] = substr($comp,17);
                }
            }
        }
        $out = json_encode($computers, JSON_PRETTY_PRINT);
        file_put_contents($url, $out);
    }
}    
?>

<script src="../js/jquery.tablesorter.min.js"></script>
<script>

    $(document).ready(function() {
        $("#computerList").tablesorter();
    });

</script>

    <div class="container admin-computers">
    <div class="row">
    <div class="span6">
    <div class="table-responsive">
    <form acction="compRoom.php" method="post">
        <table id="computerList" class="table table-striped table-bordered table-condensed tablesorter">
        <thead>
                <tr class="warning">
                        <th>Mac</th>
                        <th>IP</th>
                        <th>Computer name</th>
                        <th>Room</th>
                </tr>
        </thead>
        <tbody>
<?php
    $subst = $config['subbstitutedomain'];
    $domain = $config['domain'];

    foreach($computers as $comp => $compVal) {
   
    echo "<tr>";
    echo "<td>".$compVal['mac']."</td>";
    echo "<td>".$compVal['ip']."</td>";
    
        if ($subst) //check when the substitutedomain is 1 in config.json
            echo '<td>'.str_replace(".".$domain, "", $compVal['hostname']).'</td>';
          else
            echo '<td>'.$compVal['hostname'].'</td>';
            echo '<td>';
            echo '<select class="form-control input-sm" name="compList[]">';
            //'.$compVal["mac"].'
            echo '<option value="'.$compVal['mac'].'none">- none -</option>';
            foreach ($config['rooms'] as $room) {
                if ($compVal['room'] == $room['id']) 
                    echo '<option value="'.$compVal['mac'].$room["id"].'" selected>'.$room["name"].'</option>';
                else 
                    echo '<option value="'.$compVal['mac'].$room["id"].'">'.$room["name"].'</option>';
            }
            echo '</select>';
            echo '</td>';
            echo '</tr>';
}
?>
            </tbody>
            <tfoot>
                <tr class="active">
                    <th colspan="4">
                        <input type="submit" name="submit" class="btn btn-success" value="Submit">
                    </th>
                </tr>
            </tfoot>
    </table>
    </form>
    </div>
    </div>
    </div>
    </div>

<?php
    include('footer.php');
?>
