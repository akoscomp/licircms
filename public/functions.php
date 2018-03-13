<?php

function loggedIn() {
	if(isset($_SESSION["authenticated"]) && ($_SESSION["authenticated"] == 'true')):
	  return true;
	else:
	  return false;
	endif;
}

function inGroup($group, $user=null) {
    global $config;
    $user= (is_null($user)) ? $_SESSION['username'] : $user;
    if(isset($group)) {
            if(in_array($user, $config['groups'][$group]))
                return true;
            else
                return false;
        }
}


function rcmslog($text) {
//log the acction
  $current_date = date('Y-m-d - H:i:s');
  $logFile = "../server/rcms.log";
  $fh = fopen($logFile, 'a') or die("can't open the logfile");
  fwrite($fh, $current_date." - ".$_SERVER['REMOTE_ADDR']." - $text\n");
  fclose($fh);
}

function printTableRow($compVal, $config, $roomId) {
?>
<tr/>
    <td>
        <div class="glyphicon"><span class="glyphicon-info-sign trigger"></span>
	<div class="mytooltip">
            <div class="boxRow">
                <div class="boxLabel">IP: </div><span class="boxText"><?=$compVal['ip']?></span>
            </div>
            <div class="boxRow">
                <div class="boxLabel">Mac: </div><span class="boxText"><?=$compVal['mac']?></span></br>
            </div>
            <div class="boxRow">
                <?php
                if ($config['subbstitutedomain']) echo '<div class="boxLabel">Hostname: </div><span class="boxText">'.str_replace(".".$config['domain'], "", $compVal['hostname']).'</span></br>';
                  else echo '<div class="boxLabel">Hostname: </div><span class="boxText">'.$compVal['hostname'].'</span></br>';
                ?>
            </div>
            <div class="boxRow">
                <div class="boxLabel">Manufacture: </div><span class="boxText"><?=strtolower($compVal['manufac'])?></span></br>
            </div>
	</div>
	</div>
    </td>
    <?php
        if ($config['subbstitutedomain']) //check when the substitutedomain is 1 in config.json
            echo '<td>'.str_replace(".".$config['domain'], "", $compVal['hostname']).'</td>';
          else
              echo '<td>'.$compVal['hostname'].'</td>';
	if ($compVal['powerstate']) {
            echo '<td class="poweron">On</td>';
            if (($config['rooms'][$roomId]['poweroff']) || ($compVal['owner'] == $_SESSION['username']) || (inGroup('admin'))) {
                //echo '<td><button id="'.$compVal['mac'].'" class="btn btn-danger btn-xs" onclick="compStartStop(this)" data-hostname="'.$compVal['hostname'].'">Stop</button></td>';
                echo '<td><a href="#" id="'.$compVal['mac'].'" data-hostname="'.$compVal['hostname'].'" data-toggle="modal" data-target="#shutdown" class="btnStop btn btn-danger btn-xs">Stop</a></td>';
            }
            else {
                echo '<td><button class="btn btn-disabled btn-xs" disabled>Stop</button></td>';}
        
	}
        else {
            echo '<td class="poweroff">Off</td>';
            if (($config['rooms'][$roomId]['poweron']) || ($compVal['owner'] == $_SESSION['username']) || (inGroup('admin'))) {
            //echo '<td><button id="'.$compVal['mac'].'" class="btn btn-success btn-xs" onclick="compStartStop(this)">Start</button></td>';}
            echo '<td><button id="'.$compVal['mac'].'" data-hostname="'.$compVal['hostname'].'" class="btnStart btn btn-success btn-xs">Start</button></td>';}
        else {
                echo '<td><button class="btn btn-disabled btn-xs" disabled>Start</button></td>';}
    	}
}
?>
