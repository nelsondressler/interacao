<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class OpcoesHelper {
  
  
  public static function get($nome, $idioma = '') {
    
    $opcao = new OpcoesModel();
    $opcao->selectOne('valor', "nome='". $nome ."' AND idioma='". $idioma ."'");
    $row = $opcao->getResults();
    return $row['valor'];
    
  }
  
  
  public static function set($nome, $valor, $idioma = '') {
    
    if ($nome) {
      $opcao = new OpcoesModel();
      $opcao->update(array('valor'=>$valor), "nome='". $nome ."' AND idioma='". $idioma ."'");
    }
    
  }
  
  
}
