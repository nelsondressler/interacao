<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require 'bootstrap.php';
require 'assets/includes/login.php';

if ( !SystemLayout::getPermissao(1, 'sys_clientes') ) {
  header('location: semacesso.php');
  exit;
}

$cod_cli_parcelas = (integer) $_REQUEST['cod_cli_parcelas'];
if (!$cod_cli_parcelas) exit;

$clientes    = new ClientesAction();
$row_parcela = $clientes->exibeParcela($cod_cli_parcelas);
$row_cliente = $clientes->exibe($row_parcela['cod_cliente']);

//print_r($row_parcela);
//exit;

SystemLayout::setTitle('Clientes');
SystemLayout::setModule('sys_clientes_parcelas');

SystemLayout::addNavigate('Clientes', 'sys_clientes.php');
SystemLayout::addNavigate('Planos', 'sys_clientes_planos.php?cod_cliente='. $row_cliente['cod_cliente']);
SystemLayout::addNavigate('Parcelas', 'sys_clientes_parcelas.php?cod_cli_periodo='. $row_parcela['cod_cli_periodo']);
SystemLayout::addNavigate('Edita');

SystemLayout::setBack('sys_clientes_parcelas.php?cod_cli_periodo='. $row_parcela['cod_cli_periodo']);
SystemLayout::setSubTitle($row_cliente['nome']);


if ($_POST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3, 'sys_clientes') ) {
    $clientes->alteraParcela($_POST);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<script type="text/javascript">
function validaDados(f) {

  if(validaSelecao(f.cod_status)) {
    return abreAlerta("Escolha o Status.");
  }
  
  modalProcessing('Aguarde ...');
  
}

$(function($) {

  
});
</script>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<?php
if ($clientes->getReturnMensage()) {
  
  echo SystemLayout::msgBox($clientes->getReturnMensage());
  
} else {
?>
<br>

  <form name="frm" action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)" enctype="multipart/form-data">
  <table width="770" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td width="70" height="25" class="input_title">Per&iacute;odo:</td>
     <td width="200" ><?php echo $row_parcela['periodo'] ?></td>
     <td width="80" class="input_title" >Valor total:</td>
     <td width="150" ><?php echo Number::formatCurrencyBr($row_parcela['valor_total']) ?></td>
     <td width="120" ><span class="input_title">Data da aquisi&ccedil;&atilde;o:</span></td>
     <td ><?php echo Date::timestampToBr($row_parcela['data_inserido']) ?></td>
   </tr>
  </table>
  <br />
  
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>
        Lista de planos
      </td>
    </tr>
  </table>
  
  
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_grid">
    <tr>
      <td width="200"><strong>Plano</strong></td>
      <td width="100"><strong>Valor</strong></td>
      <td width="80"><strong>Desconto</strong></td>
      <td><strong>Valor Final</strong></td>
    </tr>
    <?php
    foreach ($row_parcela['planos'] as $row) {
    ?>
    <tr>
      <td valign="top"> <?php echo $row['plano'] ?> </td>
      <td valign="top"> R$ <?php echo Number::formatCurrencyBr($row['valor_real']) ?> </td>
      <td valign="top"><?php echo $row['desconto'] ?>%</td>
      <td valign="top"><?php echo Number::formatCurrencyBr($row['valor']) ?></td>
      </tr>
    <?php
  }
  ?>
  </table>
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>Dados da parcela</td>
    </tr>
</table>
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">

    <tr>
      <td width="120" height="30" class="input_title">Status atual:</td>
      <td width="250" height="30"><?php echo Html::select('cod_status', $clientes->listaStatusParcela(), 'status', 'cod_status', $row_parcela['cod_status'], 'requerido') ?></td>
      <td width="150" class="input_title">Pagamento forma:</td>
      <td><?php echo $row_parcela['pagamento'] ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">N&ordm; do pedido:</td>
      <td height="30"><?php echo $row_parcela['num_pedido'] ?></td>
      <td height="30" class="input_title">Pagamento nome:</td>
      <td height="30"><?php echo $row_parcela['pagamento_nome'] ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Data vencimento:</td>
      <td height="30"><?php echo Date::timestampToBr($row_parcela['data_vencimento']) ?></td>
      <td height="30" class="input_title">Pagamento status:</td>
      <td height="30"><?php echo $row_parcela['pagamento_status'] ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Data pagamento:</td>
      <td height="30"><?php echo Date::timestampToBr($row_parcela['data_pagamento']) ?></td>
      <td height="30" class="input_title">Pagamento cod status:</td>
      <td height="30"><?php echo $row_parcela['pagamento_cod'] ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">&nbsp;</td>
      <td height="30">&nbsp;</td>
      <td height="30" class="input_title">Pagamendo ID:</td>
      <td height="30"><?php echo $row_parcela['pagamento_id'] ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">&nbsp;</td>
      <td height="30">&nbsp;</td>
      <td height="30"><span class="input_title">Pagamento Data trans.:</span></td>
      <td height="30"><?php echo $row_parcela['pagamento_trans_data'] ?></td>
    </tr>
  </table>
  <?php
  $acao = '';

  $botao_submit = 'Alterar';
  $acao         = 'alterar';
  
  if ($acao) {
    echo '<div id="painel_submit">
    <input name="button" type="submit" class="botao_submit" value="'. $botao_submit .'" />
    <input type="hidden" name="acao" value="'. $acao .'">
    <input type="hidden" name="cod_cli_parcelas" value="'. $cod_cli_parcelas .'">
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