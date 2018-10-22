<?php
class IdiomasHelper
{
  
  public static function getLista() {
    
    $values = array (
      //array('nome'=>'Português', 'sigla'=>'br', 'imagem'=>'br.gif'),
      //array('nome'=>'Inglês',    'sigla'=>'us', 'imagem'=>'us.gif')
      //array('nome'=>'Espanhol',  'sigla'=>'es', 'imagem'=>'es.gif')
    );
    
    return $values;
    
  }
  
  
  public static function setIdioma($idioma) {
    
    $idioma_lista = IdiomasHelper::getLista();
    $idioma_count = count($idioma_lista);
    
    // Só altera o idioma se ele existir
    for ($i = 0; $i < $idioma_count; $i++) {
      if ($idioma_lista[$i]['sigla'] == $idioma) {
        $_SESSION["login_idioma"] = $idioma;
      }
    }
    
  }
  
  
}