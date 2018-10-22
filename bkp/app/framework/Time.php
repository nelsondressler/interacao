<?php

class Time
{

  
  public static function timestampToBr($data = null) {
    
    $null = (integer) $data;
    
    if ($null) {
      return date("H:i", strtotime($data));
    } else {
      return '';
    }
    
  }

  
}