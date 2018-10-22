<?php
/**
 * dreamCode - Neodream Framework
 *
 * @copyright Copyright(c) 2005-2010 Neodream Web solution Ltda.
 * @link http://www.neodream.com
 * @author Fernando Rotermund
 * @license Todos os direitos reservados
 * @version v 2.5
 *
 */

class Security
{
  
  /**
   * Chave para a criptografia
   * @var string key
   */
  const key = 'plokijuhnbygtfrdewsqavz';
  
  
  /**
   * Criptografa dados de uma string
   * @param string $string
   * @return string
   */
  public static function encripty($string) {
    
    $key    = sha1( self::key );
    $strLen = strlen($string);
    $keyLen = strlen($key);
    
    for ($i = 0; $i < $strLen; $i++) {
      
      $ordStr = ord(substr($string,$i,1));
      
      if ($j == $keyLen) {
        $j = 0;
      }
      
      $ordKey = ord(substr($key,$j,1));
      $j++;
      $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    
    return $hash;
    //return urlencode( strrev(base64_encode($string)) );
    
  }
  
  
  /**
   * Descriptografa dados de uma string
   * @param string $string
   * @return string
   */
  public static function decripty($string) {
    
    $key    = sha1( self::key );
    $strLen = strlen($string);
    $keyLen = strlen($key);
    
    for ($i = 0; $i < $strLen; $i+=2) {
      
      $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
      
      if ($j == $keyLen) {
        $j = 0;
      }
      
      $ordKey = ord(substr($key,$j,1));
      $j++;
      $hash .= chr($ordStr - $ordKey);
    }
    
    return $hash;
    //return base64_decode(strrev( urldecode($string) ));
    
  }
  
}
?>