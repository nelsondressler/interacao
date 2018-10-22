<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class MenuHelper {
  
  public static function menu($str, $pagina) {
    
    $retorno = false;
    //if ($str) {
      if(stripos($pagina, $str)!==false){
        $retorno = true;
      }
    //}
    
    return $retorno;
  }
  
}