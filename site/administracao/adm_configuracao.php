<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('<img src="assets/img/ico_config_b.gif" align="absmiddle" /> Configurações da administração');
SystemLayout::setModule('adm_configuracao');
SystemLayout::addNavigate('Configurações da administração');
SystemLayout::setBack(System::thisFile());

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$configuracao = new AdministracaoConfigAction();

// Altera
if ($_POST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3) ) {
    $configuracao->grava(false, $_POST);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<?php
if ($configuracao->getReturnMensage()) {
  
  echo SystemLayout::msgBox($configuracao->getReturnMensage());
  
} else {
?>

<table width="770" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td bgcolor="#FFFFCC">A senha &eacute; necess&aacute;ria para enviar um e-mail autenticado.<br />
      Atualmente a maioria dos servidores Brasileiros est&aacute; exigindo a autentica&ccedil;&atilde;o  dos e-mails para maior seguran&ccedil;a.</td>
  </tr>
</table>
<br />
<form action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)">
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td><strong><img src="assets/img/email.png" width="16" height="16" align="absmiddle" /></strong> Conta de e-mail SMTP</td>
    </tr>
  </table>
  <table width="770" border="0" cellspacing="0" cellpadding="0" class="table_form" align="center">
    <tr>
      <td height="30" colspan="2" class="arial10" > Conta de  e-mail  encarregado de enviar as informa&ccedil;&otilde;es de qualquer formul&aacute;rio. Esta conta s&oacute; ser&aacute; utilizada para enviar e-mails.</td>
    </tr>
    <tr>
      <td width="74" height="30" class="input_title"> E-mail: </td>
      <td width="696" height="30"><input name="email_sistema_login" type="text" id="email_sistema_login" value="<? echo OpcoesHelper::get('email_sistema_login') ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Senha:</td>
      <td height="30" class="arial10"><input name="email_sistema_senha" type="password" id="email_sistema_senha" value="<? echo Security::decripty(OpcoesHelper::get('email_sistema_senha')) ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Host smtp:</td>
      <td height="30" class="arial10"><input name="email_sistema_host" type="text" id="email_sistema_host" value="<? echo OpcoesHelper::get('email_sistema_host') ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Porta smtp:</td>
      <td height="30" class="arial10"><input name="email_sistema_porta" type="text" id="email_sistema_porta" value="<? echo OpcoesHelper::get('email_sistema_porta') ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Seguran&ccedil;a:</td>
      <td height="30" class="arial10">
      
      <select name="email_sistema_seguranca" id="email_sistema_seguranca">
        <?php
        $array = array( array('nome'=>'SSL','tipo'=>'ssl'), array('nome'=>'TLS','tipo'=>'tls') );
        echo Html::selectOption($array, 'nome', 'tipo', OpcoesHelper::get('email_sistema_seguranca'));
        ?>
      </select>
      
      </td>
    </tr>
  </table>
  <br />
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td><strong><img src="assets/img/email.png" width="16" height="16" align="absmiddle" /></strong> E-mail de contato</td>
    </tr>
  </table>
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td height="30" colspan="2" class="arial10"><p>Contas de e-mails para onde ser&aacute;  enviado as informa&ccedil;&otilde;es dos formul&aacute;rios de contato.
        Para cada contato voc&ecirc; pode digitar mais de um  e-mail separando-os com ponto e virgula &ldquo;;&rdquo;. O primeiro e-mail ser&aacute; considerado  como principal os demais ser&atilde;o enviados como c&oacute;pia.</p></td>
    </tr>
    <tr>
      <td width="74" height="30" class="input_title"> Contato: </td>
      <td width="696" height="30"><textarea name="email_contato" cols="100" rows="3" id="email_contato"><? echo OpcoesHelper::get('email_contato') ?></textarea></td>
    </tr>
  </table>
  <?php
$acao = '';

if ( SystemLayout::getPermissao(3)) {
  $botao_submit = 'Alterar';
  $acao         = 'alterar';
}

if ($acao) {
  echo '<div id="painel_submit">
  <input name="button" type="submit" class="botao_submit" value="'. $botao_submit .'" />
  <input type="hidden" name="acao" value="'. $acao .'">
  <input type="hidden" name="cod" value="'. $_GET["cod"] .'">
  </div>';
}
?>
</form>

<script type="text/javascript">
var f = document.frm;
</script>

<?php
}
?>

<?php require 'assets/blocks/body_fecha.php'; ?>