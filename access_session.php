<?php

require_once(dirname(__FILE__).'/config.php');
// Start profiling
$start = microtime(true);
 
// Adjust session config
//ini_set('session.save_handler', 'memcached');
//ini_set('session.save_path',    '172.31.91.50:11212');
ini_set('session.save_path',$CFG->dataroot. '/sessions/');

session_start();
$hey = "THIS IS A TEST OF ACCESS SPEEDS"; //our variable
$_SESSION['hey'] = $hey; //out session variable
$hey_array = array('a'=>'random','b'=>'random','c'=>'random'); //another random array
$hey_array['hey'] = $hey;

function access_the_variable($var){
    $waste_some_time = substr($var,0,10); //this could be anything
}

//GO!
$start = microtime(true);
for($i=0;$i<100000;$i++){
    access_the_variable($hey);
}
$end  = microtime(true);
echo "\$hey took ".($end-$start)." microseconds<br />";

$start = microtime(true);
for($i=0;$i<100000;$i++){
    access_the_variable($_SESSION['hey']);
}
$end  = microtime(true);
echo "\$_SESSION['hey'] took ".($end-$start)." microseconds<br />";

$start = microtime(true);
for($i=0;$i<100000;$i++){
    access_the_variable($hey_array['hey']);
}
$end  = microtime(true);
echo "\$hey_array['hey'] took ".($end-$start)." microseconds<br /><br />";
