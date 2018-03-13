<?php
function userInGroup($user, $group) {
    global $config;
    if(isset($group) && isset($user)) {
            if(in_array($user, $config['groups'][$group])) {
                return true;
            }
            else
            {
                return false;
            }
        }
}

?>
