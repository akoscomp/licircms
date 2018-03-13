#!/usr/bin/php
<?php


$file = "/home/akos/rcms/server/computers.json";
$computers = json_decode(file_get_contents($file), true);

//set all computers powerstate to 0
foreach ($computers as $k => $v) {
    $computers[$k]['hostname']=gethostbyaddr($computers[$k]['ip']);
}

file_put_contents($file, json_encode($computers, JSON_PRETTY_PRINT));

?>
