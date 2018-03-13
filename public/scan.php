<?php

$out = array();
exec("sudo arp-scan --interface=eth0 --localnet | grep '[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}'", $out);

foreach ($out as &$line) {
	$arr = explode("\t", $line);
	$list[$arr[1]] = array( 'ip' => $arr[0], 'mac' => $arr[1], 'manufac' => $arr[2], 'hostname' => gethostbyaddr( $arr[0] ));
}

/*
$hostnames = array();
exec("arp -a", $hostnames);

foreach ($hostnames as &$line) {
	$arr = explode(" ", $line);
	$list2[] = array( 'hostname' => $arr[0], 'mac' => $arr[3] );
}

foreach ($list2 as $key2) {
	foreach ($list as $key) {
		if ($key2['mac'] == $key['mac']) {
			$list[$key['mac']]['hostname'] = $key2['hostname'];
		}
	}
}

foreach ($list as $key) {
	if ($key['hostname'] == "") {
		gethostbyaddr( $key['ip'] );
	}
}
*/

print json_encode($list);

?> 