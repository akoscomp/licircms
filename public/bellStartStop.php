<?php
require_once('authenticate.php');

$header = "Content-Type: application/json";
header($header);

$exec = '/usr/bin/python /home/akos/rcms/bell/ringweb.py '.$_POST["button"];
exec( $exec, $out);

if ($out) {
    print json_encode($out);
}
?>
