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
 * class-pffy-abacus.php - This class implements the Abacus object in PHP.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *        
 */
final class Abacus {
  
  // constants
  const QTY_TENTHOUSAND = 10000;
  const QTY_THOUSAND = 1000;
  const QTY_HUNDRED = 100;
  const QTY_TEN = 10;
  const QTY_ONE = 1;
  
  // maximum value
  const MAX_VALUE = 99999999;
  
  // counters
  private $_tenThousand = 0;
  private $_thousand = 0;
  private $_hundred = 0;
  private $_ten = 0;
  private $_one = 0;
  
  // input number
  private $__input = 0;

  /**
   * Builds this object with an integer.
   *
   * @param integer $int          
   */
  public function __construct($int = 0) {
    $this->setInput($int);
  }

  /**
   * Returns the string representation of this object.
   *
   * @return string $str
   */
  public function __toString() {
    $str = "";
    
    $str .= "[" . $this->_input . "|";
    $str .= $this->_tenThousand . ",";
    $str .= $this->_thousand . ",";
    $str .= $this->_hundred . ",";
    $str .= $this->_ten . ",";
    $str .= $this->_one;
    $str .= "]";
    
    return $str;
  }

  /**
   * Sets the input for this object.
   *
   * @param integer $int          
   */
  public function setInput($int = 0) {
    $this->_input = (int) min(abs($int), self::MAX_VALUE);
    $this->_countPlaces();
  }

  /**
   * Returns the array representation of this object.
   *
   * @return array $arr
   */
  public function toArray() {
    $arr = array ();
    
    $arr [0] = $this->_tenThousand;
    $arr [1] = $this->_thousand;
    $arr [2] = $this->_hundred;
    $arr [3] = $this->_ten;
    $arr [4] = $this->_one;
    
    return $arr;
  }

  /**
   * Returns the 5-bit representation of this object.
   *
   * @return string $str
   */
  public function toBitString() {
    $str = "";
    $arr = $this->toArray();
    
    foreach ($arr as $a) {
      if ($a > 0) {
        $str .= "1";
      } else {
        $str .= "0";
      }
    }
    
    return $str;
  }

  /**
   * Returns input for this object.
   *
   * @return integer $int
   */
  public function getInput() {
    return $this->_input;
  }

  /**
   * Returns number of ten-thousands counted.
   *
   * @return integer $int
   */
  public function getTenThousand() {
    return $this->_tenThousand;
  }

  /**
   * Returns number of thousands counted.
   *
   * @return integer $int
   */
  public function getThousand() {
    return $this->_thousand;
  }

  /**
   * Returns number of hundreds counted.
   *
   * @return integer $int
   */
  public function getHundred() {
    return $this->_hundred;
  }

  /**
   * Returns number of tens counted.
   *
   * @return integer $int
   */
  public function getTen() {
    return $this->_ten;
  }

  /**
   * Returns number of ones counted.
   *
   * @return integer $int
   */
  public function getOne() {
    return $this->_one;
  }
  
  // counts the place values
  private function _countPlaces() {
    
    $remaining = $this->_input;
    
    while ( $remaining >= self::QTY_TENTHOUSAND ) {
      $remaining = $remaining - self::QTY_TENTHOUSAND;
      $this->_tenThousand++;
    }
    
    while ( $remaining >= self::QTY_THOUSAND ) {
      $remaining = $remaining - self::QTY_THOUSAND;
      $this->_thousand++;
    }
    
    while ( $remaining >= self::QTY_HUNDRED ) {
      $remaining = $remaining - self::QTY_HUNDRED;
      $this->_hundred++;
    }
    
    while ( $remaining >= self::QTY_TEN ) {
      $remaining = $remaining - self::QTY_TEN;
      $this->_ten++;
    }
    
    while ( $remaining > 0 ) {
      $remaining = $remaining - self::QTY_ONE;
      $this->_one++;
    }
  }

}
