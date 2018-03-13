<?php
include('header.php');

$cronUrl = "../../server/cronjobs";
$file = file($cronUrl);
$fileout[0]="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //print_r($_POST["check"]);
    //print_r($file[0]);
    $n=0;
    foreach($file as $line) {
        if (strlen($line)>3) {
            //if ( in_array($n, $_POST["check"]) ) echo $n;
            if ( (isset($_POST["check"])) && (in_array($n, $_POST["check"]))) {
                if (substr($line, 0, 1) == "#") 
                    $fileout[$n]=substr($line, 1);      //if checked and was comment, remove the comment
                else
                    $fileout[$n]=$line;                 //if checked and was active, leave active
            }
            else {
                if (substr($line, 0, 1) == "#") 
                    $fileout[$n]=$line;                 //if uncecked and commented, leave commented
                else
                    $fileout[$n]='#'.$line;             //if uncecked and active, add comment
            }
        }
        $n++;
    }
    file_put_contents($cronUrl, $fileout);
    exec('sudo crontab -u akos /home/akos/rcms/server/cronjobs');
    $file=$fileout;
}


?>
<form acction="cron.php" method="post">
<table id="cronJobs" class="table table-striped table-bordered table-condensed ">
    <thead>
        <tr class="warning">
            <th>Active</th>
            <th>Cron Job</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $n=0;
    foreach($file as $line) {
        if (strlen($line)>3) {
            if (substr($line, 0, 1) == "#") {
                echo '<tr><th><input type="checkbox" name="check[]" value="'.$n.'"></th>';
                echo '<th>'.substr($line,1).'</th></tr>';
            }
            else {
                echo '<tr><th><input type="checkbox" name="check[]" value="'.$n.'" checked></th>';
                echo '<th>'.$line.'</th></tr>';
            }
        }
        $n++;
    }
    ?>
    </tbody>
    <tfoot></tfoot>
    <tr>
        <th colspan="2">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </th>
    </tr>
</table>
</form>

    <?php
include('footer.php');
?>