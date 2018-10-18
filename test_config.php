<?php
 $start = microtime(true);
require_once(dirname(__FILE__).'/config.php');

// Output the data

require_login();
// End profiling
$login_duration = (microtime(true) - $start);
 
// Output the data
echo "Config & login check took: ".number_format($login_duration, 12);
