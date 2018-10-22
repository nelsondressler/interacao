<?php
require_once 'app/configs/configs.php';

$_SESSION["site_idioma"] = 'br';

function __autoload($classe) {
  
  $caminho = array('actions/site', 'models', 'framework', 'components', 'helpers');
  
  foreach($caminho as $pasta) {
    $arquivo = SYS_PATH .'app/'. $pasta .'/'. $classe .'.php';
    if ( file_exists($arquivo) ) {
      include_once $arquivo;
    }
  }
  
}
?>