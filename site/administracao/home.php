<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Home');

if ($_REQUEST['acao'] == 'idioma') {
  
  IdiomasHelper::setIdioma($_REQUEST['idioma']);
  header('location: home.php');
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
  <tr>
    <td> Descri&ccedil;&atilde;o dos icones utilizados no sistema</td>
  </tr>
</table>
<table width="700" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td width="28" height="30" align="center"><img src="assets/img/ver.png" width="16" height="16" border="0" align="absmiddle"/></td>
    <td width="250" height="30">Exibe um registro.</td>
    <td width="30" height="30" align="center"><img src="assets/img/menos2.png" width="16" height="16" border="0" align="absbottom" /></td>
    <td height="30">Retira da lista um registro.</td>
  </tr>
  <tr>
    <td height="30" align="center"><img src="assets/img/mais.png" width="16" height="16" /></td>
    <td width="250" height="30">Adiciona um registro.</td>
    <td width="30" height="30" align="center"><img src="assets/img/mais2.png" width="16" height="16" border="0" align="absbottom" /></td>
    <td height="30">Adiciona a lista um registro.</td>
  </tr>
  <tr>
    <td height="30" align="center"><img src="assets/img/excluir.png" width="16" height="16" align="absmiddle" /></td>
    <td width="250" height="30">Excluir uma informa&ccedil;&atilde;o ou registro.</td>
    <td width="30" height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
</table>
<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
  <tr>
    <td> Descri&ccedil;&atilde;o dos icones do menu superios</td>
  </tr>
</table>
<table width="700" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td width="28" height="30" align="center"><img src="assets/img/users.png" width="16" height="16" /></td>
    <td width="250" height="30">Lista de usu&aacute;rios desta administra&ccedil;&atilde;o.</td>
    <td width="30" height="30" align="center"><img src="assets/img/ico_web_b.gif" width="18" height="18" /></td>
    <td height="30">Abrir o site.</td>
  </tr>
  <tr>
    <td height="30" align="center"><img src="assets/img/ico_config_b.gif" width="18" height="18" /></td>
    <td height="30">Configura&ccedil;&otilde;es gerais do site.</td>
    <td height="30" align="center"><img src="assets/img/ico_sair_b.gif" width="18" height="18" /></td>
    <td height="30">Sair do Sistema (logoff).</td>
  </tr>
</table>
<p><br />
</p>
<?php require 'assets/blocks/body_fecha.php'; ?>