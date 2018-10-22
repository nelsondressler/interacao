<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class ClienteHelper
{
  
  
  public static function getIndicacoes() {

    $indicacoes = array(
      array('cod'=>'1','nome'=>'Amigo'),
      array('cod'=>'2','nome'=>'Familiar'),
      array('cod'=>'3','nome'=>'Site ou Sistema de busca'),	  	  array('cod'=>'4','nome'=>'Ex-Aluno'),
      array('cod'=>'5','nome'=>'Outro')
    );
    
    return $indicacoes;
    
  }
  
}
