<?php

// pffy class autoloader
spl_autoload_register(function ($class) {
  $class = 'src/class-pffy-' . $class . '.php';
  $class = str_ireplace("chinese", "", strtolower($class));
  $class = str_ireplace("cantonese", "yue-", strtolower($class));  
  $class = str_ireplace("thai", "tha-", strtolower($class));
  require_once $class;
});