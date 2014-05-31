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
 * class-pffy-date.php - This class implements the ChineseDate object.
 *
 * @license http://unlicense.org/ The Unlicense
 * @version 8.1
 * @link https://github.com/pffy
 * @author The Pffy Authors
 *
 */
final class ChineseDate {

  const DATE_FORMAT_EXIF = "Y:m:d H:i:s";

  // year
  const JTZ_NIAN = "年";
  const PINYIN_NIAN = "nián";

  // month
  const JTZ_YUE = "月";
  const PINYIN_YUE = "yuè";

  // day
  const JTZ_RI = "日";
  const PINYIN_RI = "rì";

  // output
  private $_chinese = "";
  private $_pinyin = "";


  private $_y = 0;
  private $_m = 0;
  private $_d = 0;

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
   * @return \ChineseDate
   */
  public function setInput(DateTime $date) {

    $this->_input = $date->format(self::DATE_FORMAT_EXIF);

    $this->_y = (int) $date->format('Y');
    $this->_m = (int) $date->format('m');
    $this->_d = (int) $date->format('d');

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

    $year = new ChineseDigits($this->_y);
    $month = new ChineseInteger($this->_m);
    $day = new ChineseInteger($this->_d);

    $this->_chinese = $year->getChinese() . self::JTZ_NIAN
      . $month->getChinese() . self::JTZ_YUE
      . $day->getChinese() . self::JTZ_RI;

    $this->_pinyin = $year->getPinyin() . " " . self::PINYIN_NIAN . " "
      . $month->getPinyin() . " " . self::PINYIN_YUE . " "
      . $day->getPinyin() . " " . self::PINYIN_RI;

  }

}

