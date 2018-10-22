<?php

class Number {
  
  
  public static function formatCurrencyBr($valor) {
    
    return number_format($valor, 2, ',', '.');
    
  }
  
  
  public static function formatCurrencyUsa($valor) {
    
    $saida = "0.00";
    
    if ($valor != "") {
      $saida = str_replace(".", "", $valor);
      $saida = str_replace(",", ".", $saida);
    }
    
    return $saida;
    
  }
  
  
  public static function onlyNumbers($int) {
    
    $num   = '';
    $saida = '';
    $int   = trim($int);
    
    if ($int != "") {
      for ($i=0; $i < strlen($int); $i++) {
        if ( is_numeric(substr($int, $i,1)) ) {
          $num .= substr($int, $i,1);
        }
      }
      $saida = $num;
    }
    
    return $saida;
    
  }
  
  
  public static function zerofill($int) {
    
    $num  = '';
    $int  = trim($int);
    $zero = true;
    
    if ($int != '') {
      for ($i=0; $i < strlen($int); $i++) {
        if ($zero) {
          if ( intval(substr($int, $i,1)) > 0 ) {
            $num .= substr($int, $i,1);
            $zero = false;
          }
        } else {
          $num .= substr($int, $i,1);
        }
      }
    }
    
    return $num;
    
  }
  
}