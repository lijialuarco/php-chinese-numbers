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
 * class-pffy-money.php - This class implements the ChineseMoney object.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *        
 */
final class ChineseMoney {
  
  // (decimal) dot delimiter
  const JTZ_DIAN = "点";
  const PINYIN_DIAN = "diăn";

  // negative prefix
  const JTZ_FU = ChineseInteger::JTZ_FU;
  const PINYIN_FU = ChineseInteger::PINYIN_FU;  

  // 1 dollar
  const JTZ_KUAI = "块";
  const PINYIN_KUAI = "kuài";

  // 10 cents
  const JTZ_MAO = "毛";
  const PINYIN_MAO = "măo";

  // 1 cent
  const JTZ_FEN = "分";
  const PINYIN_FEN = "fēn";

  // US Dollars
  const JTZ_USD = "美元";
  const PINYIN_USD = "Mĕi yuán";

  // Hong Kong Dollars
  const JTZ_HKD = "港元";
  const PINYIN_HKD = "Găng yuán";

  // Chinese Yuan
  const JTZ_CNY = "元";
  const PINYIN_CNY = "Yuán";

  // pair
  const JTZ_LIANG = ChineseInteger::JTZ_LIANG;
  const PINYIN_LIANG = ChineseInteger::PINYIN_LIANG;     

  // default currency unit
  const JTZ_FX_DEFAULT = self::JTZ_USD;
  const PINYIN_FX_DEFAULT = self::PINYIN_USD;
  
  // output
  private $_chinese = "";
  private $_pinyin = "";
  
  // input
  private $_dollars = 0;
  private $_cents = 0;

  /**
   * Builds this object with two parts: integer part (left of decimal)
   * and fractional part (right of decimal).
   *
   * @param integer $dollars          
   * @param integer $cents             
   */
  function __construct($dollars, $cents) {
    $this->setInput($dollars, $cents);
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
   * @param integer $dollars          
   * @param integer $cents            
   * @return \ChineseDecimal $this
   */
  public function setInput($dollars, $cents) {
    $this->_dollars = (int) $dollars;
    $this->_cents = (int) $cents;
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
    
    // counters
    $kuai = $mao = $fen = 0;
    $dollars = $cents = 0;

    $dollars = $this->_dollars;
    $cents = $this->_cents;

    // kuai 
    $kc = $kp = $kcu = $kpu = "";

    // mao
    $mc = $mp = $mcu = $mpu = "";

    // fen
    $fc = $fp = $fcu = $fpu = "";

    // default fx unit
    $fxc = self::JTZ_FX_DEFAULT;
    $fxp = self::PINYIN_FX_DEFAULT;

    // kuai units
    $kcu = self::JTZ_KUAI;
    $kpu = self::PINYIN_KUAI;

    // kuai
    $kuai = (int) $dollars;

    switch($kuai) {
      case 0:
        $kc = $kp = "";
        $kcu = $kpu = "";
        break; 
      case 2:
        $kc = self::JTZ_LIANG;
        $kp = self::PINYIN_LIANG;
        break;
      default:
        $cn = new ChineseInteger($kuai);
        $kc = $cn->getChinese();
        $kp = $cn->getPinyin();
        $cn = null;
        break;
    }

    while ($cents >= 10) {

      $cents = $cents - 10;
      $mao++;

      // mao unit
      $mcu = self::JTZ_MAO;
      $mpu = self::PINYIN_MAO; 
    }

    switch($mao) { 
      case 0:
        $mc = $mp = "";
        $mcu = $mpu = "";
        break;  
      case 2:
        $mc = self::JTZ_LIANG;
        $mp = self::PINYIN_LIANG;
        break;
      default:
        $cn = new ChineseInteger($mao);
        $mc = $cn->getChinese();
        $mp = $cn->getPinyin();
        $cn = null;
        break;
    }

    // pennies less than 10
    $fen = (int)$cents;

    switch($fen) {
      case 0:
        $fc = $fp = "";
        $fcu = $fpu = "";      
        break;
      case 2:
        $fc = self::JTZ_LIANG;
        $fp = self::PINYIN_LIANG;

        // fen units
        $fcu = self::JTZ_FEN;
        $fpu = self::PINYIN_FEN;

        break;
      default:

        // fen units
        $fcu = self::JTZ_FEN;
        $fpu = self::PINYIN_FEN;

        $cn = new ChineseInteger($fen);
        $fc = $cn->getChinese();
        $fp = $cn->getPinyin();
        $cn = null;
        break;
    }

    // = kuai, kuai unit, mao, mao unit, fen, fen unit, fx unit
    // = kc, kcu, mc, mcu, fc, fcu, fxc
    // = kp, kpu, mp, mpu, fp, fpu, fxp
    
    $this->_chinese = $kc . $kcu . $mc . $mcu . $fc . $fcu . $fxc;
    $this->_pinyin = $kp . " " . $kpu . " " . $mp . " " . $mpu . " " . $fp . " " . $fpu . " " . $fxp;
  }
}



