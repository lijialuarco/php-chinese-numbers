<?php
header('Content-Type: text/html; charset=utf-8');

# pffy class autoloader
require_once 'src/pffygo.php';

# 八十八块五毛五分美元
echo (new ChineseMoney(88, 55));
echo nl2br(PHP_EOL);

# 五块美元
echo (new ChineseMoney(5, 0));
echo nl2br(PHP_EOL);

# 两块两分美元
echo (new ChineseMoney(2, 2));
echo nl2br(PHP_EOL);

# 两块两毛两分美元
echo (new ChineseMoney(2, 22));
echo nl2br(PHP_EOL);

# 八块两毛五分美元
echo (new ChineseMoney(8, 25));
echo nl2br(PHP_EOL);

# 一百八十五块六毛五分美元
echo (new ChineseMoney(185, 65));
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