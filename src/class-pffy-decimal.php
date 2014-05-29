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

/**
 * class-pffy-decimal.php - This class implements the ChineseDecimal object.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *        
 */
final class ChineseDecimal {
  
  // (decimal) dot delimiter
  const JTZ_DIAN = "点";
  const PINYIN_DIAN = "diăn";

  // negative prefix
  const JTZ_FU = "负";
  const PINYIN_FU = "fù";  
  
  // output
  private $_chinese = "";
  private $_pinyin = "";
  
  // input
  private $_integerPart = 0;
  private $_fractionalPart = 0;

  /**
   * Builds this object with two parts: integer part (left of decimal)
   * and fractional part (right of decimal).
   *
   * @param integer $integerPart          
   * @param integer $fractionalPart             
   */
  function __construct($integerPart, $fractionalPart) {
    $this->setInput($integerPart, $fractionalPart);
    $this->_convert();
  }
  
  /**
   * Returns the string representation of this object.
   *
   * @return string $str
   *
   */
  function __toString() {
    return $this->getChinese();
  }

  /**
   * Returns the input for this object.
   *
   * @return string $str
   */
  public function getInput() {
    return $this->_input;
  }

  /**
   * Sets the the inputs for this object: integer part (left of decimal)
   * and fractional part (right of decimal).
   *
   * @param integer $integerPart          
   * @param integer $fractionalPart            
   * @return \ChineseDecimal $this
   */
  public function setInput($integerPart, $fractionalPart) {
    $this->_integerPart = (int) $integerPart;
    $this->_fractionalPart = (int) $fractionalPart;    
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
  
  // converts to percent in chinese and pinyin
  private function _convert() {
    
    $i = $this->_integerPart;
    $f = $this->_fractionalPart;
    
    $left = new ChineseInteger(abs($i));
    $right = new ChineseDigits($f);    
    
    $this->_chinese = $left->getChinese() . self::JTZ_DIAN . $right->getChinese();
    $this->_pinyin = $left->getChinese() . " " . self::PINYIN_DIAN . " " . $right->getPinyin();
    
    if ($i < 0) {
      $this->_chinese = self::JTZ_FU . $this->_chinese;
      $this->_pinyin = self::PINYIN_FU . " " . $this->_pinyin;
    }    
  }

}

