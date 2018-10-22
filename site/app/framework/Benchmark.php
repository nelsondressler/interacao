<?php

class timer
{
  /**
   * Timestamp of first time {@link start()} was hit.
   *
   * @var integer
   * @access private
   */
  private static $begin;

  /**
   * Enables or disables dumping of the time values.
   */
  public static $dump = false;

  /**
   * Flag if file has been dumped.
   */
  private static $dumped = false; // Do not change

  /**
   * Textfile where the values should be saved in.
   */
  public static $dumpFile = 'parsetimes.txt';

  /**
   * Timestamps of stopping the count by hitting {@link stop()}.
   *
   * @var array
   * @access private
   */
  private static $end = array();

  /**
   * Comments for each {@link stop()} are saves here.
   *
   * The indexes are redundant with those in {@link $end}.
   *
   * @access private
   */
  private static $comments = array();

  /**
   * Starts or resets the stopwatch.
   *
   * @return boolean Always true
   * @access public
   */
  public static function start() {
    self::$begin = time() + microtime();
    return true;
  }

  /**
   * Stops respectivly breaks the stopwatch.
   *
   * @return boolean Always true
   * @param string $comment Comments can be written for each break
   * @access public
   */
  public static function stop($comment = '') {
    if(!self::$begin) self::start();
    $end = time() + microtime();
    $key = self::arrayInsert(self::$end, $end);
    if(strlen($comment) > 0)
      self::$comments[$key] = $comment;
    return true;
  }

  /**
   * Returns an array of all corresponding comments in ascending order.
   *
   * @return array All corresponding comments in one array.
   * @access public
   */
  public static function getComments() {
    return (array)self::$comments;
  }

  public static function getDuration($roundvalue = 4) {
    $times = self::getValues($roundvalue);
    return (float)$times[count($times) - 1];
  }

  public static function getDumpedDuration($roundvalue = 4) {
    if($handle = fopen(self::$dumpFile, 'r')) {
      $values = explode("\n", fread($handle, filesize(self::$dumpFile)));
      fclose($handle);
    }
    return (float)array_sum($values) / count($values);
  }

  /**
   * Returns an array of all stopwatch values in ascending order.
   *
   * @return array All stopwatch values in one array.
   * @param integer $roundvalue Defines how precise the rounding is realized.
   * @access public
   */
  public static function getValues($roundvalue = 4) {
    $timesarray = array();
    if(!self::$end)
      self::stop();
    foreach(self::$end as $endtime)
      $timesarray[] = (float)round($endtime - self::$begin, $roundvalue);
    if(self::$dump)
      self::dumpTime();
    return (array)$timesarray;
  }

  private static function dumpTime() {
    if(self::$dumped == false) {
      self::$dumped = true;
      if($handle = fopen(self::$dumpFile, 'a')) {
        fwrite($handle, self::getDuration() . "\n");
        fclose($handle);
      }
    }
  }

  /**
   * Returns the formated stopwatch values as string.
   *
   * @return string The formated time values.
   * @param integer $roundvalue Defines how precise the rounding is realized.
   * @access public
   */
  public static function getValuesFormatted($roundvalue = 4) {
    $values = self::getValues($roundvalue);
    $return = "Duration:\n";
    for($i = 0; $i < count($values); $i++) {
      $value = $values[$i];
      if(!isset($cache)) $cache = $value;
      $return .= $value . ' sek' . (isset(self::$comments[$i]) ? ' "' . self::$comments[$i] . '"' : '') . (($value - $cache) > 0 ? ' (+' . ($value - $cache) . ')' : '') . "\n";
      $cache = $value;
    }
    $return .= "==========================\n";
    $return .= '' . $value . ' sek';
    return (string)$return;
  }

  /**
   * Inserts a value into an array.
   *
   * This function has got the same behaviour like the native array_push();
   * function of PHP, but this function here returns the key where the value
   * was inserted.
   *
   * @return integer The key where the last value was inserted.
   * @param array &$array The concerning array.
   * @param mixed $value The value which is inserted.
   * @access protected
   */
  protected static function arrayInsert(Array &$array, $value) {
    $array[$key = count($array)] = $value;
    return (int)$key;
  }
  
}