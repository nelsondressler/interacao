<?php
require_once '../../../app/configs/configs.php';

function __autoload($classe) {
  
  $caminho = array('actions/adm', 'models', 'framework', 'components', 'helpers');
  
  foreach($caminho as $pasta) {
    $arquivo = SYS_PATH .'app/'. $pasta .'/'. $classe .'.php';
    if ( file_exists($arquivo) ) {
      include_once $arquivo;
    }
  }
  
}

require_once SYS_PATH .'app/actions/adm/AjaxAction.php';
?>