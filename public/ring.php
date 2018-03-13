<?php
include('header.php');

//if(in_array($_SESSION['username'], $config['groups']['bell'])){
    if(inGroup('bell')){
?>

<script>
	$(document).ready(function() {
		bellStop();
    });
</script>

<div class="container">
    <div class="jumbotron text-center">
        <h1>Bell</h1>
            <a id="ringStartStop" class="btn btn-lg btn-default btn-success" onclick="bellStartStop(this)">Start</a>
    </div>
</div>


<?php


ob_start(); // begin collecting output
    include 'getCron.php';
$result = ob_get_clean(); // retrieve output from myfile.php, stop buffering

//print_r($result);

}
include('footer.php');
?>
