<?php

if ($_REQUEST['acao'] == 'lembra_senha') {
  
  $administracao = new AdministracaoUsuariosAction();
  $administracao->lembraSenha($_POST['login']);
  echo $administracao->getReturnMensage();

  
} else if ($_REQUEST['acao'] == 'login') {
  
  $administracao = new AdministracaoUsuariosAction();
  $administracao->login($_REQUEST['login'], $_REQUEST['senha'], $_REQUEST['idioma']);
  
  if (!$administracao->getReturn()) {
    echo $administracao->getReturnMensage();
  }
  
  
} else if ($_REQUEST['acao'] == 'set_status') {
   
  if ($_REQUEST['cod'] && $_REQUEST['tipo']) {
    
    $conteudo = new ConteudosAction();
    $conteudo->setTipo($_REQUEST['tipo']);
    $conteudo->setStatus($_REQUEST['cod'], $_REQUEST['flag'], $_REQUEST['cat']);
    
  }
  
  
} else if ($_REQUEST['acao'] == 'set_principal') {
   
  if ($_REQUEST['cod'] && $_REQUEST['tipo']) {
    
    $conteudo = new ConteudosAction();
    $conteudo->setTipo($_REQUEST['tipo']);
    $conteudo->setPrincipal($_REQUEST['cod'], $_REQUEST['flag'], $_REQUEST['cat']);
    
  }
  
  
} else if ($_REQUEST['acao'] == 'envia_senha') {
  
  $emailsys = new EmailSystem();
  $emailsys->enviaSenhaUsuario($_REQUEST['cod_usuario']);
  echo 'Senha enviada';
  
  
} else if ($_REQUEST['acao'] == 'envia_cobranca_unica') {
  
  $parcela = new ParcelasAction();
  $cod     = $_REQUEST['cod'];
  
  for($i=0; $i < count($cod); $i++) {
    $parcela->emailCobranca($cod[$i]);
  }
  
  
} else if ($_REQUEST['acao'] == 'envia_email_cobranca') {
  
  $parcela = new CobrancaAction();
  $parcela->enviaEemailCobranca();
  echo $parcela->getReturnMensage();
  
}
?>