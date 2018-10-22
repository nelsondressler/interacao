<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require 'bootstrap.php';
require 'assets/includes/login.php';
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<body>

<?php
if (!$_REQUEST['acao']) {
?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="200" align="center" class="sub_titulo">
    
    Escolha uma op&ccedil;&atilde;o para iniciar o envio de e-mails.
    </td>
  </tr>
</table>
<?php
} else if ($_REQUEST['acao']=='envia_email_cobranca') {
  
  $parcela = new CobrancaAction();
  $parcela->enviaEmailCobranca();

  
} else if ($_REQUEST['acao']=='envia_email_vencidos1') {
  
  $parcela = new CobrancaAction();
  $parcela->enviaEmailCobrancaVencidos1();

  
} else if ($_REQUEST['acao']=='envia_email_vencidos2') {
  
  $parcela = new CobrancaAction();
  $parcela->enviaEmailCobrancaVencidos2();

  
}
?>

</body>

<script type="text/javascript">
parent.$.modal.close();
</script>

</html>