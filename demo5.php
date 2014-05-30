<?php

header('Content-Type: text/html; charset=utf-8');

# pffy class autoloader
require_once 'src/pffygo.php';

$str = "8/9";

echo $c = new ChineseNumber($str);
echo nl2br(PHP_EOL);

echo $c->getPinyin();
echo nl2br(PHP_EOL);

echo $c->getChinese();
echo nl2br(PHP_EOL);

echo $c->getTypes();
echo nl2br(PHP_EOL);

echo "<pre>";
print_r($c->getResults());
echo nl2br(PHP_EOL);
echo "</pre>";

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