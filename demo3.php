<?php

header('Content-Type: text/html; charset=utf-8');

# pffy class autoloader
require_once 'src/pffygo.php';


// integers
// 八十八
echo $c = new ChineseNumber("88");
echo nl2br(PHP_EOL);

// fractions
// 九分之八
echo $c = new ChineseNumber("8/9");
echo nl2br(PHP_EOL);

// percent
// 百分之八十五
echo $c = new ChineseNumber("85%");
echo nl2br(PHP_EOL);

// decimal
// 八十八点五五
echo $c = new ChineseNumber("88.55");
echo nl2br(PHP_EOL);

// money
// 八块五毛五分美元
echo $c = new ChineseNumber("$8.55");
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