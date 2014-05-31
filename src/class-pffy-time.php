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
 * class-pffy-date.php - This class implements the ChineseTime object.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *
 */
final class ChineseTime {

  const DATE_FORMAT_EXIF = "Y:m:d H:i:s";

  const JTZ_LIANG = ChineseInteger::JTZ_LIANG;
  const PINYIN_LIANG = ChineseInteger::PINYIN_LIANG;

  const JTZ_0 = ChineseInteger::JTZ_0;
  const PINYIN_0 = ChineseInteger::PINYIN_0;

  const JTZ_DIAN = "点";
  const PINYIN_DIAN = "diǎn";

  const JTZ_FEN = "分";
  const PINYIN_FEN = "fēn";

  const JTZ_ZHONG = "种";
  const PINYIN_ZHONG = "zhōng";

  const JTZ_SHANGWU = "上午";
  const PINYIN_SHANGWU = "shàng wŭ";

  const JTZ_XIAWU = "下午";
  const PINYIN_XIAWU = "xìa wǔ";

  // output
  private $_chinese = "";
  private $_pinyin = "";

  private $_h = "0";
  private $_m = "0";

  // input in EXIF date format
  private $input = "";

  /**
   * Builds this object with a DateTime object.
   *
   * @param DateTime $date
   */
  function __construct(DateTime $date) {
    $this->setInput($date);
  }

  /**
   * Returns the string representation of this object.
   *
   * @return string
   */
  function __toString() {
    return $this->getChinese();
  }

  /**
   * Returns the input for this object.
   *
   * @return string
   */
  public function getInput() {
    return $this->_input;
  }

  /**
   * Sets the input for this object.
   *
   * @param DateTime $date
   * @return \ChineseTime
   */
  public function setInput(DateTime $date) {

    $this->_input = $date->format(self::DATE_FORMAT_EXIF);

    $this->_h = (int) $date->format('H');
    $this->_m = (int) $date->format('i');

    $this->_convert();
    return $this;
  }

  /**
   * Returns the Hanyu Pinyin representation of this object.
   *
   * @return string
   */
  public function getPinyin() {
    return $this->_pinyin;
  }

  /**
   * Returns the Chinese character representation of this object.
   *
   * @return string
   */
  public function getChinese() {
    return $this->_chinese;
  }

  // converts to chinese and pinyin
  private function _convert() {

    $ampmc = self::JTZ_SHANGWU;
    $ampmp = self::PINYIN_SHANGWU;

    $h = $this->_h;
    $m = $this->_m;

    if($h > 11)
    {
      $ampmc = self::JTZ_XIAWU;
      $ampmp = self::PINYIN_XIAWU;
      $h = $h - 12;
    } else if($h < 1)
    {
      $h = 12;
    }

    $hour = new ChineseInteger($h);
    $minute = new ChineseInteger($m);

    $hc = $hour->getChinese();
    $hp = $hour->getPinyin();

    $mc = $minute->getChinese();
    $mp = $minute->getPinyin();


    if($h === 2)
    {
      $hc = self::JTZ_LIANG;
      $hp = self::PINYIN_LIANG;
    }

    if($m === 2)
    {
      $mc = self::JTZ_LIANG;
      $mp = self::PINYIN_LIANG;
    }

    if($m && $m < 10)
    {
      $mc = self::JTZ_0 . $mc;
      $mp = self::PINYIN_0 . " " . $mp;
    }

    if($m === 0)
    {
      $this->_chinese = $ampmc . $hc . self::JTZ_DIAN;
      $this->_pinyin = $ampmp . " " . $hp .  " " . self::PINYIN_DIAN;    
    } else {
      $this->_chinese = $ampmc . $hc . self::JTZ_DIAN . $mc . self::JTZ_FEN;
      $this->_pinyin = $ampmp . " " . $hp .  " " . self::PINYIN_DIAN . " " . $mp . " " . self::PINYIN_FEN;          
    }


  }

}

