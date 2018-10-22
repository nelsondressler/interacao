<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

$cod_cliente = (integer) $_REQUEST['cod_cliente'];
if (!$cod_cliente) exit;

$clientes = new ClientesAction();

if ( !SystemLayout::getPermissao(1, 'sys_clientes') ) {
  header('location: semacesso.php');
  exit;
}

SystemLayout::setTitle('Clientes');
SystemLayout::setModule('sys_clientes_planos');

SystemLayout::addNavigate('Clientes', 'sys_clientes.php');
SystemLayout::addNavigate('Planos');
SystemLayout::setBack('sys_clientes.php');

$row_cliente  = $clientes->exibe($cod_cliente);
$row_periodos = $clientes->listaPeriodos($cod_cliente);

SystemLayout::setSubTitle($row_cliente['nome']);
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>


<table width="783" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
  <tr>
    <td>
      Lista de planos por per&iacute;odo
    </td>
  </tr>
</table>

<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  
  <form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
  <tr class="table_grid_top">
    <td width="90">&nbsp;</td>
    <td width="200">Per&iacute;odo</td>
    <td width="200">Planos</td>
    <td width="100">Valor total</td>
    <td>Data da aquisi&ccedil;&atilde;o</td>
  </tr>
  
  <?php
  foreach($row_periodos as $row) {
    ?>
    <tr>
      <td valign="top">
        
        <a href="sys_clientes_parcelas.php?cod_cli_periodo=<? echo $row["cod_cli_periodo"] ?>" class="input_title">
        <img src="assets/img/money_dollar.png" align="absmiddle" border="0"/> Parcelas</a>
          
       </td>
      <td valign="top">
        <?php echo $row["periodo"] ?>
      </td>
      <td valign="top">
        <?php
        $row_planos = $clientes->listaPlanos($row["cod_cli_periodo"]);
        foreach ($row_planos as $row_p) {
          echo $row_p['plano'] .', ';
        }
        ?>
      </td>
      <td valign="top"><?php echo Number::formatCurrencyBr($row['valor_total']) ?></td>
      <td valign="top"><?php echo Date::timestampToBr($row['data_inserido']) ?></td>

    </tr>
    <?php
  }
  ?>
  <input type="hidden" name="acao" value="excluir">
  </form>
</table>

<?php require 'assets/blocks/body_fecha.php'; ?>