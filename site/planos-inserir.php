<?php
require_once 'bootstrap.php';
require_once 'assets/includes/login.php';

if ($_POST['acao'] == 'inserir') {
  
  if ($_SESSION['insere_planos']) {
    
    $plano = new SitePlanosAction();
    $plano->incluirPlano($_POST);
    
    header('location: planos-finaliza.php');
    
  }
  
}
?>