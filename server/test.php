#!/usr/bin/php
<?php

//echo $argv[1];
$list =  gethostbyaddr( $argv[1] );

print($list);
?>
