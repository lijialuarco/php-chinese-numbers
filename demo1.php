<?php
header('Content-Type: text/html; charset=utf-8');

# pffy class autoloader
require_once 'src/pffygo.php';

# [88|0,0,0,8,8]
echo (new Abacus(-88));
echo nl2br(PHP_EOL);

# 零
echo (new ChineseInteger());
echo nl2br(PHP_EOL);

# 八八八
echo (new ChineseDigits(888));
echo nl2br(PHP_EOL);

# 八百八十八
echo (new ChineseInteger(888));
echo nl2br(PHP_EOL);

# 负八十八万八千八百八十八
echo (new ChineseInteger(-888888));
echo nl2br(PHP_EOL);

# 八分之三
echo (new ChineseFraction(3, 8)); 
echo nl2br(PHP_EOL);

# 负八分之五
echo (new ChineseFraction(-5, 8)); 
echo nl2br(PHP_EOL);

# 负百分之八十八
echo (new ChinesePercent(-88)); 
echo nl2br(PHP_EOL);

# 负八百五十八点八八五五八八
echo (new ChineseDecimal(-858, 885588));
echo nl2br(PHP_EOL);
?>

<!-- 
CSS for smooth, nice-looking Chinese characters
https://gist.github.com/pffy/54bd877858f009292e4a
 -->
<style>
body {
  text-align: center;
  font-size: 50pt;
  font-family: "WenQuanYi Micro Hei", "UKai", "STKaiTi", "KaiTi";  
}
</style>