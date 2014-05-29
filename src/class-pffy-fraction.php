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
 * class-pffy-fraction.php - This class implements the ChineseFraction object.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *        
 */
final class ChineseFraction {
  
  // fraction delimiter
  const JTZ_FENZHI = "分之";
  const PINYIN_FENZHI = "fēn zhī";
  
  // negative prefix
  const JTZ_FU = "负";
  const PINYIN_FU = "fù";
  
  // output
  private $_chinese = "";
  private $_pinyin = "";
  
  // input
  private $_numerator = 0;
  private $_denominator = 0;

  /**
   * Builds this object with a numerator and denominator.
   *
   * @param integer $numerator          
   * @param integer $denominator          
   */
  function __construct($numerator = 0, $denominator = 1) {
    $this->setInput($numerator, $denominator);
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
   * Sets the input for this object.
   *
   * @param integer $numerator          
   * @param integer $denominator          
   * @return \ChineseFraction $this
   */
  public function setInput($numerator, $denominator) {
    $this->_numerator = (int) $numerator;
    $this->_denominator = (int) $denominator;
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
    
  // converts to fraction in Chinese and pinyin
  private function _convert() {
    
    $n = $this->_numerator;
    $d = $this->_denominator;
    
    try {
      if ($d === 0) {
        throw new Exception("PFFY SAYS :: Cannot divide by zero. Setting denominator to 1.");
      }
    } catch (Exception $ex) {
      echo $ex->getMessage();
      $d = 1;
    }
    
    $top = new ChineseInteger($n);
    $btm = new ChineseInteger($d);
    
    $this->_chinese = $btm->getChinese() . self::JTZ_FENZHI . $top->getChinese();
    $this->_pinyin = $btm->getPinyin() . " " . self::PINYIN_FENZHI . " " .
       $top->getPinyin();
    
    if ($n < 0) {
      $this->_chinese = self::JTZ_FU . $this->_chinese;
      $this->_pinyin = self::PINYIN_FU . " " . $this->_pinyin;
    }
  }

}

