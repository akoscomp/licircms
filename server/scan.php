#!/usr/bin/php
<?php

function scan()
{
    $out = array();
    exec("sudo arp-scan --interface=eth0 --localnet | grep '[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}'", $out);

    foreach ($out as &$line) {
	$arr = explode("\t", $line);
	$list[$arr[1]] = array( 'ip' => $arr[0], 'mac' => $arr[1], 'manufac' => $arr[2], 'hostname' => gethostbyaddr( $arr[0] ));
    }
    return $list;
}

$scanList=scan();

$file = "/home/akos/rcms/server/computers.json";
$computers = json_decode(file_get_contents($file), true);

//set all computers powerstate to 0
foreach ($computers as $k => $v) {
    $computers[$k]['powerstate']=0;
    //delete old computers without hostname and room
    $deletetime = 604800; //time in seconds
    if ((getdate()['0'] - $computers[$k]['dateLastSeen']['0'] > $deletetime) 
            && ($computers[$k]['ip'] === $computers[$k]['hostname'])
            && ($computers[$k]['room'] === '')) {
        unset($computers[$k]);
    }
}
//print_r($computers); 

//if the computer is power on set the power state to 1
foreach($scanList as $slk => $slv) {
    if (isset($computers[$slv['mac']]['ip'])) {
        $computers[$slv['mac']]['powerstate'] = 1;
        $computers[$slv['mac']]['dateLastSeen'] = getdate();
        if ($computers[$slv['mac']]['hostname'] != $slv['hostname'])
            $computers[$slv['mac']]['hostname'] = $slv['hostname'];
        if ($computers[$slv['mac']]['ip'] != $slv['ip'])
            $computers[$slv['mac']]['ip'] = $slv['ip'];
    }
    else //if not exists, create it
    {
	//echo "Create host: ", $slv['hostname'], "\n";
	$computers[$slv['mac']]['ip'] = $slv['ip'];
	$computers[$slv['mac']]['mac'] = $slv['mac'];
	$computers[$slv['mac']]['manufac'] = $slv['manufac'];
	$computers[$slv['mac']]['hostname'] = $slv['hostname'];
	$computers[$slv['mac']]['room'] = "";
	$computers[$slv['mac']]['powerstate'] = 1;
	$computers[$slv['mac']]['os'] = "";
	$computers[$slv['mac']]['poweron'] = 0;
	$computers[$slv['mac']]['poweroff'] = 0;
	$computers[$slv['mac']]['owner'] = "";
	$computers[$slv['mac']]['comments'] = "";
	$computers[$slv['mac']]['dateAdd'] = getdate();
	$computers[$slv['mac']]['dateLastSeen'] = getdate();
    }
}

file_put_contents($file, json_encode($computers, JSON_PRETTY_PRINT));

//print_r($computers);
$current_date = date('Y-m-d - H:i:s');
echo $current_date." - Cron scan completed.\n";
?>
