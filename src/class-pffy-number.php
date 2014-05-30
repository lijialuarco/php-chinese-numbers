<?php

/**
 * This is free and unencumbered software released into the public domain.
 *
 * Anyone is free to copy, modify, publish, use, compile, sell, or
 * distribute this software, either in source code form or as a compiled
 * binary, for any purpose, commercial or non-commercial, and by any
 * means.
 *
 * In jurisdictions that recognize copyright laws, the author or authors
 * of this software dedicate any and all copyright interest in the
 * software to the public domain. We make this dedication for the benefit
 * of the public at large and to the detriment of our heirs and
 * successors. We intend this dedication to be an overt act of
 * relinquishment in perpetuity of all present and future rights to this
 * software under copyright law.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * For more information, please refer to <http://unlicense.org/>
 */

require_once 'class-pffy-integer.php';
require_once 'class-pffy-fraction.php';
require_once 'class-pffy-percent.php';
require_once 'class-pffy-decimal.php';
require_once 'class-pffy-money.php';


/**
 * class-pffy-number.php - This wrapper class implements ChineseNumber object.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 0.0
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *
 */
final class ChineseNumber {


  // outputs
  private $_chinese = "";
  private $_pinyin = "";

  private $_results = array();

  private $_regex = array();
  private $_types = array(); // regex types returned

  // flags
  private $_translated = false;

  // inputs
  private $_input;

  function __construct($str = "") {

    $this->_init();

    if(trim($str)) {
      $this->_input = (string)$str;
      $this->_translate();
    }
  }

  public function __toString() {
    return $this->getChinese();
  }

  public function getInput() {
    return $this->_input;
  }

  // there is no setter method.

  public function getChinese() {
    return $this->_chinese;
  }

  public function getPinyin() {
    return $this->_pinyin;
  }

  public function getResults() {
    return $this->_results;
  }

  public function getTypes() {
    return implode(",", array_keys($this->_results));
  }

  public function hasTranslation(){
    return $this->_translated;
  }

  private function _translate() {

    $this->_detex();

    foreach($this->_results as $key => $values)
    {

      switch($key)
      {
        case "regex_integer":
          $c = new ChineseInteger($values['param1']);
          $this->_chinese = $c->getChinese();
          $this->_pinyin = $c->getPinyin();

          return $this->_translated = true;
        break;

        case "regex_fraction":

          if(!$values['param2'])
            return false;

          $c = new ChineseFraction($values['param1'], $values['param2']);
          $this->_chinese = $c->getChinese();
          $this->_pinyin = $c->getPinyin();

          return $this->_translated = true;
        break;

        case "regex_decimal":

          $c = new ChineseDecimal($values['param1'], $values['param2']);
          $this->_chinese = $c->getChinese();
          $this->_pinyin = $c->getPinyin();

          return $this->_translated = true;
        break;

        case "regex_percent":

          $c = new ChinesePercent($values['param1']);
          $this->_chinese = $c->getChinese();
          $this->_pinyin = $c->getPinyin();

          return $this->_translated = true;
        break;

        case "regex_money":

          if(isset($values['param2'])) {
            $c = new ChineseMoney($values['param1'], $values['param2']);
          } else {
            $c = new ChineseMoney($values['param1'], 0);            
          }  

          $this->_chinese = $c->getChinese();
          $this->_pinyin = $c->getPinyin();

          return $this->_translated = true;
        break;

        default:
        break;
      }
    }

  } # convert

  private function _init() {

    $pattern_integer = "([0-9]{1,8})";
    $pattern_cents = "([0-9]{2})";
    $pattern_thousand = "([0-9]{1,3})";

    $this->_regex['regex_integer'] = "^[-]?" . $pattern_integer . "$";    
    $this->_regex['regex_fraction'] = "^[-]?" . $pattern_integer . "\/" . $pattern_integer . "$";
    $this->_regex['regex_percent'] = "^[-]?"  . $pattern_thousand . "%";
    $this->_regex['regex_decimal'] = "^[-]?" . $pattern_integer . "\." . $pattern_integer . "$";
    $this->_regex['regex_money'] = "^[$]+" . $pattern_integer . "(\.$pattern_cents)?$";
  }

  private function _detex() {

    $q = $this->_input;
    $q = strtolower($q);

    foreach($this->_regex as $regex_key => $regex_value) {

      $pattern = '/' . $regex_value . '/u';
      preg_match($pattern, $q, $matches);

      if($matches) {
        $this->_results[$regex_key]['input'] = $matches[0];

        if(isset($matches[1])) {
          $this->_results[$regex_key]['param1'] = $matches[1];                      
        }

        if(isset($matches[2])) {
          $this->_results[$regex_key]['param2'] = $matches[2];                      
        }      

        if(isset($matches[3])) {
          // overwrite param2
          $this->_results[$regex_key]['param2'] = $matches[3];                      
        }              
      }
    }
  } 

}

