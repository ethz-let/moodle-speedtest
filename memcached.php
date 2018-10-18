<?php
/**
 * @license ETHz
 * @copyright Amr Hourani
 */
$memcached = new Memcached();
$memcached->addServer('127.0.0.1', 11211);
$name = 'ETHtestKey';
$ttl = 10;
$data = sha1(time());
$memcached->set($name, $data, $ttl);
echo date('H:i:s') . ': key "' . $name . '" set to "' . $data . '" with ttl ' . $ttl . '<br />';
for ($i = 0; $i < ($ttl + 5); $i ++) {
  $res = $memcached->get($name);
  echo date('H:i:s') . ': key "' . $name . '" data is "' . $res . '" and that is ' . ($res == $data ? 'a match' : 'not a match') . '<br />';
  sleep(1);
}
