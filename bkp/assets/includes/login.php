<?php
$cod = (integer) $_SESSION["site_cod_cliente"];

if (!$cod) {
  header ("Location: login-cadastro.php");
  exit;
}

?>