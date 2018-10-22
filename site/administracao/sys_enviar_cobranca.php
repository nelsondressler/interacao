<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Enviar e-mail cobrança');
SystemLayout::setModule('sys_enviar_cobranca');

SystemLayout::addNavigate('Enviar e-mail cobrança');
SystemLayout::addNavigate('E-mail');

SystemLayout::setBack('home.php');
SystemLayout::setSubTitle($row_cliente['nome']);

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$cobranca = new CobrancaAction();

$row_apagar   = $cobranca->getTotalApagar();
$row_vencidos1 = $cobranca->getTotalVencidos1();
$row_vencidos2 = $cobranca->getTotalVencidos2();

?>

<?php require 'assets/blocks/header_abre.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/js/date_input/date_input.css"/>
<script type="text/javascript" src="assets/js/date_input/jquery.date_input.js"></script>

<script type="text/javascript">
function enviarCobranca() {

  if(confirm("* ATENÇÃO *\n\nDeseja realmente enviar os e-mails de cobrança?")){
    
    $('#frame_envia').attr('src', 'sys_enviar_cobranca_ifrane.php?acao=envia_email_cobranca');
    modalProcessing('Aguarde, enviando e-mails de cobrança...');
    
  }
}

function enviarVencidos1() {

  if(confirm("* ATENÇÃO *\n\nDeseja realmente enviar os e-mails de parcelas vencidas?")){
    
    $('#frame_envia').attr('src', 'sys_enviar_cobranca_ifrane.php?acao=envia_email_vencidos1');
    modalProcessing('Aguarde, enviando e-mails de parcelas vencidas a 5 dias...');
    
  }
}

function enviarVencidos2() {

  if(confirm("* ATENÇÃO *\n\nDeseja realmente enviar os e-mails de parcelas vencidas?")){
    
    $('#frame_envia').attr('src', 'sys_enviar_cobranca_ifrane.php?acao=envia_email_vencidos2');
    modalProcessing('Aguarde, enviando e-mails de parcelas vencidas a 15 dias...');
    
  }
}
</script>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<br />
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>
        Op&ccedil;&otilde;es de envio</td>
    </tr>
  </table>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
  <tr>
    <td colspan="2" align="left" valign="top" class="sub_titulo">Envio de e-mails de aviso de vencimento (5 dias antes)</td>
    </tr>
  <tr>
    <td width="24" height="50" align="left" valign="top" class="sub_titulo"><img src="assets/img/email.png" width="16" height="16" />
      
    </td>
    <td width="676" height="50" align="left" valign="top" class="sub_titulo"><a href="javascript:enviarCobranca()" class="arial15">Clique aqui para enviar <?php echo $row_apagar['total'] ?> e-mails.<br />
      <span class="arial10">Cobran&ccedil;a para parcelas que vencem hoje e no dia <?php echo $row_apagar['data'] ?></span></a></td>
    </tr>
  <tr>
    <td align="left" valign="top" class="sub_titulo">&nbsp;</td>
    <td align="left" valign="top" class="sub_titulo">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" class="sub_titulo">Envio de e-mails de aviso de parcelas j&aacute; vencidas a mais de 5 dias</td>
    </tr>
  <tr>
    <td height="50" align="left" valign="top" class="sub_titulo"><img src="assets/img/email.png" width="16" height="16" /></td>
    <td height="50" align="left" valign="top" class="sub_titulo">
      <a href="javascript:enviarVencidos1()" class="arial15">Clique aqui para enviar <?php echo $row_vencidos1['total'] ?> e-mails</a> <br />
      <span class="arial10">Cobran&ccedil;a para parcelas atrasadas que venceram no dia <?php echo $row_vencidos1['data'] ?></span>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sub_titulo">&nbsp;</td>
    <td align="left" valign="top" class="sub_titulo">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" class="sub_titulo">Envio de e-mails de aviso de parcelas j&aacute; vencidas a mais de 15 dias</td>
    </tr>
  <tr>
    <td height="50" align="left" valign="top" class="sub_titulo"><img src="assets/img/email.png" width="16" height="16" /></td>
    <td height="50" align="left" valign="top" class="sub_titulo">
      <a href="javascript:enviarVencidos2()" class="arial15">Clique aqui para enviar <?php echo $row_vencidos2['total'] ?> e-mails</a><br />
      <span class="arial10">Cobran&ccedil;a para parcelas atrasadas que venceram no dia <?php echo $row_vencidos2['data'] ?></span>
    </td>
  </tr>
</table>
<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
  <tr>
    <td> Relat&oacute;rio de envio</td>
  </tr>
</table>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="200" align="center" class="sub_titulo">
    <iframe name="frame_envia" id="frame_envia" src="sys_enviar_cobranca_ifrane.php" width="700" height="200" frameborder="1"></iframe>
    </td>
  </tr>
</table>
<igframe>
<br />

<?php require 'assets/blocks/body_fecha.php'; ?>