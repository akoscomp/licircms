<?php

/* 
 * Copyright (C) Error: on line 4, column 33 in Templates/Licenses/license-gpl30.txt
The string doesn't match the expected date/time format. The string to parse was: "2014.01.24.". The expected format was: "MMM d, yyyy". nagy.akos
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('authenticate.php');
include_once("config.php");

$header = "Content-Type: application/json";
header($header);

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

$file = "../server/computers.json";
$computers = json_decode(file_get_contents($file), true);

//set all computers powerstate to 0
foreach ($computers as $k => $v) {
    $computers[$k]['powerstate']=0;
}
//print_r($computers); 

//if the computer is power on set the power state to 1
foreach($scanList as $slk => $slv) {
    if (isset($computers[$slv['mac']]['ip'])) {
        $computers[$slv['mac']]['powerstate'] = 1;
        $computers[$slv['mac']]['dateLastSeen'] = getdate();
        if ($computers[$slv['mac']]['hostname'] != $slv['hostname'])
            $computers[$slv['mac']]['hostname'] = $slv['hostname'];
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
$out = "Web rescan completed.";
rcmslog($out);

echo json_encode($out);
?>
