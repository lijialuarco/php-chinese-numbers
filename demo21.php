<?php

# demo21.php - ChineseDate demo #
header('Content-Type: text/html; charset=utf-8');

# pffy class autoloader
require_once 'src/pffygo.php';

# set timezone
date_default_timezone_set('America/Los_Angeles');

echo $d = new ChineseDate(new DateTime("2014:12:05 05:05:05"));
echo nl2br(PHP_EOL);

echo $d->getPinyin();
echo nl2br(PHP_EOL);

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

  font-size: 50pt;
  font-family: "WenQuanYi Micro Hei", "UKai", "STKaiTi", "KaiTi";  
}
</style>