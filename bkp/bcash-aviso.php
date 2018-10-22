<?php
require_once 'bootstrap.php';

$plano = new SitePlanosAction();
$plano->setAvisoBcash($_REQUEST);
?>