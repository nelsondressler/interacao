<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require 'bootstrap.php';
require 'assets/includes/login.php';

if ( !SystemLayout::getPermissao(1, 'sys_clientes') ) {
  header('location: semacesso.php');
  exit;
}

$cod_cli_periodo = (integer) $_REQUEST['cod_cli_periodo'];
if (!$cod_cli_periodo) exit;

$clientes      = new ClientesAction();
$row_aquisicao = $clientes->listaAquisicao($cod_cli_periodo);
$row_cliente   = $clientes->exibe($row_aquisicao['periodo']['cod_cliente']);

//print_r($row_aquisicao);
//exit;

SystemLayout::setTitle('Clientes');
SystemLayout::setModule('sys_clientes_parcelas');

SystemLayout::addNavigate('Clientes', 'sys_clientes.php');
SystemLayout::addNavigate('Planos', 'sys_clientes_planos.php?cod_cliente='. $row_cliente['cod_cliente']);
SystemLayout::addNavigate('Parcelas');

SystemLayout::setBack('sys_clientes_planos.php?cod_cliente='. $row_cliente['cod_cliente']);
SystemLayout::setSubTitle($row_cliente['nome']);
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<table width="783" cellspacing="0" cellpadding="0">
 <tr>
   <td width="70" height="25" class="input_title">Per&iacute;odo:</td>
   <td width="200" ><?php echo $row_aquisicao['periodo']['periodo'] ?></td>
   <td width="80" class="input_title" >Valor total:</td>
   <td width="150" ><?php echo Number::formatCurrencyBr($row_aquisicao['periodo']['valor_total']) ?></td>
   <td width="120" ><span class="input_title">Data da aquisi&ccedil;&atilde;o:</span></td>
   <td ><?php echo Date::timestampToBr($row_aquisicao['periodo']['data_inserido']) ?></td>
 </tr>
</table>
<br />

<table width="783" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
  <tr>
    <td>
      Lista de planos
    </td>
  </tr>
</table>


<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  <tr >
    <td width="200" height="25"><strong>Plano</strong></td>
    <td width="100" height="25"><strong>Valor</strong></td>
    <td width="80" height="25"><strong>Desconto</strong></td>
    <td height="25"><strong>Valor Final</strong></td>
  </tr>
  <?php
  foreach ($row_aquisicao['planos'] as $row) {
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
<table width="783" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
  <tr>
    <td>
      Lista de parcelas
    </td>
  </tr>
</table>
<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  
  <form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
  <tr class="table_grid_top">
    <td width="70">&nbsp;</td>
    <td>Vencimnto</td>
    <td>Valor</td>
    <td>Forma</td>
    <td>N&ordm; Pedido</td>
    <td>Transa&ccedil;&atilde;o</td>
    <td>Status</td>
  </tr>
  
    <?php foreach ($row_aquisicao['parcelas'] as $row) { ?>
    <tr>
      <td valign="top">
        
        <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod_cli_parcelas=<? echo $row["cod_cli_parcelas"] ?>" class="input_title">
        <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a></td>
      <td valign="top">
        <?php echo Date::timestampToBr($row['data_vencimento']) ?>
      </td>
      <td valign="top">
      R$ <?php echo Number::formatCurrencyBr($row['valor_total']) ?>
      </td>
      <td valign="top"><?php echo $row['pagamento'] .'('. $row['pagamento_nome'] .')<br>'. $row['pagamento_status'] ?></td>
      <td valign="top"><?php foreach ($row_aquisicao['planos'] as $plan_cod) {                      echo 'P'.substr($plan_cod['plano'], 6, 1).substr(md5($plan_cod['plano']), 6, 2);                      echo $row['cod_cli_parcelas'] .'. ';					} ?></td>
      <td valign="top"><?php echo $row['pagamento_id'] ?></td>
      <td valign="top">
        <strong style="color:<?php echo '#'. Useful::statusCor($row['cod_status']) ?>"><?php echo $row['status'] ?></strong>
      </td>

    </tr>
    <?php
  }
  ?>
  <input type="hidden" name="acao" value="excluir">
  </form>
</table>

<?php require 'assets/blocks/body_fecha.php'; ?>