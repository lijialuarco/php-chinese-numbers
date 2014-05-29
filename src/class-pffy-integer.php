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

require_once 'class-pffy-abacus.php';
require_once 'class-pffy-digits.php';

/**
 * class-pffy-integer.php - This class implements the ChineseInteger object in
 * PHP.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *        
 */
final class ChineseInteger {
  
  // maximum input value
  const MAX_VALUE = 99999999;
  
  // measure words
  
  // (simplified) chinese
  const JTZ_WAN = "万";
  const JTZ_QIAN = "千";
  const JTZ_BAI = "百";
  const JTZ_SHI = "十";
  const JTZ_FU = "负";
  const JTZ_LIANG = "两";
  
  // pinyin
  const PINYIN_WAN = "wàn";
  const PINYIN_QIAN = "qiān";
  const PINYIN_BAI = "bǎi";
  const PINYIN_SHI = "shí";
  const PINYIN_FU = "fù";
  const PINYIN_LIANG = "liǎng";
  
  // digits
  
  // chinese
  const JTZ_0 = ChineseDigits::JTZ_0;
  const JTZ_1 = ChineseDigits::JTZ_1;
  const JTZ_2 = ChineseDigits::JTZ_2;
  const JTZ_3 = ChineseDigits::JTZ_3;
  const JTZ_4 = ChineseDigits::JTZ_4;
  const JTZ_5 = ChineseDigits::JTZ_5;
  const JTZ_6 = ChineseDigits::JTZ_6;
  const JTZ_7 = ChineseDigits::JTZ_7;
  const JTZ_8 = ChineseDigits::JTZ_8;
  const JTZ_9 = ChineseDigits::JTZ_9;
  
  // pinyin
  const PINYIN_0 = ChineseDigits::PINYIN_0;
  const PINYIN_1 = ChineseDigits::PINYIN_1;
  const PINYIN_2 = ChineseDigits::PINYIN_2;
  const PINYIN_3 = ChineseDigits::PINYIN_3;
  const PINYIN_4 = ChineseDigits::PINYIN_4;
  const PINYIN_5 = ChineseDigits::PINYIN_5;
  const PINYIN_6 = ChineseDigits::PINYIN_6;
  const PINYIN_7 = ChineseDigits::PINYIN_7;
  const PINYIN_8 = ChineseDigits::PINYIN_8;
  const PINYIN_9 = ChineseDigits::PINYIN_9;
  
  // output
  private $_chinese = self::JTZ_0;
  private $_pinyin = self::PINYIN_0;
  
  // the Abacus object
  private $_abba = null;
  
  // input
  private $_input = 0;

  /**
   * Builds this object with an integer.
   *
   * @param integer $int          
   */
  function __construct($int = 0) {
    $this->setInput($int);
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
   * Returns input for this object.
   *
   * @return string $str
   */
  public function getInput() {
    return $this->_input;
  }

  /**
   * Sets input for this object.
   *
   * @param integer $int          
   * @return \ChineseInteger $obj
   */
  public function setInput($int) {
    $int = (int) $int;
    $this->_input = $int;
    return $this;
  }

  /**
   * Returns this object represented as a Hanyu Pinyin string
   *
   * @return string $str
   */
  public function getPinyin() {
    return $this->_pinyin;
  }

  /**
   * Returns this object representd as a Chinese character string
   *
   * @return string $str
   */
  public function getChinese() {
    return $this->_chinese;
  }
  
  // converts number to chinese and pinyin
  private function _convert() {
    
    $outputChinese = "";
    $outputPinyin = "";
    
    // counters
    $wan = 0;
    $qian = 0;
    $bai = 0;
    $shi = 0;
    $num = 0;
    
    // value strings
    $strWan = "";
    $strQian = "";
    $strBai = "";
    $strShi = "";
    $strNum = "";
    
    // unit strings
    $unitWan = "";
    $unitQian = "";
    $unitBai = "";
    $unitShi = "";
    // there is no unit String for numeral
    
    $numberIsNegative = false;
    
    // gets the absolute value of that input number
    $inputNumber = $this->_input;
    $absNumber = abs($inputNumber);
    
    // checks if the input number is negative, flags if true
    if ($inputNumber < 0) {
      $numberIsNegative = true;
      $inputNumber = $absNumber;
    }
    
    // three conversion cases
    switch ($absNumber) {
      case 0 :
        $outputChinese = self::JTZ_0;
        $outputPinyin = self::PINYIN_0;
        break;
      
      case 250 :
        $outputChinese = self::JTZ_LIANG . self::JTZ_BAI . self::JTZ_5;
        $outputPinyin = self::PINYIN_LIANG . " " . self::PINYIN_BAI . " " .
           self::PINYIN_5;
        break;
      
      default :
        
        $abba = new Abacus($inputNumber);
        
        $wan = $abba->getTenThousand();
        $qian = $abba->getThousand();
        $bai = $abba->getHundred();
        $shi = $abba->getTen();
        $num = $abba->getOne();
        
        if ($wan > 0) {
          $cwan = new ChineseInteger($wan);
          $strWan = $cwan->getChinese();
          $unitWan = " " . self::JTZ_WAN;
        }
        
        if ($qian > 0) {
          $strQian = $qian;
          $unitQian = " " . self::JTZ_QIAN;
        }
        
        if ($bai > 0) {
          $strBai = $bai;
          $unitBai = " " . self::JTZ_BAI;
        }
        
        if ($shi > 0) {
          $strShi = $shi;
          $unitShi = " " . self::JTZ_SHI;
        }
        
        if ($num > 0) {
          $strNum = $num;
          // no units for NUM
        }
        
        switch ($abba->toBitString()) {
          
          // case #32
          case "11111" :
            // no action required
            break;
          
          // case #31
          case "11110" :
            $strNum = "";
            $unitShi = "";
            break;
          
          // case #30
          case "11101" :
            $strShi = "";
            $unitShi = self::JTZ_0;
            break;
          
          // case #29
          case "11100" :
            $strShi = "";
            $strNum = "";
            $unitShi = "";
            break;
          
          // case #28
          // case #27
          case "11011" :
          case "11010" :
            $strBai = "";
            $unitBai = self::JTZ_0;
            break;
          
          // case #26
          case "11001" :
            $strBai = "";
            $strShi = "";
            $unitBai = self::JTZ_0;
            $unitShi = "";
            break;
          
          // case #25
          case "11000" :
            $strBai = "";
            $strShi = "";
            $strNum = "";
            $unitBai = "";
            $unitShi = "";
            break;
          
          // case #24
          case "10111" :
            $strQian = "";
            $unitQian = self::JTZ_0;
            break;
          
          // case #23
          case "10110" :
            $strQian = "";
            $strNum = "";
            $unitQian = self::JTZ_0;
            $unitShi = "";
            break;
          
          // case #22
          case "10101" :
            $strQian = "";
            $strShi = "";
            $unitQian = self::JTZ_0;
            $unitShi = self::JTZ_0;
            break;
          
          // case #21
          case "10100" :
            $strQian = "";
            $strShi = "";
            $strNum = "";
            $unitQian = self::JTZ_0;
            $unitShi = "";
            break;
          
          // case #20
          // case #19
          case "10011" :
          case "10010" :
            $strQian = "";
            $strBai = "";
            $unitQian = self::JTZ_0;
            $unitBai = "";
            break;
          
          // case #17
          case "10000" :
            $strQian = "";
            $strBai = "";
            $strShi = "";
            $strNum = "";
            $unitQian = "";
            $unitBai = "";
            $unitShi = "";
            break;
          
          // case #16
          case "01111" :
            // no action required
            break;
          
          // case #15
          case "1110" :
            $strNum = "";
            $unitShi = "";
            break;
          
          // case #14
          case "01101" :
            $strShi = "";
            $unitShi = self::JTZ_0;
            break;
          
          // case #13
          case "01100" :
            $strShi = "";
            $strNum = "";
            $unitBai = "";
            $unitShi = "";
            break;
          
          // case #12
          case "01011" :
            $strBai = "";
            $unitBai = self::JTZ_0;
            break;
          
          // case #11
          case "01010" :
            $strBai = "";
            $strNum = "";
            $unitBai = self::JTZ_0;
            break;
          
          // double donuts - 1001, 3006, ...
          // case #10
          case "01001" :
            $strBai = "";
            $strShi = "";
            $unitBai = self::JTZ_0;
            $unitShi = "";
            break;
          
          // triple donuts - 1000, 2000, ...
          // case #9
          case "01000" :
            $strBai = "";
            $strShi = "";
            $strNum = "";
            $unitBai = "";
            $unitShi = "";
            break;
          
          // case #8
          case "00111" :
            // no action required
            break;
          
          // 120, 130, ...
          // case #7
          case "00110" :
            $strNum = "";
            $unitShi = "";
            break;
          
          // single donuts - 101, 203, ...
          // case #6
          case "00101" :
            $strShi = "";
            $unitShi = self::JTZ_0;
            break;
          
          // case #5
          case "00100" :
            $strShi = "";
            $strNum = "";
            $unitShi = "";
            break;
          
          default :
            // do nothing
            break;
        } // SWITCH-bitstring
          
        // if input number is less than 20
          // case #4
          // case #3
        if ($absNumber < 20) {
          $strShi = "";
        }
        
        // concatenate complete conversion
        $outputChinese = $strWan . $unitWan . $strQian . $unitQian . $strBai .
           $unitBai . $strShi . $unitShi . $strNum;
        
        // finish PINYIN
        $outputPinyin = $this->_toPinyin($outputChinese);
        $outputPinyin = $this->_vacuum($outputPinyin);
        
        // finish CHINESE
        $outputChinese = $this->_toHanzi($outputChinese);
        $outputChinese = $this->_airtight($outputChinese);
        
        break;
    }
    
    // prepend negative number
    if ($numberIsNegative) {
      $outputChinese = self::JTZ_FU . $outputChinese;
      $outputPinyin = self::PINYIN_FU . " " . $outputPinyin;
    }
    
    // conversion done
    $this->_chinese = trim($outputChinese);
    $this->_pinyin = trim($outputPinyin);
  }
  
  // converts to Chinese
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
  
    $str = str_replace(self::JTZ_0, " " . self::PINYIN_0, $str);
    $str = str_replace(self::JTZ_1, " " . self::PINYIN_1, $str);
    $str = str_replace(self::JTZ_2, " " . self::PINYIN_2, $str);
    $str = str_replace(self::JTZ_3, " " . self::PINYIN_3, $str);
    $str = str_replace(self::JTZ_4, " " . self::PINYIN_4, $str);
    $str = str_replace(self::JTZ_5, " " . self::PINYIN_5, $str);
    $str = str_replace(self::JTZ_6, " " . self::PINYIN_6, $str);
    $str = str_replace(self::JTZ_7, " " . self::PINYIN_7, $str);
    $str = str_replace(self::JTZ_8, " " . self::PINYIN_8, $str);
    $str = str_replace(self::JTZ_9, " " . self::PINYIN_9, $str);
  
    $str = str_replace(self::JTZ_WAN, " " . self::PINYIN_WAN, $str);
    $str = str_replace(self::JTZ_QIAN, " " . self::PINYIN_QIAN, $str);
    $str = str_replace(self::JTZ_BAI, " " . self::PINYIN_BAI, $str);
    $str = str_replace(self::JTZ_SHI, " " . self::PINYIN_SHI, $str);
  
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

