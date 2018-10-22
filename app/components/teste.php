<?php
require_once '../../bootstrap.php';
$plano = new SitePlanosAction();
$plano->corrigePlanos($_REQUEST['url']."&token=".$_REQUEST['token']);
?>