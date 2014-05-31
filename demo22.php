<?php

# demo21.php - ChineseTime demo #
header('Content-Type: text/html; charset=utf-8');

# pffy class autoloader
require_once 'src/pffygo.php';

# set timezone
date_default_timezone_set('America/Los_Angeles');

$dt = new DateTime("2014:06:15 05:00:00");
$di = new DateInterval("PT1M");

for($i = 0; $i < 1440; $i++) {

  # adds one minute
  $dt->add($di); 

  # shows new time, and ChineseTime string 
  echo $dt->format("Y:m:d H:i:s") . " " . (new ChineseTime($dt));
  echo nl2br(PHP_EOL);
}


?>

<!-- 
CSS for smooth, nice-looking Chinese characters
https://gist.github.com/pffy/54bd877858f009292e4a
 -->
<style>
pre
{
  font-size: 10pt;
}
body {

  font-size: 22pt;
  font-family: "WenQuanYi Micro Hei", "UKai", "STKaiTi", "KaiTi";  
}
</style>