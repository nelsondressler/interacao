<?php
require_once 'bootstrap.php';

$plano = new SitePlanosAction();
$plano->setAvisoPagseguro($_REQUEST);
?>