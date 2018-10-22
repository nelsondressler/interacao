<?php

class ClienteHelper
{
  
  
  public static function getIndicacoes() {

    $indicacoes = array(
      array('cod'=>'1','nome'=>'Amigo'),
      array('cod'=>'2','nome'=>'Familiar'),
      array('cod'=>'3','nome'=>'Site ou Sistema de busca'),
      array('cod'=>'4','nome'=>'Outro')
    );
    
    return $indicacoes;
    
  }
  
}
