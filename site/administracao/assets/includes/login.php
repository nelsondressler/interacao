<?php

if (System::thisFile() != 'index.php') {
  
  if ($_SESSION["login_cod"] == '' || $_SESSION["login_idioma"] == '') {
    header ("Location: index.php");
    exit;
  }
  
} else {
  
  $cod = (integer) $_SESSION["login_cod"];
  
  if ($cod) {
    header ("Location: home.php");
    exit;
  }
  
}

?>