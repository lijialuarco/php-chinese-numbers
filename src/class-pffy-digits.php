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

/**
 * class-pffy-digits.php - This class implements the ChineseDigits object in PHP.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *
 */
final class ChineseDigits {
  
  // Maximum input value
  const MAX_VALUE = 99999999;
  
  // Digits 0 to 9 in Simplified Chinese
  const JTZ_0 = "零";
  const JTZ_1 = "一";
  const JTZ_2 = "二";
  const JTZ_3 = "三";
  const JTZ_4 = "四";
  const JTZ_5 = "五";
  const JTZ_6 = "六";
  const JTZ_7 = "七";
  const JTZ_8 = "八";
  const JTZ_9 = "九";
  
  // Hanyu Pinyin from 0 to 9
  const PINYIN_0 = "líng";
  const PINYIN_1 = "yī";
  const PINYIN_2 = "èr";
  const PINYIN_3 = "sān";
  const PINYIN_4 = "sì";
  const PINYIN_5 = "wǔ";
  const PINYIN_6 = "liù";
  const PINYIN_7 = "qī";
  const PINYIN_8 = "bā";
  const PINYIN_9 = "jiǔ";
  
  // output
  private $_chinese = self::JTZ_0;
  private $_pinyin = self::PINYIN_0;
  
  // input
  private $_input = 0;

  /**
   * Builds this object with integer input.
   * @param integer $int
   */
  function __construct($int = 0) {
    $this->setInput($int);
    $this->_convert();
  }

  /**
   * Returns the string representation of this object.
   * @return string $str
   */
  function __toString() {
    return $this->getChinese();
  }

  /**
   * Returns the input.
   * @return integer $int;
   */
  public function getInput() {
    return $this->_input;
  }
  
  /**
   * Sets the input digits.
   * @param unknown $int
   * @return \ChineseDigits $this;
   */
  public function setInput($int) {
    $int = (int) $int;
    $this->_input = $int;
    return $this;
  }  

  /**
   * Returns the Hanyu Pinyin representation of this object.
   *
   * @return string $str
   */
  public function getPinyin() {
    return $this->_pinyin;
  }

  /**
   * Returns the Chinese character representation of this object.
   *
   * @return string $str
   */
  public function getChinese() {
    return $this->_chinese;
  }
  
  // converts to digits
  private function _convert() {

    $d = $this->_input;
        
    $outputChinese = (string) $d;
    $outputPinyin = (string) $d;
    
    // pinyin
    $outputPinyin = $this->_toPinyin($outputChinese);
    $this->_pinyin = $this->_vacuum($outputPinyin);
    
    // chinese
    $outputChinese = $this->_toHanzi($outputChinese);
    $this->_chinese = $this->_airtight($outputChinese);
  }
  
  // converts to Hanzi
  private function _toHanzi($str) {
    $str = str_replace("0", self::JTZ_0, $str);
    $str = str_replace("1", self::JTZ_1, $str);
    $str = str_replace("2", self::JTZ_2, $str);
    $str = str_replace("3", self::JTZ_3, $str);
    $str = str_replace("4", self::JTZ_4, $str);
    $str = str_replace("5", self::JTZ_5, $str);
    $str = str_replace("6", self::JTZ_6, $str);
    $str = str_replace("7", self::JTZ_7, $str);
    $str = str_replace("8", self::JTZ_8, $str);
    $str = str_replace("9", self::JTZ_9, $str);
  
    return $str;
  }
  
  // converts to pinyin
  private function _toPinyin($str) {
    $str = str_replace("0", " " . self::PINYIN_0, $str);
    $str = str_replace("1", " " . self::PINYIN_1, $str);
    $str = str_replace("2", " " . self::PINYIN_2, $str);
    $str = str_replace("3", " " . self::PINYIN_3, $str);
    $str = str_replace("4", " " . self::PINYIN_4, $str);
    $str = str_replace("5", " " . self::PINYIN_5, $str);
    $str = str_replace("6", " " . self::PINYIN_6, $str);
    $str = str_replace("7", " " . self::PINYIN_7, $str);
    $str = str_replace("8", " " . self::PINYIN_8, $str);
    $str = str_replace("9", " " . self::PINYIN_9, $str);
  
    return $str;
  }
  
  // reduces spaces to exactly one space
  private function _vacuum($str) {
    return trim(preg_replace("/(\s{2,})/u", " ", $str));
  }
  
  // removes all spaces
  private function _airtight($str) {
    return trim(preg_replace("/(\s{1,})/u", "", $str));
  }
  
}
