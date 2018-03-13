<?php

require_once('authenticate.php');

$exec = 'sudo /usr/bin/crontab -l -u akos | grep -v "#"';
exec($exec, $out);

if ($out) {
//    print json_encode($out);
    print json_encode(preg_split("/\s+/", $out[0]));
}
?>
