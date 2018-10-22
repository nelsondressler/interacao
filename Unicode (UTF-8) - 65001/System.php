<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class System
{
  
  public static function thisFile($extensao = true) {
    
    if ($extensao) {
      return basename($_SERVER['PHP_SELF']);
    } else {
      return str_replace('.php', '', strtolower(basename($_SERVER['PHP_SELF'])));
    }
    
  }
  
  
  public static function setCookie($name = null, $value = null, $time = null) {
    
    if (!$time) {
      $time = (time()+86400*365);
    }
    
    setcookie($name, $value, $time, '/', false, false, true);
    //$_COOKIE[$name] = $value;
    
  }
  
  
  public static function getCookie($name = null) {
    
    return $_COOKIE[$name];
    
  }
  
  
  public static function existing($data = '', $value = '') {
    
    (string) $data;
    (string) $value;
    
    if (!is_null($data)) {
      if ($value == $data) {
        return true;
      }
    } else {
      if ($default) {
        return true;
      }
    }
    
    return false;
    
  }
  
}