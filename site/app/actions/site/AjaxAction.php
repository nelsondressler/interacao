<?php
if ($_REQUEST['acao'] == 'site_login') {
  
  $cliente = new SiteClientesAction();
  $cliente->login($_REQUEST['email'], $_REQUEST['senha']);
  
  if ($cliente->getReturnMensage()) {
    echo $cliente->getReturnMensage();
  }
  
  
} else if ($_REQUEST['acao'] == 'lembra_senha') {
  
  $cliente = new SiteClientesAction();
  $cliente->lembraSenha($_REQUEST['email']);
  echo $cliente->getReturnMensage();
    
  
} else if ($_REQUEST['acao'] == 'verifica_email') {
  
  $cliente = new SiteClientesAction();
  
  if ($cliente->verificaEmail($_REQUEST['email'])) {
    echo 'Este e-mail já esta cadastrado!';
  }
  
  
  
} else if ($_REQUEST['acao'] == 'logoff') {
  
  $_SESSION["site_cod_cliente"] = null;
  
  
  
} else if ($_REQUEST['acao'] == 'calcula_desconto') {
  
  $json    = new Json();
  $planos  = $_REQUEST['cod_plano'];
  $valores = array();
  
  for ($i = 0; $i < count($planos); $i++) {
    $valores[$i]['valor']         = $_REQUEST['valor'. $planos[$i]];
    $valores[$i]['valor_desconto']= 0;
    $valores[$i]['desconto']      = 0;
    $valores[$i]['cod_plano']     = $planos[$i];
  }
  
  sort($valores);
  $totalv = count($valores);
  
  if ($totalv == 2) {
    $valores[0]['desconto']       = 10;
    $valores[0]['valor_desconto'] = $valores[0]['valor'] - ($valores[0]['valor'] * ($valores[0]['desconto']/100));
    
  } else if ($totalv == 3) {
    $valores[0]['desconto']       = 20;
    $valores[0]['valor_desconto'] = $valores[0]['valor'] - ($valores[0]['valor'] * ($valores[0]['desconto']/100));
  }
  
  echo $json->encode($valores);
  
  
}
?>