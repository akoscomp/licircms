<?php
require_once('authenticate.php');

$configUrl = "data/config.json";
$jsonConfig = file_get_contents($configUrl);
$config = json_decode($jsonConfig, TRUE);

include "functions.php";

$header = "Content-Type: application/json";
header($header);

$room = $_POST["room"];
$stat = $_POST["stat"];

if (isset($config['rooms'][$room])) {
    require('lib/routeros_api.class.php');
    $API = new routeros_api();

    if ($API->connect($config['mikrotik']['host'], $config['mikrotik']['user'], $config['mikrotik']['password'])) {
        $API->write("/ip/firewall/filter/print", false);
        $API->write("?comment=".$room."-net-kikapcs");

        $READ = $API->read(false);
        $ARRAY = $API->parse_response($READ);

        $id=$ARRAY[0]['.id'];
        $action=$ARRAY[0]['action'];

    if ($stat == 'get') {
        rcmslog("Get internet status: ".$room.", action: ".$id.$action);
        if ($ARRAY[0]['action'] == 'accept') {
            print json_encode("1");
        } else {
            print json_encode("0");
        }
    } else {
        rcmslog("Start/Stop internet: ".$room.", action: ".$id.$action);
        $API->write("/ip/firewall/filter/set", false);
        $API->write("=.id=".$ARRAY[0]['.id']."", false);
        if ($ARRAY[0]['action'] == 'accept') {
            $API->write("=action=drop");
            print json_encode("0");
        } else {
            $API->write("=action=accept");
            print json_encode("1");
        }
        $READ = $API->read(false);
        $ARRAY = $API->parse_response($READ);
    }
    $API->disconnect();
    }
} else rcmslog("!!!!!!!!!!!!!!!!! INVALID ROOM: ".$room);
?>