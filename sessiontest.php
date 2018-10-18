<?php
 
require_once(dirname(__FILE__).'/config.php');

// Start profiling
$start = microtime(true);
 
// Set header
header('Content-type: text/plain');
 
// Adjust session config
ini_set('session.save_path',$CFG->dataroot. '/sessions/');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 10);
ini_set('session.gc_maxlifetime', 3000);
 
// Init session
session_start();
 
// End profiling
$duration = (microtime(true) - $start);
 
// Output the data
echo "Session Creation Took: ".number_format($duration, 12);


$login_start = microtime(true);
require_login();

// End profiling
$login_duration = (microtime(true) - $start);
 
// Output the data
echo "<br /><br />Login Check took: ".number_format($login_duration, 12) . PHP_EOL;
