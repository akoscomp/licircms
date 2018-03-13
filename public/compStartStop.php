<?php
require_once('authenticate.php');
include_once("config.php");

$header = "Content-Type: application/json";
header($header);

if ($_POST["button"] == "Start") {
    //get mac address from browser
      $exec = 'sudo wakeonlan '.$_POST["mac"];
    //exectute the command
      exec( $exec, $out);
      rcmslog($exec);
      print json_encode($out);
}
 elseif ($_POST["button"] == "Stop") {
     //$exec = 'net rpc shutdown -t 5 -f -C "Remote Shutdown" -S '.$_POST['hostname'].' -U '.$config['domain'].'\\testuser8%1qazXSW@';
     //net rpc ABORTSHUTDOWN -S cs54-na.codespring.local -U codespring.local\\nagy.akos%aaaa
     $exec = 'net rpc shutdown -t 500 -f -C "Remote Shutdown" -S '.$_POST["hostname"].' -U '.$config["domain"].'\\\\'.$_POST["username"].'%'.$_POST["password"].' &';
     //exectute the command
     exec($exec, $out);
     rcmslog(json_encode($out).' hostname: '.$_POST['hostname'].', user: '.$_POST['username']);
     if (isset($out[1])) {
        //print json_encode('Success');
         $success=true;
     }
     else {
        //print json_encode('Fail');
         $success=false;
     }
     print json_encode($success);
} elseif ($_POST["button"] == "StartAll") {
     $url = "../server/computers.json";
     $json = file_get_contents($url);
     $computers = json_decode($json, TRUE);

     foreach($computers as $comp => $compVal) {
         if (($compVal['room'] == $_POST["room"]) && ($compVal['powerstate'] == 0)) {
            $exec = 'sudo wakeonlan '.$compVal['mac'];
            exec( $exec, $out);
         }
     }
     rcmslog('Start All computer in room: '.$_POST["room"]);
     print json_encode('Start All computers in room: '.$_POST["room"]);
} elseif ($_POST["button"] == "StopAll") {
     $url = "../server/computers.json";
     $json = file_get_contents($url);
     $computers = json_decode($json, TRUE);

     foreach($computers as $comp => $compVal) {
         if (($compVal['room'] == $_POST["room"])) {
            $exec = 'net rpc shutdown -t 5 -f -C "Remote Shutdown" -S '.$_POST["hostname"].' -U '.$config["domain"].'\\\\'.$_POST["username"].'%'.$_POST["password"].' &';
            //exec( $exec, $out);
         }
     }
     rcmslog('Stop All');
     print json_encode('Stop All computers in room: '.$_POST["room"]);
} else {
     rcmslog('Start/Stop Error!');
}
?>
